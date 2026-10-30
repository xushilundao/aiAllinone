ai website all in one!

## GitHub weekly and X AI trends

The home page now embeds a GitHub weekly repository board and a multilingual AI KOL directory. The GitHub board lists the top 10 non-fork public repositories pushed in the last seven days, ordered by total stars. The X board has curated Chinese, English, and Arabic AI accounts, with X's official timeline embed available on demand; it requires no paid API key.

## 运行说明

GitHub 榜单由 PHP 脚本每周更新一次。先进入网站目录并手动运行一次，立即生成首屏数据：

```sh
cd /path/to/aiAllinone
php scripts/update_github_weekly.php
php scripts/update_ai_models_weekly.php
php scripts/update_creator_economy_weekly.php
php scripts/update_security_weekly.php
```

在服务器上执行 `crontab -e`，加入下面一行，并把路径替换成网站的**绝对路径**：

```cron
25 6 * * 1 /usr/bin/php /path/to/aiAllinone/scripts/update_github_weekly.php >> /path/to/aiAllinone/data/cron.log 2>&1
35 6 * * 1 /usr/bin/php /path/to/aiAllinone/scripts/update_ai_models_weekly.php >> /path/to/aiAllinone/data/cron.log 2>&1
45 6 * * 1 /usr/bin/php /path/to/aiAllinone/scripts/update_creator_economy_weekly.php >> /path/to/aiAllinone/data/cron.log 2>&1
0 7 * * * /usr/bin/php /path/to/aiAllinone/scripts/update_security_weekly.php >> /path/to/aiAllinone/data/cron.log 2>&1
```

这会按服务器时区每周一 06:25 更新 GitHub 榜、06:35 更新 AI 模型榜、06:45 更新创作变现动态，并每天 07:00 更新网络安全新闻。保存后用 `crontab -l` 检查任务是否已加入；查看运行日志：

```sh
tail -n 50 /path/to/aiAllinone/data/cron.log
```

cron 运行用户必须能写入 `data/`。首次手动运行脚本时也要使用有权限写入该目录的用户。GitHub 公共搜索 API 无需 token；如需提高 API 配额，可在 cron 环境中配置 `GITHUB_TOKEN`。X KOL 名单和时间线在 `x_ai_trending.php` 中，时间线由 X 官方嵌入组件加载，不需要后台 cron，也不需要付费 API Key。

### 每周 AI 模型榜

`scripts/update_ai_models_weekly.php` 从 Hugging Face 和中美厂商的 GitHub 官方组织查询过去 7 天首次公开的模型仓库，按平台趋势、下载、点赞和 Star 信号排序，取前 10 名。中美公司范围在脚本的 `$companies` 列表中维护。页面按文本/多模态、图像/视频分类，并提供 Hugging Face、Civitai 和 Artificial Analysis 的专题入口。该榜只收录能从官方公开仓库核实的发布；闭源模型和没有公开仓库的发布不会被推断或伪装成开源模型。

### 网络安全与创作者商业动态

`scripts/update_security_weekly.php` 聚合 The Hacker News、BleepingComputer、CISA、Google Project Zero 和 Hacker News Algolia 的公开新闻/研究条目，按漏洞、逆向分析、大模型红队、prompt injection 和 abliteration 等主题筛选，每天更新 Top 10。它只展示新闻来源链接，不运行漏洞利用。

`scripts/update_creator_economy_weekly.php` 聚合 TechCrunch AI、Tubefilter、Social Media Today 和 Hacker News 的图像/视频生成、短视频及创作者经济动态；页面另提供趋势案例入口、15 秒脚本结构，以及工具和变现平台目录。成人平台仅链接到官方规则说明：只面向明确成年人和授权素材，发布 AI 内容前核实披露、肖像许可及平台政策。YouTube/TikTok 等主流短视频平台对色情内容限制严格，成人订阅平台规则也会变动。
