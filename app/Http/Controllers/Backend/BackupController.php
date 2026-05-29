<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Process\Process;

class BackupController extends Controller
{
    private $backupPath;

    public function __construct()
    {
        $this->backupPath = storage_path('app/backups');

        if (!file_exists($this->backupPath)) {
            mkdir($this->backupPath, 0755, true);
        }
    }

    public function index()
    {
        $backups = collect(glob("{$this->backupPath}/*.sql*"))
            ->map(fn($file) => (object) [
                'name' => basename($file),
                'size' => $this->formatBytes(filesize($file)),
                'created_at' => date('d-M-Y H:i', filemtime($file)),
            ])
            ->sortByDesc('created_at')
            ->values();

        return view('backend.backup.index', compact('backups'));
    }

    public function export()
    {
        $timestamp = now()->format('Ymd_His');
        $filename = "backup_{$timestamp}.sql.gz";
        $path = "{$this->backupPath}/{$filename}";

        $db = config('database.connections.mysql');

        $ignoreTables = [
            'sessions', 'cache', 'cache_locks',
            'jobs', 'failed_jobs', 'password_reset_tokens'
        ];
        $ignoreArgs = collect($ignoreTables)
            ->map(fn($t) => "--ignore-table={$db['database']}.{$t}")
            ->implode(' ');

        $command = sprintf(
            'mysqldump -h%s -P%s -u%s -p%s --single-transaction --skip-ssl %s %s | gzip > %s',
            escapeshellarg($db['host']),
            escapeshellarg($db['port']),
            escapeshellarg($db['username']),
            escapeshellarg($db['password']),
            $ignoreArgs,
            escapeshellarg($db['database']),
            escapeshellarg($path)
        );

        $process = Process::fromShellCommandline($command);
        $process->setTimeout(300);
        $process->run();

        if (!$process->isSuccessful()) {
            return back()->with('error', 'Export gagal: ' . $process->getErrorOutput());
        }

        return back()->with('success', "Backup berhasil dibuat: {$filename}");
    }

    public function upload(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|file|max:512000', // max 500MB
        ]);

        if ($validator->fails()) {
            return back()->with('error', 'File tidak valid (max 500MB)');
        }

        $file = $request->file('file');
        $extension = strtolower($file->getClientOriginalExtension());

        if (!in_array($extension, ['sql', 'gz'])) {
            return back()->with('error', 'Format file harus .sql atau .sql.gz');
        }

        $originalName = $file->getClientOriginalName();
        $filename = 'uploaded_' . now()->format('Ymd_His') . '_' . $originalName;
        $file->move($this->backupPath, $filename);

        return back()->with('success', "File '{$originalName}' berhasil di-upload. Klik tombol Import untuk restore database.");
    }

    public function import($filename)
    {
        $path = "{$this->backupPath}/{$filename}";

        if (!file_exists($path)) {
            return back()->with('error', 'File tidak ditemukan');
        }

        $db = config('database.connections.mysql');
        $isGzipped = str_ends_with($filename, '.gz');

        if ($isGzipped) {
            $command = sprintf(
                'gunzip -c %s | mysql --skip-ssl -h%s -P%s -u%s -p%s %s',
                escapeshellarg($path),
                escapeshellarg($db['host']),
                escapeshellarg($db['port']),
                escapeshellarg($db['username']),
                escapeshellarg($db['password']),
                escapeshellarg($db['database'])
            );
        } else {
            $command = sprintf(
                'mysql --skip-ssl -h%s -P%s -u%s -p%s %s < %s',
                escapeshellarg($db['host']),
                escapeshellarg($db['port']),
                escapeshellarg($db['username']),
                escapeshellarg($db['password']),
                escapeshellarg($db['database']),
                escapeshellarg($path)
            );
        }

        $process = Process::fromShellCommandline($command);
        $process->setTimeout(600);
        $process->run();

        if (!$process->isSuccessful()) {
            return back()->with('error', 'Import gagal: ' . $process->getErrorOutput());
        }

        return back()->with('success', "Database berhasil di-restore dari '{$filename}'");
    }

    public function download($filename)
    {
        $path = "{$this->backupPath}/{$filename}";

        if (!file_exists($path)) {
            abort(404, 'File tidak ditemukan');
        }

        return response()->download($path);
    }

    public function destroy($filename)
    {
        $path = "{$this->backupPath}/{$filename}";

        if (!file_exists($path)) {
            return back()->with('error', 'File tidak ditemukan');
        }

        unlink($path);

        return back()->with('success', "Backup '{$filename}' berhasil dihapus");
    }

    private function formatBytes($bytes)
    {
        if ($bytes >= 1073741824) return round($bytes / 1073741824, 2) . ' GB';
        if ($bytes >= 1048576) return round($bytes / 1048576, 2) . ' MB';
        if ($bytes >= 1024) return round($bytes / 1024, 2) . ' KB';
        return $bytes . ' B';
    }

    public function migrateFresh()
    {
        try {
            // 1. Drop semua tabel & re-create + seed
            \Artisan::call('migrate:fresh', [
                '--seed' => true,
                '--force' => true,
            ]);
            $migrateOutput = \Artisan::output();

            // 2. Clear semua cache Laravel
            \Artisan::call('cache:clear');        // Application cache (Redis/file)
            \Artisan::call('config:clear');       // Config cache
            \Artisan::call('route:clear');        // Route cache
            \Artisan::call('view:clear');         // Compiled views
            
            // 3. (Optional) Flush Redis session — biar user current ke-logout
            \Illuminate\Support\Facades\Redis::connection()->flushdb();

            return redirect()->route('login')->with('success', '✅ Database & cache berhasil di-reset. Silakan login ulang.');
        } catch (\Exception $e) {
            return back()->with('error', 'Migrate fresh gagal: ' . $e->getMessage());
        }
    }
}