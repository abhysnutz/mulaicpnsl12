<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;

class MonitoringController extends Controller
{
    public function index()
    {
        return view('backend.monitoring.index');
    }

    /**
     * Endpoint AJAX: kembalikan snapshot resource saat ini.
     */
    public function stats()
    {
        $stats = [
            'time'   => now()->format('H:i:s'),
            'cpu'    => $this->cpuUsage(),
            'memory' => $this->memoryUsage(),
            'disk'   => $this->diskUsage(),
        ];

        // Simpan history ringan di Redis (maks 60 titik = ~5 menit kalau poll 5s)
        try {
            Redis::rpush('monitoring:history', json_encode([
                'time' => $stats['time'],
                'cpu'  => $stats['cpu']['percent'],
                'mem'  => $stats['memory']['percent'],
            ]));
            Redis::ltrim('monitoring:history', -60, -1);
        } catch (\Throwable $e) {
            // Redis opsional, jangan sampai gagal total
        }

        return response()->json($stats);
    }

    /**
     * Endpoint AJAX: kembalikan history dari Redis (untuk isi grafik saat load).
     */
    public function history()
    {
        try {
            $raw = Redis::lrange('monitoring:history', 0, -1);
            $data = array_map(fn ($r) => json_decode($r, true), $raw);
        } catch (\Throwable $e) {
            $data = [];
        }

        return response()->json($data);
    }

    /**
     * CPU usage % via /proc/stat (2 sampling, jeda 200ms).
     */
    private function cpuUsage(): array
    {
        if (! is_readable('/proc/stat')) {
            return ['percent' => null, 'cores' => null];
        }

        $s1 = $this->readCpuStat();
        usleep(200000); // 200ms
        $s2 = $this->readCpuStat();

        $totalDiff = $s2['total'] - $s1['total'];
        $idleDiff  = $s2['idle'] - $s1['idle'];

        $percent = $totalDiff > 0
            ? round((1 - $idleDiff / $totalDiff) * 100, 1)
            : 0.0;

        return [
            'percent' => max(0, min(100, $percent)),
            'cores'   => (int) (shell_exec('nproc 2>/dev/null') ?: 1),
        ];
    }

    private function readCpuStat(): array
    {
        $line = explode("\n", file_get_contents('/proc/stat'))[0];
        $parts = preg_split('/\s+/', trim($line));
        array_shift($parts); // buang "cpu"
        $parts = array_map('intval', $parts);

        $idle  = ($parts[3] ?? 0) + ($parts[4] ?? 0); // idle + iowait
        $total = array_sum($parts);

        return ['idle' => $idle, 'total' => $total];
    }

    /**
     * RAM usage via /proc/meminfo (pakai MemAvailable, lebih akurat).
     */
    private function memoryUsage(): array
    {
        if (! is_readable('/proc/meminfo')) {
            return ['percent' => null, 'used_mb' => null, 'total_mb' => null];
        }

        $info = [];
        foreach (explode("\n", file_get_contents('/proc/meminfo')) as $line) {
            if (preg_match('/^(\w+):\s+(\d+)/', $line, $m)) {
                $info[$m[1]] = (int) $m[2]; // kB
            }
        }

        $total = $info['MemTotal'] ?? 0;
        $avail = $info['MemAvailable'] ?? ($info['MemFree'] ?? 0);
        $used  = $total - $avail;

        return [
            'percent'  => $total > 0 ? round($used / $total * 100, 1) : null,
            'used_mb'  => round($used / 1024),
            'total_mb' => round($total / 1024),
        ];
    }

    /**
     * Disk usage root filesystem.
     */
    private function diskUsage(): array
    {
        $total = @disk_total_space('/');
        $free  = @disk_free_space('/');

        if (! $total) {
            return ['percent' => null, 'used_gb' => null, 'total_gb' => null];
        }

        $used = $total - $free;

        return [
            'percent'  => round($used / $total * 100, 1),
            'used_gb'  => round($used / 1073741824, 1),
            'total_gb' => round($total / 1073741824, 1),
        ];
    }
}