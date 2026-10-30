<?php
declare(strict_types=1);
$root = dirname(__DIR__);
$since = gmdate('Y-m-d', time() - 7 * 86400);
$query = rawurlencode('pushed:>=' . $since . ' stars:>10 fork:false');
$url = "https://api.github.com/search/repositories?q={$query}&sort=stars&order=desc&per_page=10";
$headers = "User-Agent: buyhub-weekly-trends\r\nAccept: application/vnd.github+json\r\n";
if ($token = getenv('GITHUB_TOKEN')) $headers .= "Authorization: Bearer {$token}\r\n";
$ctx = stream_context_create(['http' => ['method' => 'GET', 'header' => $headers, 'timeout' => 25, 'ignore_errors' => true]]);
$raw = @file_get_contents($url, false, $ctx);
$status = $http_response_header[0] ?? '';
$response = is_string($raw) ? json_decode($raw, true) : null;
if (!$response || !isset($response['items']) || !str_contains($status, '200')) {
    fwrite(STDERR, "GitHub API request failed: {$status}\n" . (is_string($raw) ? $raw : 'No response') . "\n"); exit(1);
}
$items = array_map(static fn(array $r): array => [
    'name' => $r['full_name'], 'url' => $r['html_url'], 'description' => $r['description'] ?? '',
    'language' => $r['language'] ?? '', 'stars' => $r['stargazers_count'] ?? 0,
    'forks' => $r['forks_count'] ?? 0, 'pushed_at' => $r['pushed_at'] ?? '',
], $response['items']);
$dir = $root . '/data'; if (!is_dir($dir) && !mkdir($dir, 0775, true) && !is_dir($dir)) { fwrite(STDERR, "Cannot create data directory\n"); exit(1); }
$out = json_encode(['updated_at' => date('Y-m-d H:i:s T'), 'period_start' => $since, 'repositories' => $items], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
if (file_put_contents($dir . '/github_weekly.json', $out . "\n", LOCK_EX) === false) { fwrite(STDERR, "Cannot write GitHub cache\n"); exit(1); }
echo "Saved " . count($items) . " repositories\n";
