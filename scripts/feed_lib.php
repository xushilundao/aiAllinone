<?php
declare(strict_types=1);

function feedGetText(string $url, int $timeout = 18): ?string {
    $ctx = stream_context_create(['http' => ['method' => 'GET', 'header' => "User-Agent: buyhub-weekly-digest/1.0\r\nAccept: application/rss+xml, application/atom+xml, application/xml, application/json, */*\r\n", 'timeout' => $timeout, 'ignore_errors' => true]]);
    $body = @file_get_contents($url, false, $ctx);
    return is_string($body) && strlen($body) > 10 ? $body : null;
}

function feedJson(string $url): ?array {
    $body = feedGetText($url);
    if ($body === null) return null;
    $data = json_decode($body, true);
    return is_array($data) ? $data : null;
}

function feedXmlValue(string $xml, string $tag): string {
    if (!preg_match('/<' . preg_quote($tag, '/') . '\b[^>]*>(.*?)<\/' . preg_quote($tag, '/') . '\s*>/is', $xml, $m)) return '';
    $value = trim($m[1]);
    if (preg_match('/^<!\[CDATA\[(.*)\]\]>$/is', $value, $c)) $value = $c[1];
    return trim(html_entity_decode(strip_tags($value), ENT_QUOTES | ENT_HTML5, 'UTF-8'));
}

function feedParseXml(string $xml, string $source): array {
    $results = [];
    preg_match_all('/<(item|entry)\b[^>]*>(.*?)<\/\1\s*>/is', $xml, $matches, PREG_SET_ORDER);
    foreach ($matches as $match) {
        $node = $match[2];
        $title = feedXmlValue($node, 'title');
        if ($title === '') continue;
        $url = '';
        if (preg_match('/<link\b([^>]+)\/?\s*>/is', $node, $linkMatch) && preg_match('/href=["\']([^"\']+)/i', $linkMatch[1], $hrefMatch)) {
            $url = html_entity_decode($hrefMatch[1], ENT_QUOTES | ENT_HTML5, 'UTF-8');
        } else {
            $url = feedXmlValue($node, 'link');
        }
        $date = feedXmlValue($node, 'pubDate');
        if ($date === '') $date = feedXmlValue($node, 'published');
        if ($date === '') $date = feedXmlValue($node, 'updated');
        $description = feedXmlValue($node, 'description');
        if ($description === '') $description = feedXmlValue($node, 'summary');
        $snippet = function_exists('mb_substr') ? mb_substr($description, 0, 420) : substr($description, 0, 420);
        $results[] = ['title' => $title, 'url' => $url, 'date' => $date !== '' ? date('c', strtotime($date) ?: time()) : '', 'description' => $snippet, 'source' => $source];
    }
    return $results;
}

function feedWriteJson(string $path, array $payload): bool {
    $dir = dirname($path);
    if (!is_dir($dir) && !mkdir($dir, 0775, true) && !is_dir($dir)) return false;
    $json = json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    if (!is_string($json)) return false;
    $tmp = $path . '.tmp';
    if (file_put_contents($tmp, $json . "\n", LOCK_EX) === false) return false;
    return rename($tmp, $path);
}
