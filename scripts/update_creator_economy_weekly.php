<?php
declare(strict_types=1);
require __DIR__ . '/feed_lib.php';
$since = time() - 7 * 86400;
$feeds = [
    'TechCrunch AI' => 'https://techcrunch.com/category/artificial-intelligence/feed/',
    'Tubefilter' => 'https://www.tubefilter.com/feed/',
    'Social Media Today' => 'https://www.socialmediatoday.com/feeds/news/',
];
$articles = [];
foreach ($feeds as $source => $url) {
    $xml = feedGetText($url);
    if ($xml !== null) foreach (feedParseXml($xml, $source) as $article) $articles[] = $article;
}
$queries = ['AI video creator', 'creator economy short video', 'YouTube Shorts creator', 'AI influencer monetization', 'Civitai image generation'];
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
    $generationTopic = preg_match('/ai[- ]generated|generative ai|ai video|ai image|video generation|image generation|text[- ]to[- ]video|text[- ]to[- ]image|ai influencer|civitai|runway|kling|seedance|comfyui|sora|veo|higgsfield/', $text);
    $creatorTopic = preg_match('/creator economy|creator monetiz|creator program|creator fund|youtube shorts|tiktok creator|instagram creator|short[- ]form video|viral video|adult creator|adult content|onlyfans|fanvue|patreon/', $text);
    if (!$generationTopic && !$creatorTopic) continue;
    $category = preg_match('/adult|fanvue|patreon|onlyfans|nsfw/', $text) ? '成人创作者平台 / 政策' : (preg_match('/monetiz|creator|subscription|revenue/', $text) ? '创作者经济' : '图像 / 视频生成');
    $ageHours = max(0, (time() - $stamp) / 3600);
    $score = 100 + max(0, 168 - $ageHours) + log(1 + (int)($article['points'] ?? 0)) * 12 + log(1 + (int)($article['comments'] ?? 0)) * 3;
    $article['category'] = $category;
    $article['score'] = $score;
    $key = strtolower(preg_replace('/[^a-z0-9]+/i', '', (string)$article['url']));
    if (!isset($unique[$key]) || $score > $unique[$key]['score']) $unique[$key] = $article;
}
$articles = array_values($unique);
usort($articles, static fn(array $a, array $b): int => $b['score'] <=> $a['score']);
$articles = array_slice($articles, 0, 10);
$path = dirname(__DIR__) . '/data/creator_economy_weekly.json';
if (!feedWriteJson($path, ['updated_at' => gmdate('Y-m-d H:i:s T'), 'period_start' => gmdate('Y-m-d', $since), 'articles' => $articles])) { fwrite(STDERR, "Could not write creator trends cache\n"); exit(1); }
echo 'Saved ' . count($articles) . " creator economy stories\n";
