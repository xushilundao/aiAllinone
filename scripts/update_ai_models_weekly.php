<?php
declare(strict_types=1);
date_default_timezone_set('UTC');
$root = dirname(__DIR__);
$since = gmdate('Y-m-d', time() - 7 * 86400);
$companies = [
    'China' => [
        'Qwen' => ['hf' => 'Qwen', 'gh' => 'QwenLM'],
        'DeepSeek' => ['hf' => 'deepseek-ai', 'gh' => 'deepseek-ai'],
        'Zhipu AI' => ['hf' => 'zai-org', 'gh' => 'THUDM'],
        'MiniMax' => ['hf' => 'MiniMaxAI', 'gh' => 'MiniMax-AI'],
        'Moonshot AI' => ['hf' => 'moonshotai', 'gh' => 'moonshotAI'],
        'ByteDance' => ['hf' => 'ByteDance', 'gh' => 'bytedance'],
        'Tencent' => ['hf' => 'Tencent', 'gh' => 'Tencent'],
        'Baidu' => ['hf' => 'baidu', 'gh' => 'baidu'],
        'BAAI' => ['hf' => 'BAAI', 'gh' => 'BAAI'],
        'Alibaba NLP' => ['hf' => 'Alibaba-NLP', 'gh' => 'Alibaba-NLP'],
        'Shanghai AI Lab' => ['hf' => 'internlm', 'gh' => 'InternLM'],
        '01.AI' => ['hf' => 'inclusionAI', 'gh' => 'inclusionAI'],
        'StepFun' => ['hf' => 'stepfun-ai', 'gh' => 'StepFun-AI'],
        'Kuaishou' => ['hf' => 'Kwai-Kolors', 'gh' => 'Kwai-Kolors'],
        'Wan' => ['hf' => 'Wan-AI', 'gh' => 'Wan-Video'],
        'Xiaomi' => ['hf' => 'XiaomiMiMo', 'gh' => 'XiaomiMiMo'],
        'Huawei Noah' => ['hf' => 'Huawei-Noah', 'gh' => 'HuaweiNoah'],
    ],
    'US' => [
        'OpenAI' => ['hf' => 'openai', 'gh' => 'openai'],
        'Meta' => ['hf' => 'meta-llama', 'gh' => 'meta-llama'],
        'Google' => ['hf' => 'google', 'gh' => 'google'],
        'NVIDIA' => ['hf' => 'nvidia', 'gh' => 'NVIDIA'],
        'Microsoft' => ['hf' => 'microsoft', 'gh' => 'microsoft'],
        'xAI' => ['hf' => 'xai-org', 'gh' => 'xai-org'],
        'Anthropic' => ['hf' => 'Anthropic', 'gh' => 'anthropics'],
        'Runway' => ['hf' => 'runwayml', 'gh' => 'runwayml'],
        'Luma AI' => ['hf' => 'LumaAI', 'gh' => 'LumaAI'],
        'Amazon' => ['hf' => 'amazon', 'gh' => 'aws'],
        'Cohere' => ['hf' => 'CohereLabs', 'gh' => 'cohere-ai'],
    ],
];
function getJson(string $url, array $headers = []): ?array {
    $headers[] = 'User-Agent: buyhub-weekly-ai-models';
    $ctx = stream_context_create(['http' => ['method' => 'GET', 'header' => implode("\r\n", $headers) . "\r\n", 'timeout' => 25, 'ignore_errors' => true]]);
    $body = @file_get_contents($url, false, $ctx);
    if (!is_string($body) || !isset($http_response_header[0]) || !str_contains($http_response_header[0], '200')) return null;
    $data = json_decode($body, true);
    return is_array($data) ? $data : null;
}
function classifyModel(array $model): string {
    $tag = strtolower((string)($model['pipeline_tag'] ?? ''));
    $tags = strtolower(implode(' ', (array)($model['tags'] ?? [])));
    $text = strtolower((string)($model['name'] ?? '') . ' ' . (string)($model['description'] ?? '') . ' ' . $tag . ' ' . $tags);
    if (str_contains($text, 'video') || str_contains($text, 'text-to-video') || str_contains($text, 'image-to-video')) return '图像 / 视频';
    if (str_contains($text, 'image') || str_contains($text, 'diffusion') || str_contains($text, 'vision') || str_contains($text, 'multimodal') || str_contains($text, 'vlm')) return '图像 / 多模态';
    return '文本 / 多模态';
}
function inferName(string $repo): string { $parts = explode('/', trim($repo, '/')); return (string)end($parts); }
$models = [];
$seen = [];
foreach ($companies as $region => $group) {
    foreach ($group as $company => $orgs) {
        $author = trim($orgs['hf']);
        $url = 'https://huggingface.co/api/models?' . http_build_query(['author' => $author, 'sort' => 'createdAt', 'direction' => '-1', 'limit' => 30]);
        $hfItems = getJson($url);
        if (is_array($hfItems)) foreach ($hfItems as $item) {
            if (!is_array($item) || empty($item['id'])) continue;
            $created = substr((string)($item['createdAt'] ?? ''), 0, 10);
            if ($created < $since) continue;
            $id = (string)$item['id'];
            $pipeline = (string)($item['pipeline_tag'] ?? '');
            $tags = array_values(array_filter(array_slice((array)($item['tags'] ?? []), 0, 6), 'is_string'));
            $entry = ['name' => inferName($id), 'company' => $company, 'region' => $region, 'category' => classifyModel(['name' => $id, 'pipeline_tag' => $pipeline, 'tags' => $tags]), 'source' => 'Hugging Face', 'url' => 'https://huggingface.co/' . str_replace('%2F', '/', rawurlencode($id)), 'release_date' => $created ?: $since, 'description' => '', 'downloads' => (int)($item['downloads'] ?? 0), 'likes' => (int)($item['likes'] ?? 0), 'trending_score' => (float)($item['trendingScore'] ?? 0), 'tags' => $tags];
            $key = strtolower(preg_replace('/[^a-z0-9]+/i', '', $entry['name']));
            if (!isset($seen[$key]) || $entry['trending_score'] > ($models[$seen[$key]]['trending_score'] ?? 0)) { $seen[$key] = count($models); $models[] = $entry; }
        }

        $ghOrg = trim($orgs['gh']);
        $ghUrl = 'https://api.github.com/orgs/' . rawurlencode($ghOrg) . '/repos?' . http_build_query(['type' => 'public', 'sort' => 'created', 'direction' => 'desc', 'per_page' => 100]);
        $ghItems = getJson($ghUrl, ['Accept: application/vnd.github+json']);
        if (is_array($ghItems)) foreach ($ghItems as $repo) {
            if (!is_array($repo) || empty($repo['full_name']) || !empty($repo['fork'])) continue;
            $created = substr((string)($repo['created_at'] ?? ''), 0, 10);
            if ($created < $since) continue;
            $name = inferName((string)$repo['full_name']);
            $desc = (string)($repo['description'] ?? '');
            $probe = strtolower($name . ' ' . $desc);
            if (!preg_match('/model|llm|vlm|vision|video|image|diffusion|qwen|deepseek|glm|hunyuan|seed|kimi|ernie|llama|gemma|gpt|grok|sora|veo|imagen|janus|internvl|higgs/', $probe)) continue;
            $key = strtolower(preg_replace('/[^a-z0-9]+/i', '', $name));
            if (isset($seen[$key])) continue;
            $models[] = ['name' => $name, 'company' => $company, 'region' => $region, 'category' => classifyModel(['name' => $name, 'description' => $desc]), 'source' => 'GitHub', 'url' => (string)$repo['html_url'], 'release_date' => $created, 'description' => $desc, 'stars' => (int)($repo['stargazers_count'] ?? 0), 'downloads' => 0, 'likes' => 0, 'trending_score' => 0, 'tags' => array_slice((array)($repo['topics'] ?? []), 0, 6)];
            $seen[$key] = count($models) - 1;
        }
    }
}
if (!$models) { fwrite(STDERR, "No qualifying model releases found for the last seven days; keeping the previous cache.\n"); exit(1); }
usort($models, static function(array $a, array $b): int {
    $score = static fn(array $m): float => ($m['trending_score'] * 100) + (log(1 + ($m['downloads'] ?? 0)) * 4) + (log(1 + ($m['likes'] ?? 0)) * 9) + (log(1 + ($m['stars'] ?? 0)) * 8);
    return $score($b) <=> $score($a);
});
$models = array_slice($models, 0, 10);
$dir = $root . '/data';
if (!is_dir($dir) && !mkdir($dir, 0775, true) && !is_dir($dir)) { fwrite(STDERR, "Cannot create data directory\n"); exit(1); }
$out = json_encode(['updated_at' => gmdate('Y-m-d H:i:s T'), 'period_start' => $since, 'models' => $models], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
if (file_put_contents($dir . '/ai_models_weekly.json', $out . "\n", LOCK_EX) === false) { fwrite(STDERR, "Cannot write model cache\n"); exit(1); }
echo 'Saved ' . count($models) . " weekly AI model releases\n";
