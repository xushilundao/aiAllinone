ai website all in one!

## GitHub weekly and X AI trends

The home page now embeds a GitHub weekly repository board and a multilingual AI KOL directory. The GitHub board lists the top 10 non-fork public repositories pushed in the last seven days, ordered by total stars. The X board has curated Chinese, English, and Arabic AI accounts, with X's official timeline embed available on demand; it requires no paid API key.

The PHP pages read generated JSON from `data/`. Configure cron on the Apache host (copy `cron.example` and replace `/path/to/site`). Run the GitHub script once to populate its board:

```sh
php scripts/update_github_weekly.php
```

Cron runs as its configured user, so that user must be able to write to `data/`. GitHub's public search API is used without a token; set `GITHUB_TOKEN` in cron if you need authenticated API quota. The X directory is curated in `x_ai_trending.php`; its displayed timelines come directly from X and need no background job.
