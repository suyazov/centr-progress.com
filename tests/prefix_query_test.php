<?php

require __DIR__ . '/../local/lib/CentrProgress/Search/PrefixQuery.php';
require __DIR__ . '/../local/lib/CentrProgress/Catalog/EducationProgramFiles.php';

use CentrProgress\Catalog\EducationProgramFiles;
use CentrProgress\Search\PrefixQuery;

$cases = array(
    'тепл' => 'тепл*',
    'тепло' => 'тепло*',
    'тёпл' => 'тепл*',
    'ТЕПЛ' => 'тепл*',
    'abc' => 'abc',
    '<b>тепл*</b> -test' => 'b тепл* b test*',
);

foreach ($cases as $input => $expected) {
    $actual = PrefixQuery::build($input);
    if ($actual !== $expected) {
        fwrite(STDERR, sprintf("PrefixQuery failed for %s: %s != %s\n", $input, $actual, $expected));
        exit(1);
    }
}

$single = EducationProgramFiles::fromDisplayProperty(array('FILE_VALUE' => array('SRC' => '/upload/a.pdf', 'FILE_SIZE' => 42)));
$multiple = EducationProgramFiles::fromDisplayProperty(array('FILE_VALUE' => array(array('SRC' => ''), array('SRC' => '/upload/b.pdf'))));
$unsafe = EducationProgramFiles::fromDisplayProperty(array('FILE_VALUE' => array('SRC' => 'javascript:alert(1)')));
if (count($single) !== 1 || count($multiple) !== 1 || $multiple[0]['SRC'] !== '/upload/b.pdf' || $unsafe) {
    fwrite(STDERR, "EducationProgramFiles normalization failed\n");
    exit(1);
}

echo "OK\n";
