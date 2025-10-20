<?php
header('Content-Type: application/json');

// --- Fonctions Utilitaires ---
function get_stat($filePath) {
    return file_exists($filePath) ? (int)trim(file_get_contents($filePath)) : 0;
}

function parse_key_value_file($filePath) {
    $data = [];
    if (file_exists($filePath)) {
        $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            $parts = preg_split('/\s+/', $line, 2);
            if (count($parts) === 2) {
                $data[$parts[0]] = (int)$parts[1];
            }
        }
    }
    return $data;
}

// --- Récupération des Données ---

// -- Mémoire --
$mem_usage_bytes = get_stat('/sys/fs/cgroup/memory.current');
if ($mem_usage_bytes === 0) {
    $mem_usage_bytes = get_stat('/sys/fs/cgroup/memory/memory.usage_in_bytes');
}
$mem_limit_bytes = get_stat('/sys/fs/cgroup/memory.max');
if ($mem_limit_bytes === 0) {
    $mem_limit_bytes = get_stat('/sys/fs/cgroup/memory/memory.limit_in_bytes');
}
if ($mem_limit_bytes > 1e18) $mem_limit_bytes = 0; // "Unlimited"

$mem_stats = parse_key_value_file('/sys/fs/cgroup/memory.stat');
if (empty($mem_stats)) {
    $mem_stats = parse_key_value_file('/sys/fs/cgroup/memory/memory.stat');
}
$mem_anon_bytes = $mem_stats['anon'] ?? $mem_stats['total_active_anon'] ?? 0;
$mem_file_bytes = $mem_stats['file'] ?? $mem_stats['total_active_file'] ?? 0;

// -- CPU --
$cpu_stats = parse_key_value_file('/sys/fs/cgroup/cpu.stat');
$cpu_usage_ms = ($cpu_stats['usage_usec'] ?? 0) / 1000;
$cpu_user_ms = ($cpu_stats['user_usec'] ?? 0) / 1000;
$cpu_system_ms = ($cpu_stats['system_usec'] ?? 0) / 1000;

if (empty($cpu_stats)) { // Fallback cgroup v1
    $cpu_usage_ns = get_stat('/sys/fs/cgroup/cpu/cpuacct.usage');
    $cpu_usage_ms = $cpu_usage_ns / 1_000_000;
}

// -- I/O Disque --
$io_stats = parse_key_value_file('/sys/fs/cgroup/io.stat');
if (empty($io_stats)) {
    $io_stats = parse_key_value_file('/sys/fs/cgroup/blkio/blkio.throttle.io_service_bytes');
}
$io_read_bytes = 0;
$io_write_bytes = 0;
foreach($io_stats as $key => $value) {
    if (strpos($key, 'rbytes') !== false) $io_read_bytes += $value;
    if (strpos($key, 'wbytes') !== false) $io_write_bytes += $value;
}

// -- PIDs (Processus) --
$pids_current = get_stat('/sys/fs/cgroup/pids.current');
if ($pids_current === 0) {
    $pids_current = get_stat('/sys/fs/cgroup/pids/pids.current');
}


// --- Assemblage Final ---
$stats = [
    'Name' => gethostname(),
    'Memory_Usage_MB' => round($mem_usage_bytes / 1024 / 1024, 2),
    'Memory_Limit_MB' => $mem_limit_bytes > 0 ? round($mem_limit_bytes / 1024 / 1024, 2) : 'Unlimited',
    'Memory_Detail_MB' => [
        'Application' => round($mem_anon_bytes / 1024 / 1024, 2),
        'FileCache'   => round($mem_file_bytes / 1024 / 1024, 2)
    ],
    'CPU_Total_ms' => round($cpu_usage_ms, 2),
    'CPU_Detail_ms' => [
        'User'   => round($cpu_user_ms ?? 0, 2),
        'System' => round($cpu_system_ms ?? 0, 2)
    ],
    'IO_MB' => [
        'Read'  => round($io_read_bytes / 1024 / 1024, 2),
        'Write' => round($io_write_bytes / 1024 / 1024, 2)
    ],
    'Processes' => $pids_current
];

echo json_encode($stats);