<?php
require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';

$APPLICATION->SetTitle('Поиск');

require_once $_SERVER['DOCUMENT_ROOT'] . '/local/lib/CentrProgress/Search/PrefixQuery.php';
\CentrProgress\Search\PrefixQuery::applyToRequest();

$APPLICATION->IncludeComponent(
    'bitrix:search.page',
    'search.page',
    array(
        'RESTART' => 'N',
        'NO_WORD_LOGIC' => 'N',
        'USE_LANGUAGE_GUESS' => 'Y',
        'CHECK_DATES' => 'N',
        'USE_TITLE_RANK' => 'N',
        'DEFAULT_SORT' => 'rank',
        'FILTER_NAME' => '',
        'arrFILTER' => array('iblock_infosection'),
        'arrFILTER_iblock_infosection' => array('7'),
        'SHOW_WHERE' => 'N',
        'SHOW_WHEN' => 'N',
        'PAGE_RESULT_COUNT' => '50',
        'DISPLAY_TOP_PAGER' => 'N',
        'DISPLAY_BOTTOM_PAGER' => 'Y',
        'PAGER_TITLE' => 'Результаты поиска',
        'PAGER_SHOW_ALWAYS' => 'N',
        'PAGER_TEMPLATE' => '',
        'USE_SUGGEST' => 'N',
    )
);

require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php';
