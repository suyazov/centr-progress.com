<?php
require __DIR__ . '/../local/lib/CentrProgress/Search/CatalogSearch.php';
use CentrProgress\Search\CatalogSearch;

$cases = array(
    array('лиф', 'Лифтер 1-2 разряд', true),
    array('лифт', 'Лифтер 1-2 разряд', true),
    array('лифтер', 'Лифтер 1-2 разряд', true),
    array('тёпл', 'Теплопотребляющие установки', true),
    array('ТЕПЛ', 'Теплопотребляющие установки', true),
    array('лифтер оператор', 'Лифтёр-оператор по обслуживанию лифтов', true),
    array('лифтер оператор', 'Лифтер 1-2 разряд', false),
);
foreach ($cases as $case) {
    $score = CatalogSearch::score($case[1], CatalogSearch::tokens($case[0]));
    if (($score !== null) !== $case[2]) {
        fwrite(STDERR, "CatalogSearch failed: {$case[0]} / {$case[1]}\n");
        exit(1);
    }
}
echo "OK\n";
