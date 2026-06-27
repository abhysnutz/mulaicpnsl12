<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
        // Dukung backup lama (.sql/.sql.gz) dan baru (.tar.gz)
        $files = array_merge(
            glob("{$this->backupPath}/*.sql"),
            glob("{$this->backupPath}/*.sql.gz"),
            glob("{$this->backupPath}/*.tar.gz")
        );

        $backups = collect($files)
            ->map(fn($file) => (object) [
                'name' => basename($file),
                'size' => $this->formatBytes(filesize($file)),
                'created_at' => date('d-M-Y H:i', filemtime($file)),
                'type' => str_ends_with($file, '.tar.gz') ? 'Full (DB + Gambar + Materi)' : 'Database',
            ])
            ->sortByDesc('created_at')
            ->values();

        return view('backend.backup.index', compact('backups'));
    }

    public function export()
    {
        $timestamp = now()->format('Ymd_His');
        $filename = "backup_{$timestamp}.tar.gz";
        $path = "{$this->backupPath}/{$filename}";

        $db = config('database.connections.mysql');

        // Folder kerja sementara untuk merakit isi backup
        $workDir = "{$this->backupPath}/tmp_{$timestamp}";
        if (!file_exists($workDir)) {
            mkdir($workDir, 0755, true);
        }

        $ignoreTables = [
            'sessions', 'cache', 'cache_locks',
            'jobs', 'failed_jobs', 'password_reset_tokens',
        ];
        $ignoreArgs = collect($ignoreTables)
            ->map(fn($t) => "--ignore-table={$db['database']}.{$t}")
            ->implode(' ');

        $sqlFile = "{$workDir}/database.sql";

        // 1. Dump SQL ke file di dalam workdir
        $dumpCmd = sprintf(
            'mysqldump -h%s -P%s -u%s -p%s --single-transaction --skip-ssl %s %s > %s',
            escapeshellarg($db['host']),
            escapeshellarg($db['port']),
            escapeshellarg($db['username']),
            escapeshellarg($db['password']),
            $ignoreArgs,
            escapeshellarg($db['database']),
            escapeshellarg($sqlFile)
        );

        $proc = Process::fromShellCommandline($dumpCmd);
        $proc->setTimeout(300);
        $proc->run();

        if (!$proc->isSuccessful()) {
            $this->cleanupDir($workDir);
            return back()->with('error', 'Export gagal (dump SQL): ' . $proc->getErrorOutput());
        }

        // 2. Salin folder gambar (storage/app/public) ke workdir/storage
        $publicStorage = storage_path('app/public');
        if (is_dir($publicStorage)) {
            $copyCmd = sprintf('cp -r %s %s', escapeshellarg($publicStorage), escapeshellarg("{$workDir}/storage"));
            $copyProc = Process::fromShellCommandline($copyCmd);
            $copyProc->setTimeout(300);
            $copyProc->run();
            // Kalau gagal copy, lanjut saja (backup DB tetap berguna), tapi catat
        }

        // 3. Salin folder materi PDF (disk 'local' = storage/app/private/material) ke workdir/material
        $materialStorage = Storage::disk('local')->path('material');
        if (is_dir($materialStorage)) {
            $copyMatCmd = sprintf('cp -r %s %s', escapeshellarg($materialStorage), escapeshellarg("{$workDir}/material"));
            $copyMatProc = Process::fromShellCommandline($copyMatCmd);
            $copyMatProc->setTimeout(300);
            $copyMatProc->run();
            // Kalau gagal copy, lanjut saja (backup DB + gambar tetap berguna)
        }

        // 4. Bungkus workdir jadi satu .tar.gz
        $tarCmd = sprintf('tar -czf %s -C %s .', escapeshellarg($path), escapeshellarg($workDir));
        $tarProc = Process::fromShellCommandline($tarCmd);
        $tarProc->setTimeout(300);
        $tarProc->run();

        // 5. Bersihkan workdir
        $this->cleanupDir($workDir);

        if (!$tarProc->isSuccessful()) {
            return back()->with('error', 'Export gagal (kompres): ' . $tarProc->getErrorOutput());
        }

        return back()->with('success', "Backup lengkap (DB + Gambar + Materi) berhasil dibuat: {$filename}");
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
        $name = strtolower($file->getClientOriginalName());

        // Terima .sql, .sql.gz, .tar.gz
        $valid = str_ends_with($name, '.sql')
            || str_ends_with($name, '.sql.gz')
            || str_ends_with($name, '.tar.gz');

        if (!$valid) {
            return back()->with('error', 'Format file harus .sql, .sql.gz, atau .tar.gz');
        }

        $originalName = $file->getClientOriginalName();
        $filename = 'uploaded_' . now()->format('Ymd_His') . '_' . $originalName;
        $file->move($this->backupPath, $filename);

        return back()->with('success', "File '{$originalName}' berhasil di-upload. Klik tombol Import untuk restore.");
    }

    public function import($filename)
    {
        $path = "{$this->backupPath}/{$filename}";

        if (!file_exists($path)) {
            return back()->with('error', 'File tidak ditemukan');
        }

        $db = config('database.connections.mysql');

        // === Backup penuh (.tar.gz): restore DB + gambar + materi ===
        if (str_ends_with($filename, '.tar.gz')) {
            return $this->importFull($path, $db, $filename);
        }

        // === Backup lama (.sql / .sql.gz): restore DB saja ===
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

    private function importFull($path, $db, $filename)
    {
        $timestamp = now()->format('Ymd_His');
        $workDir = "{$this->backupPath}/restore_{$timestamp}";
        mkdir($workDir, 0755, true);

        // 1. Ekstrak .tar.gz ke workdir
        $extractCmd = sprintf('tar -xzf %s -C %s', escapeshellarg($path), escapeshellarg($workDir));
        $exProc = Process::fromShellCommandline($extractCmd);
        $exProc->setTimeout(300);
        $exProc->run();

        if (!$exProc->isSuccessful()) {
            $this->cleanupDir($workDir);
            return back()->with('error', 'Import gagal (ekstrak): ' . $exProc->getErrorOutput());
        }

        // 2. Restore SQL
        $sqlFile = "{$workDir}/database.sql";
        if (!file_exists($sqlFile)) {
            $this->cleanupDir($workDir);
            return back()->with('error', 'Import gagal: database.sql tidak ditemukan dalam backup');
        }

        $restoreCmd = sprintf(
            'mysql --skip-ssl -h%s -P%s -u%s -p%s %s < %s',
            escapeshellarg($db['host']),
            escapeshellarg($db['port']),
            escapeshellarg($db['username']),
            escapeshellarg($db['password']),
            escapeshellarg($db['database']),
            escapeshellarg($sqlFile)
        );

        $rProc = Process::fromShellCommandline($restoreCmd);
        $rProc->setTimeout(600);
        $rProc->run();

        if (!$rProc->isSuccessful()) {
            $this->cleanupDir($workDir);
            return back()->with('error', 'Import gagal (restore DB): ' . $rProc->getErrorOutput());
        }

        // 3. Balikin folder gambar ke storage/app/public
        $extractedStorage = "{$workDir}/storage";
        if (is_dir($extractedStorage)) {
            $publicStorage = storage_path('app/public');
            // Salin isi (timpa file yang ada)
            $copyCmd = sprintf('cp -r %s/. %s/', escapeshellarg($extractedStorage), escapeshellarg($publicStorage));
            $cpProc = Process::fromShellCommandline($copyCmd);
            $cpProc->setTimeout(300);
            $cpProc->run();
        }

        // 4. Balikin folder materi PDF ke disk 'local' (storage/app/private/material)
        $extractedMaterial = "{$workDir}/material";
        if (is_dir($extractedMaterial)) {
            $materialStorage = Storage::disk('local')->path('material');
            if (!is_dir($materialStorage)) {
                mkdir($materialStorage, 0755, true);
            }
            // Salin isi (timpa file yang ada)
            $copyMatCmd = sprintf('cp -r %s/. %s/', escapeshellarg($extractedMaterial), escapeshellarg($materialStorage));
            $cpMatProc = Process::fromShellCommandline($copyMatCmd);
            $cpMatProc->setTimeout(300);
            $cpMatProc->run();
        }

        // 5. Bersihkan
        $this->cleanupDir($workDir);

        return back()->with('success', "Restore lengkap (DB + Gambar + Materi) berhasil dari '{$filename}'");
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

    private function cleanupDir($dir)
    {
        if (!is_dir($dir)) return;
        $proc = Process::fromShellCommandline(sprintf('rm -rf %s', escapeshellarg($dir)));
        $proc->run();
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
            \Artisan::call('migrate:fresh', [
                '--seed' => true,
                '--force' => true,
            ]);
            $migrateOutput = \Artisan::output();

            // Hapus semua gambar soal (file yatim setelah DB di-reset)
            \Illuminate\Support\Facades\Storage::disk('public')->deleteDirectory('question');

            \Artisan::call('cache:clear');
            \Artisan::call('config:clear');
            \Artisan::call('route:clear');
            \Artisan::call('view:clear');

            \Illuminate\Support\Facades\Redis::connection()->flushdb();

            return redirect()->route('login')->with('success', 'Database, gambar soal & cache berhasil di-reset. Silakan login ulang.');
        } catch (\Exception $e) {
            return back()->with('error', 'Migrate fresh gagal: ' . $e->getMessage());
        }
    }
}