<?php
declare(strict_types=1);
require __DIR__ . '/feed_lib.php';
$since = time() - 7 * 86400;
$feeds = [
    'The Hacker News' => 'https://feeds.feedburner.com/TheHackersNews',
    'BleepingComputer' => 'https://www.bleepingcomputer.com/feed/',
    'Google Project Zero' => 'https://googleprojectzero.blogspot.com/feeds/posts/default?alt=rss',
    'CISA Advisories' => 'https://www.cisa.gov/cybersecurity-advisories/all.xml',
];
$articles = [];
foreach ($feeds as $name => $url) {
    $xml = feedGetText($url);
    if ($xml !== null) foreach (feedParseXml($xml, $name) as $article) $articles[] = $article;
}
$queries = ['CVE vulnerability exploit', 'zero-day security patch', 'reverse engineering malware', 'LLM red teaming', 'prompt injection LLM security', 'abliteration model safety'];
foreach ($queries as $query) {
    $url = 'https://hn.algolia.com/api/v1/search_by_date?' . http_build_query(['query' => $query, 'tags' => 'story', 'numericFilters' => 'created_at_i>' . $since, 'hitsPerPage' => 50]);
    $response = feedJson($url);
    foreach (($response['hits'] ?? []) as $hit) {
        if (empty($hit['title'])) continue;
        $articles[] = ['title' => (string)$hit['title'], 'url' => (string)($hit['url'] ?? ('https://news.ycombinator.com/item?id=' . ($hit['objectID'] ?? ''))), 'date' => (string)($hit['created_at'] ?? ''), 'description' => '', 'source' => 'Hacker News', 'points' => (int)($hit['points'] ?? 0), 'comments' => (int)($hit['num_comments'] ?? 0)];
    }
}
$unique = [];
foreach ($articles as $article) {
    if (empty($article['title']) || empty($article['url'])) continue;
    $stamp = strtotime((string)($article['date'] ?? '')) ?: 0;
    if ($stamp < $since) continue;
    $text = strtolower($article['title'] . ' ' . ($article['description'] ?? ''));
    $category = '漏洞与补丁';
    $relevance = 1;
    if (preg_match('/abliterat|llm red.?team|model red.?team|prompt injection|jailbreak|model safety|llm security|ai security/', $text)) { $category = '大模型红队 / 安全'; $relevance = 4; }
    elseif (preg_match('/reverse engineer|reverse engineering|decompil|firmware analysis|malware analysis|binary analysis|fuzzing/', $text)) { $category = '逆向与分析'; $relevance = 3; }
    elseif (preg_match('/cve-|vulnerab|zero.?day|exploit|remote code execution|rce|security update|security flaw|patch/', $text)) { $category = '漏洞与补丁'; $relevance = 3; }
    else continue;
    $key = strtolower(preg_replace('/[^a-z0-9]+/i', '', (string)$article['url']));
    $ageHours = max(0, (time() - $stamp) / 3600);
    $score = $relevance * 100 + max(0, 168 - $ageHours) + log(1 + (int)($article['points'] ?? 0)) * 15 + log(1 + (int)($article['comments'] ?? 0)) * 4;
    $article['category'] = $category;
    $article['score'] = $score;
    if (!isset($unique[$key]) || $score > $unique[$key]['score']) $unique[$key] = $article;
}
$articles = array_values($unique);
usort($articles, static fn(array $a, array $b): int => $b['score'] <=> $a['score']);
$articles = array_slice($articles, 0, 10);
if (!$articles) { fwrite(STDERR, "No security stories found in the past week; keeping the previous cache.\n"); exit(1); }
$path = dirname(__DIR__) . '/data/security_weekly.json';
if (!feedWriteJson($path, ['updated_at' => gmdate('Y-m-d H:i:s T'), 'period_start' => gmdate('Y-m-d', $since), 'articles' => $articles])) { fwrite(STDERR, "Could not write security cache\n"); exit(1); }
echo 'Saved ' . count($articles) . " cybersecurity stories\n";
