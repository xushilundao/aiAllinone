<?php
header('Content-Type: text/html; charset=UTF-8');

function load_matches(string $file): array {
    if (!is_file($file)) {
        return [];
    }
    $rows = array_map('trim', file($file));
    $matches = [];
    foreach ($rows as $row) {
        if ($row === '') continue;
        $parts = str_getcsv($row);
        if (count($parts) < 6) continue;
        [$date, $league, $home, $away, $pH, $pD, $pA] = $parts;
        $matches[] = [
            'date' => $date,
            'league' => $league,
            'home' => $home,
            'away' => $away,
            'pH' => (float)$pH,
            'pD' => (float)$pD,
            'pA' => (float)$pA,
        ];
    }
    return $matches;
}

$csvFile = __DIR__ . '/data.csv';
$matches = load_matches($csvFile);
if (!$matches) {
    $matches = [
        ['date' => date('Y-m-d', strtotime('+1 day')), 'league' => 'Sample League', 'home' => 'Home FC', 'away' => 'Away FC', 'pH' => 0.5, 'pD' => 0.25, 'pA' => 0.25],
    ];
}

$now = new DateTime('now', new DateTimeZone('Asia/Shanghai'));
$weekAhead = (clone $now)->modify('+7 days');
$upcoming = array_filter($matches, function ($m) use ($now, $weekAhead) {
    $d = DateTime::createFromFormat('Y-m-d', $m['date'], new DateTimeZone('Asia/Shanghai'));
    return $d && $d >= $now && $d <= $weekAhead;
});

function best_pick(array $m): string {
    $max = max($m['pH'], $m['pD'], $m['pA']);
    if ($max === $m['pH']) return 'Home Win';
    if ($max === $m['pD']) return 'Draw';
    return 'Away Win';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Weekly Football & Lottery Reminder</title>
    <style>
        body { margin: 0; font-family: Arial, sans-serif; background: #0f111a; color: #f0f8ff; }
        .wrap { padding: 16px; }
        table { width: 100%; border-collapse: collapse; background: #111728; border-radius: 8px; overflow: hidden; }
        th, td { padding: 10px; text-align: left; }
        th { background: #151d33; }
        tr:nth-child(even) { background: #10162a; }
        .note { margin: 12px 0; color: #a8b3cf; font-size: 13px; }
        .lotto { margin-top: 10px; }
    </style>
</head>
<body>
<div class="wrap">
    <h2>Upcoming 7 Days Football Fixtures</h2>
    <?php if (!$upcoming): ?>
        <div class="note">No fixtures found in the next 7 days. Add CSV rows to football/data.csv (date, league, home, away, pHome, pDraw, pAway).</div>
    <?php else: ?>
    <table>
        <thead>
            <tr>
                <th>Date</th><th>League</th><th>Match</th><th>Win Prob.</th><th>Draw Prob.</th><th>Away Prob.</th><th>Suggested Pick</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($upcoming as $m): ?>
            <tr>
                <td><?= htmlspecialchars($m['date']) ?></td>
                <td><?= htmlspecialchars($m['league']) ?></td>
                <td><?= htmlspecialchars($m['home'] . ' vs ' . $m['away']) ?></td>
                <td><?= number_format($m['pH'] * 100, 1) ?>%</td>
                <td><?= number_format($m['pD'] * 100, 1) ?>%</td>
                <td><?= number_format($m['pA'] * 100, 1) ?>%</td>
                <td><?= best_pick($m) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>

    <div class="lotto">
        <h3>China Sports Lottery Products</h3>
        <ul>
            <li>竞彩足球 胜平负 (Win/Draw/Win)</li>
            <li>竞彩足球 比分/总进球/半全场</li>
            <li>14场胜负彩 / 任九场</li>
        </ul>
        <div class="note">Suggested pick is derived from highest historical probability in data.csv. Update the CSV weekly to refine predictions.</div>
    </div>
</div>
</body>
</html>


