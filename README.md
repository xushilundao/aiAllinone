ai website all in one!

## GitHub weekly and X AI trends

The home page now embeds a GitHub weekly repository board and a multilingual AI KOL directory. The GitHub board lists the top 10 non-fork public repositories pushed in the last seven days, ordered by total stars. The X board has curated Chinese, English, and Arabic AI accounts, with X's official timeline embed available on demand; it requires no paid API key.

## 运行说明

GitHub 榜单由 PHP 脚本每周更新一次。先进入网站目录并手动运行一次，立即生成首屏数据：

```sh
cd /path/to/aiAllinone
php scripts/update_github_weekly.php
```

在服务器上执行 `crontab -e`，加入下面一行，并把路径替换成网站的**绝对路径**：

```cron
25 6 * * 1 /usr/bin/php /path/to/aiAllinone/scripts/update_github_weekly.php >> /path/to/aiAllinone/data/cron.log 2>&1
```

这会按服务器时区在每周一 06:25 更新榜单。保存后用 `crontab -l` 检查任务是否已加入；查看运行日志：

```sh
tail -n 50 /path/to/aiAllinone/data/cron.log
```

cron 运行用户必须能写入 `data/`。首次手动运行脚本时也要使用有权限写入该目录的用户。GitHub 公共搜索 API 无需 token；如需提高 API 配额，可在 cron 环境中配置 `GITHUB_TOKEN`。X KOL 名单和时间线在 `x_ai_trending.php` 中，时间线由 X 官方嵌入组件加载，不需要后台 cron，也不需要付费 API Key。
