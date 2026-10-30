<?php
declare(strict_types=1);
$file = __DIR__ . '/data/github_weekly.json';
$payload = is_file($file) ? json_decode((string) file_get_contents($file), true) : null;
function h(string $value): string { return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); }
?>
<!doctype html><html lang="zh-CN"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>GitHub Weekly Top 10</title>
<style>
*{box-sizing:border-box}body{margin:0;padding:18px;background:#f6f8fa;color:#1f2328;font:15px/1.5 system-ui,-apple-system,"Segoe UI",sans-serif}.wrap{max-width:1000px;margin:auto}.head{display:flex;justify-content:space-between;align-items:end;gap:12px;margin-bottom:14px}.head h1{font-size:24px;margin:0}.muted{color:#656d76;font-size:13px}.grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(290px,1fr));gap:12px}.card{background:white;border:1px solid #d1d9e0;border-radius:12px;padding:15px}.rank{color:#656d76;font-size:13px}.card h2{font-size:17px;margin:5px 0}.card h2 a{color:#0969da;text-decoration:none}.desc{min-height:42px;color:#424a53;font-size:14px}.meta{display:flex;gap:14px;flex-wrap:wrap;color:#656d76;font-size:13px}.notice{padding:16px;background:white;border:1px solid #d1d9e0;border-radius:12px}
</style></head><body><main class="wrap"><div class="head"><div><h1>GitHub 每周热门仓库</h1><div class="muted">按最近 7 天有更新的公开仓库，按总 Star 数排序</div></div><div class="muted">更新：<?= h((string)($payload['updated_at'] ?? '等待首次 cron')) ?></div></div>
<?php if (is_array($payload) && !empty($payload['repositories'])): ?><section class="grid">
<?php foreach ($payload['repositories'] as $i => $repo): ?><article class="card"><div class="rank">#<?= $i + 1 ?> · <?= h((string)($repo['language'] ?? '未标注语言')) ?></div><h2><a href="<?= h((string)$repo['url']) ?>" target="_blank" rel="noopener"><?= h((string)$repo['name']) ?></a></h2><div class="desc"><?= h((string)($repo['description'] ?? '暂无简介')) ?></div><div class="meta"><span>★ <?= number_format((int)$repo['stars']) ?></span><span>⑂ <?= number_format((int)$repo['forks']) ?></span><span>本周更新 <?= h(substr((string)$repo['pushed_at'], 0, 10)) ?></span></div></article><?php endforeach; ?></section>
<?php else: ?><div class="notice">榜单数据尚未生成。请按 README 中的说明配置每周 cron，首次执行 <code>php scripts/update_github_weekly.php</code>。</div><?php endif; ?></main></body></html>
