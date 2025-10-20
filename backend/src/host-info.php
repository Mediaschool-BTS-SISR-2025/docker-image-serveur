<?php
header('Content-Type: application/json');

// Encapsule tout dans un try...catch pour ne jamais avoir d'erreur fatale
try {
    function safe_get_contents($path) { return @file_get_contents($path) ?: ''; }
    function parse_key_value($content) {
        $data = [];
        foreach (explode("\n", $content) as $line) {
            $parts = explode(':', $line, 2);
            if (count($parts) === 2) $data[trim($parts[0])] = trim($parts[1]);
        }
        return $data;
    }

    // CPU
    $cpu_content = safe_get_contents('/proc/cpuinfo');
    preg_match('/^model name\s+:\s+(.*)/m', $cpu_content, $model_match);
    $model = preg_replace('/@.*$/', '', $model_match[1] ?? 'N/A');
    $cores = preg_match_all('/^processor/m', $cpu_content);
    $freq_khz = (int)safe_get_contents('/sys/devices/system/cpu/cpu0/cpufreq/scaling_cur_freq');
    $freq_ghz = $freq_khz > 0 ? round($freq_khz / 1000000, 2) : 'N/A';

    // RAM
    $mem_info = parse_key_value(safe_get_contents('/proc/meminfo'));
    $mem_total_kb = (int)preg_replace('/\D/', '', $mem_info['MemTotal'] ?? '0');
    $mem_avail_kb = (int)preg_replace('/\D/', '', $mem_info['MemAvailable'] ?? '0');
    $mem_used_kb = ($mem_total_kb > 0 && $mem_avail_kb > 0) ? $mem_total_kb - $mem_avail_kb : 0;
    $mem_percentage = $mem_total_kb > 0 ? round(($mem_used_kb / $mem_total_kb) * 100) : 0;

    // Disque
    $disk_total = @disk_total_space('/');
    $disk_free = @disk_free_space('/');
    $disk_used = ($disk_total && $disk_free) ? $disk_total - $disk_free : 0;
    $disk_percentage = $disk_total > 0 ? round(($disk_used / $disk_total) * 100) : 0;

    $host_info = [
        'cpu' => ['model' => $model, 'cores' => $cores ?: 'N/A', 'frequency_ghz' => $freq_ghz],
        'memory' => ['used_gb' => round($mem_used_kb / 1048576, 2), 'total_gb' => round($mem_total_kb / 1048576, 2), 'percentage' => $mem_percentage],
        'disk' => ['used_gb' => round($disk_used / 1073741824, 2), 'total_gb' => round($disk_total / 1073741824, 2), 'percentage' => $disk_percentage]
    ];
    
    echo json_encode($host_info);

} catch (Throwable $e) {
    // Si une erreur imprévue se produit, on renvoie un JSON d'erreur propre
    http_response_code(500);
    echo json_encode(['error' => ['message' => 'Erreur interne du serveur: ' . $e->getMessage()]]);
}