<?php
require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';

$APPLICATION->SetTitle('Поиск');

require_once $_SERVER['DOCUMENT_ROOT'] . '/local/lib/CentrProgress/Search/PrefixQuery.php';
\CentrProgress\Search\PrefixQuery::applyToRequest();

// search.title must use a dedicated, deterministic entry point. Rendering it
// from the course footer lets the catalog page consume the AJAX request first
// and returns an entire HTML document instead of the suggestion fragment.
if (isset($_REQUEST['ajax_call'], $_REQUEST['INPUT_ID'])
    && (string) $_REQUEST['ajax_call'] === 'y'
    && (string) $_REQUEST['INPUT_ID'] === 'title-search-input'
) {
    $APPLICATION->IncludeComponent(
        'bitrix:search.title',
        'search',
        array(
            'SHOW_INPUT' => 'Y',
            'INPUT_ID' => 'title-search-input',
            'CONTAINER_ID' => 'title-search',
            'PRICE_CODE' => array(),
            'PRICE_VAT_INCLUDE' => 'Y',
            'PREVIEW_TRUNCATE_LEN' => '',
            'SHOW_PREVIEW' => 'Y',
            'PREVIEW_WIDTH' => '75',
            'PREVIEW_HEIGHT' => '75',
            'PAGE' => '#SITE_DIR#search/index.php',
            'NUM_CATEGORIES' => '1',
            'TOP_COUNT' => '5',
            'ORDER' => 'date',
            'USE_LANGUAGE_GUESS' => 'Y',
            'CHECK_DATES' => 'N',
            'SHOW_OTHERS' => 'N',
            'CATEGORY_0_TITLE' => '',
            'CATEGORY_0' => array('iblock_infosection'),
            'CATEGORY_0_iblock_infosection' => array('7'),
        ),
        false
    );
    exit;
}

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
