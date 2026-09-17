<?php

$root = dirname(__DIR__);
$fail = function ($message) {
    fwrite(STDERR, $message . "\n");
    exit(1);
};

// Both public copies must use the same Bitrix ordering contract.
foreach (array('o-tsentre/index.php', 'public_html/o-tsentre/index.php') as $path) {
    $source = file_get_contents($root . '/' . $path);
    $expected = array(
        '"SORT_BY1" => "SORT"',
        '"SORT_ORDER1" => "ASC"',
        '"SORT_BY2" => "ACTIVE_FROM"',
        '"SORT_ORDER2" => "DESC"',
    );
    foreach ($expected as $contract) {
        if (strpos($source, $contract) === false) {
            $fail("{$path}: missing review sort contract: {$contract}");
        }
    }
}

// Ascending SORT puts the city bands in editorial order; within a band the
// newest ACTIVE_FROM record comes first.
$reviews = array(
    array('city' => 'Пятигорск', 'sort' => 300, 'active_from' => '2026-01-01'),
    array('city' => 'Кисловодск', 'sort' => 200, 'active_from' => '2026-01-01'),
    array('city' => 'Ставрополь', 'sort' => 100, 'active_from' => '2026-01-01'),
    array('city' => 'Кисловодск', 'sort' => 200, 'active_from' => '2026-02-01'),
);
usort($reviews, function ($left, $right) {
    return $left['sort'] === $right['sort']
        ? strcmp($right['active_from'], $left['active_from'])
        : $left['sort'] <=> $right['sort'];
});
$actual = array_column($reviews, 'city');
$expected = array('Ставрополь', 'Кисловодск', 'Кисловодск', 'Пятигорск');
if ($actual !== $expected || $reviews[1]['active_from'] !== '2026-02-01') {
    $fail('SORT ascending / ACTIVE_FROM descending city ordering regression');
}

echo "reviews city ordering contract OK\n";
