<?php
declare(strict_types=1);
$file = __DIR__ . '/data/creator_economy_weekly.json';
$payload = is_file($file) ? json_decode((string)file_get_contents($file), true) : null;
function creator_h(string $s): string { return htmlspecialchars($s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); }
$articles = is_array($payload) ? (array)($payload['articles'] ?? []) : [];
$toolkit = [
 ['YouTube Culture & Trends','案例研究','https://www.youtube.com/trends/','官方趋势报告和跨地区视频案例。'],
 ['TikTok Creative Center','案例 / 热门素材','https://ads.tiktok.com/business/creativecenter/','查看地区趋势、热门视频和创意案例。'],
 ['Runway 模型目录','视频 / 图片生成','https://dev.runwayml.com/models/catalog','比较视频生成与编辑模型；按使用条款制作内容。'],
 ['ComfyUI Hub','开源工作流','https://comfy.org/hub/models/','发现并复用图像、视频和音频工作流。'],
 ['Civitai 本周新模型','图像模型','https://civitai.com/models?sort=Newest&period=Week','社区图像模型目录；检查模型许可和站点规则。'],
 ['短视频脚本模板','脚本结构','https://blog.youtube/creator-and-artist-stories/','开头钩子 → 展示问题 → 视觉反转/结果 → 简短 CTA。'],
 ['YouTube 合作伙伴计划','主流平台变现','https://support.google.com/youtube/answer/72851','查看 Shorts 与频道当前资格、原创性和变现要求。'],
 ['TikTok AI 内容披露','主流平台规则','https://support.tiktok.com/en/using-tiktok/creating-videos/ai-generated-content','真实感 AI 图像/音视频按要求披露；遵守肖像和平台规则。'],
 ['Fanvue AI / 18+ 政策','成人订阅平台','https://help.fanvue.com/en/articles/9538738-ai-content-on-fanvue-what-s-allowed','AI 创作者须按平台规则披露；角色必须明确为成年人。'],
 ['Patreon 成人与 AI 政策','成人订阅平台','https://support.patreon.com/hc/en-us/sections/360011949452-Content-policy-and-guidelines','查看 18+、AI 作品、身份验证和参与者书面同意规则。'],
];
?>
<!doctype html><html lang="zh-CN"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>AI 创作与变现 Top 10</title><style>
*{box-sizing:border-box}body{margin:0;padding:18px;background:#f6f8fa;color:#1f2328;font:15px/1.5 system-ui,-apple-system,"Segoe UI",sans-serif}.wrap{max-width:1000px;margin:auto}.head{display:flex;justify-content:space-between;align-items:end;gap:12px}.head h1{font-size:23px;margin:0}.muted,.fine{color:#656d76;font-size:12px}.section{margin:17px 0 10px;font-size:18px}.list,.grid{display:grid;gap:10px}.grid{grid-template-columns:repeat(auto-fit,minmax(260px,1fr))}.item,.card,.note{background:#fff;border:1px solid #d1d9e0;border-radius:12px;padding:13px 15px}.item h3,.card h3{font-size:15px;margin:6px 0}.item a,.card a{color:#0969da;text-decoration:none}.meta{display:flex;gap:8px;color:#656d76;font-size:12px}.tag{background:#ddf4ff;color:#0550ae;border-radius:999px;padding:2px 8px}.desc{font-size:13px;color:#424a53}.note{font-size:13px;margin:12px 0;background:#fff8c5}.script{font-family:ui-monospace,monospace;color:#424a53;font-size:13px;line-height:1.65}
</style></head><body><main class="wrap"><header class="head"><div><h1>AI 视频 / 图片创作与变现 Top 10</h1><div class="muted">每周创作商业动态 · 案例、生成工具、短视频结构与平台</div></div><div class="muted">更新：<?= creator_h((string)($payload['updated_at'] ?? '等待首次运行')) ?></div></header>
<h2 class="section">本周创作者与生成式媒体动态</h2><?php if ($articles): ?><section class="list"><?php foreach ($articles as $i=>$article): ?><article class="item"><div class="meta"><span>#<?= $i+1 ?></span><span class="tag"><?= creator_h((string)$article['category']) ?></span><span><?= creator_h((string)$article['source']) ?></span><span><?= creator_h(substr((string)$article['date'],0,10)) ?></span></div><h3><a href="<?= creator_h((string)$article['url']) ?>" target="_blank" rel="noopener"><?= creator_h((string)$article['title']) ?></a></h3></article><?php endforeach; ?></section><?php else: ?><div class="item">本周尚无动态缓存；下方工具和平台目录仍可直接使用。</div><?php endif; ?>
<h2 class="section">工具、案例与变现平台参考</h2><section class="grid"><?php foreach ($toolkit as $i=>$item): ?><article class="card"><div class="meta"><span>#<?= $i+1 ?></span><span class="tag"><?= creator_h($item[1]) ?></span></div><h3><a href="<?= creator_h($item[2]) ?>" target="_blank" rel="noopener"><?= creator_h($item[0]) ?> ↗</a></h3><div class="desc"><?= creator_h($item[3]) ?></div></article><?php endforeach; ?></section>
<h2 class="section">可复用的 15 秒短视频脚本骨架</h2><div class="note script">0–1 秒：结果先行 / 反常识画面 → 1–4 秒：一句话交代问题 → 4–10 秒：展示 2–3 个过程镜头 → 10–13 秒：揭示结果或反转 → 13–15 秒：一个明确 CTA。<br>案例拆解可从上方 YouTube 趋势报告、TikTok Creative Center 选择原始视频；借鉴结构，不搬运他人视频、肖像、音乐或剧本。</div>
<p class="fine">成人内容只适用于明确成年、虚构或有授权的参与者，并须标注 AI、遵守所在地法律及平台规则。不要使用未授权真人肖像、非自愿私密影像或任何未成年人形象。YouTube/TikTok 等主流短视频平台对色情内容有严格限制；成人订阅平台规则可能变化，发布前请核对官方政策。</p></main></body></html>
