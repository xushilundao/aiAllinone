<?php
declare(strict_types=1);
$groups = [
    'chinese' => [
        'label' => '中文', 'dir' => 'ltr', 'people' => [
            ['宝玉', 'dotey', 'AI 工具、模型解读与工程实践'],
            ['小互', 'xiaohu', 'AI 产品动态、工具与实用技巧'],
            ['歸藏', 'op7418', 'AIGC、图像视频生成与工作流'],
            ['向阳乔木', 'vista8', 'AI 产品、工作流与 Vibe Coding'],
            ['数字生命卡兹克', 'Khazix0918', 'AI 产品体验与工具评测'],
            ['郭宇', 'turingou', 'AI 创业、产品与技术趋势'],
            ['李开复', 'kaifulee', 'AI 产业趋势与创业'],
            ['李继刚', 'lijigang', 'Prompt 方法与 AI 应用'],
            ['AYi', 'AYi_AInotes', 'AI 资讯与模型进展'],
            ['Sac', 'Saccc_c', 'AI 观察与产品实践'],
        ],
    ],
    'english' => [
        'label' => 'English', 'dir' => 'ltr', 'people' => [
            ['Andrej Karpathy', 'karpathy', 'AI research, LLMs, and hands-on education'],
            ['NVIDIA AI', 'NVIDIAAI', 'AI research, models, and NVIDIA ecosystem news'],
            ['Andrew Ng', 'AndrewYNg', 'AI education, agents, and applied AI'],
            ['Yann LeCun', 'ylecun', 'Deep learning research and AI architecture'],
            ['Jim Fan', 'DrJimFan', 'Robotics, embodied AI, and NVIDIA research'],
            ['Sam Altman', 'sama', 'AI products, industry direction, and OpenAI'],
            ['Elon Musk', 'elonmusk', 'AI, xAI, Grok, and technology commentary'],
            ['Demis Hassabis', 'demishassabis', 'AI research and science'],
            ['Fei-Fei Li', 'drfeifei', 'Human-centered AI and computer vision'],
            ['François Chollet', 'fchollet', 'AI reasoning and evaluation'],
            ['Sebastian Raschka', 'rasbt', 'Machine learning research and LLM engineering'],
        ],
    ],
    'arabic' => [
        'label' => 'العربية', 'dir' => 'rtl', 'people' => [
            ['عمر الشال', 'OmarAlshal', 'إعلامي تقني ومستشار ذكاء اصطناعي وصناعة الفيديو'],
            ['عبدالله السبع', '7Alsabe', 'صحفي ومقدم محتوى تقني وأخبار الذكاء الاصطناعي'],
            ['فيصل السيف', 'falsaif', 'صانع محتوى تقني وتطبيقات الذكاء الاصطناعي'],
            ['Maged Saeed', '_MagedSaeed_', 'باحث ومهندس ذكاء اصطناعي ومعالجة اللغة العربية'],
            ['بدور الريس', 'Bedouralrayes', 'باحثة دكتوراه في الذكاء الاصطناعي'],
            ['د. عبد الرحمن الزهراني', 'Dr_AOZ', 'أستاذ الذكاء الاصطناعي وتقنيات التعليم'],
            ['د. سعود المهيدب', 'SaudAlmuhaidib', 'أستاذ وباحث في الذكاء الاصطناعي'],
            ['Bashar Alhafni', 'balhafni', 'باحث NLP ومدير مختبر Aram في MBZUAI'],
            ['Aram Lab', 'AramLabAI', 'أبحاث الذكاء الاصطناعي واللغة العربية'],
            ['MBZUAI', 'mbzuai', 'أبحاث وأخبار جامعة محمد بن زايد للذكاء الاصطناعي'],
        ],
    ],
];
function esc(string $s): string { return htmlspecialchars($s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); }
?>
<!doctype html><html lang="zh-CN"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>AI KOLs on X</title>
<style>
*{box-sizing:border-box}body{margin:0;padding:18px;background:#f6f8fa;color:#1f2328;font:15px/1.55 system-ui,-apple-system,"Segoe UI",sans-serif}.wrap{max-width:1000px;margin:auto}.heading{display:flex;justify-content:space-between;align-items:end;gap:12px}.heading h1{font-size:23px;margin:0}.sub,.note{color:#656d76;font-size:13px}.tabs{display:flex;gap:8px;margin:15px 0}.tabs button{border:1px solid #d1d9e0;background:#fff;border-radius:999px;padding:8px 16px;cursor:pointer}.tabs button.active{background:#1f2328;color:white}.panel{display:none}.panel.active{display:block}.grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(270px,1fr));gap:12px}.card{background:#fff;border:1px solid #d1d9e0;border-radius:12px;padding:14px}.rank{color:#656d76;font-size:12px}.name{font-size:17px;font-weight:700;margin:3px 0}.handle{color:#656d76;font-size:13px}.bio{min-height:42px;margin:7px 0;color:#424a53;font-size:14px}.actions{display:flex;gap:8px;align-items:center}.actions a,.actions button{border:0;border-radius:7px;padding:7px 10px;text-decoration:none;cursor:pointer;font:inherit;font-size:13px}.profile{background:#1f2328;color:#fff}.load{background:#eaeef2;color:#1f2328}.feed{margin-top:10px}.feed iframe{width:100%;border:0}.note{margin:10px 0 0}
</style></head><body><main class="wrap"><header class="heading"><div><h1>X 上的 AI KOL</h1><div class="sub">中、英、阿语精选关注名单 · 账号主页与近期动态直接来自 X</div></div><div class="sub">精选名单，非实时粉丝数排名</div></header>
<nav class="tabs" aria-label="Language"><button class="active" data-panel="chinese">中文</button><button data-panel="english">English</button><button data-panel="arabic">العربية</button></nav>
<?php foreach ($groups as $key => $group): ?><section class="panel <?= $key === 'chinese' ? 'active' : '' ?>" id="panel-<?= esc($key) ?>" lang="<?= esc($key === 'chinese' ? 'zh-CN' : ($key === 'english' ? 'en' : 'ar')) ?>" dir="<?= esc($group['dir']) ?>"><div class="grid">
<?php foreach ($group['people'] as $i => [$name, $handle, $bio]): ?><article class="card"><div class="rank">#<?= $i + 1 ?></div><div class="name"><?= esc($name) ?></div><div class="handle">@<?= esc($handle) ?></div><div class="bio"><?= esc($bio) ?></div><div class="actions"><a class="profile" href="https://x.com/<?= rawurlencode($handle) ?>" target="_blank" rel="noopener">X 主页 ↗</a><button class="load" type="button" data-handle="<?= esc($handle) ?>">加载近期动态</button></div><div class="feed" hidden></div></article><?php endforeach; ?>
</div></section><?php endforeach; ?><p class="note">动态由 X 官方嵌入组件实时加载，无需付费 API Key。若嵌入加载受网络或浏览器限制，可直接打开对应 X 主页。</p></main>
<script>
document.querySelectorAll('.tabs button').forEach(button=>button.addEventListener('click',()=>{document.querySelectorAll('.tabs button,.panel').forEach(el=>el.classList.remove('active'));button.classList.add('active');document.getElementById('panel-'+button.dataset.panel).classList.add('active')}));
document.querySelectorAll('.load').forEach(button=>button.addEventListener('click',()=>{const box=button.closest('.card').querySelector('.feed');if(box.dataset.loaded)return;box.hidden=false;box.dataset.loaded='1';const handle=button.dataset.handle;const link=document.createElement('a');link.className='twitter-timeline';link.href='https://twitter.com/'+handle;link.textContent='Posts by @'+handle;link.dataset.height='420';link.dataset.dnt='true';box.appendChild(link);if(window.twttr&&window.twttr.widgets){window.twttr.widgets.load(box)}else{const script=document.createElement('script');script.src='https://platform.twitter.com/widgets.js';script.async=true;script.charset='utf-8';script.onload=()=>window.twttr&&window.twttr.widgets.load(box);document.body.appendChild(script)}}));
</script></body></html>
