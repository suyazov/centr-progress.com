<?php

require __DIR__ . '/../local/lib/CentrProgress/Search/PrefixQuery.php';
require __DIR__ . '/../local/lib/CentrProgress/Catalog/EducationProgramFiles.php';

use CentrProgress\Catalog\EducationProgramFiles;
use CentrProgress\Search\PrefixQuery;

$cases = array(
    'лиф' => 'лиф*',
    'лифт' => 'лифт*',
    'тепл' => 'тепл*',
    'тепло' => 'тепло*',
    'тёпл' => 'тепл*',
    'ТЕПЛ' => 'тепл*',
    'abc' => 'abc*',
    '<b>тепл*</b> -test' => 'b тепл* b test*',
);

foreach ($cases as $input => $expected) {
    $actual = PrefixQuery::build($input);
    if ($actual !== $expected) {
        fwrite(STDERR, sprintf("PrefixQuery failed for %s: %s != %s\n", $input, $actual, $expected));
        exit(1);
    }
}

$_REQUEST = array('q' => 'лиф', 'ajax_call' => 'y', 'INPUT_ID' => 'title-search-input');
$_GET = array('q' => 'лиф');
if (PrefixQuery::applyToRequest() !== 'лиф*' || $_GET['q'] !== 'лиф*') {
    fwrite(STDERR, "PrefixQuery AJAX normalization failed\n");
    exit(1);
}
if (PrefixQuery::restoreOriginalInUserOutput('/search/index.php?q=%D0%BB%D0%B8%D1%84%2A') !== '/search/index.php?q=%D0%BB%D0%B8%D1%84') {
    fwrite(STDERR, "PrefixQuery AJAX all-results URL leaked backend syntax\n");
    exit(1);
}
unset($GLOBALS['CENTR_PROGRESS_SEARCH_ORIGINAL_QUERY']);

$single = EducationProgramFiles::fromDisplayProperty(array('FILE_VALUE' => array('SRC' => '/upload/a.pdf', 'FILE_SIZE' => 42)));
$multiple = EducationProgramFiles::fromDisplayProperty(array('FILE_VALUE' => array(array('SRC' => ''), array('SRC' => '/upload/b.pdf'))));
$unsafe = EducationProgramFiles::fromDisplayProperty(array('FILE_VALUE' => array('SRC' => 'javascript:alert(1)')));
if (count($single) !== 1 || count($multiple) !== 1 || $multiple[0]['SRC'] !== '/upload/b.pdf' || $unsafe) {
    fwrite(STDERR, "EducationProgramFiles normalization failed\n");
    exit(1);
}

echo "OK\n";
