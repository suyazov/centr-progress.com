<?php
$isTitleSearchAjax = isset($_REQUEST['ajax_call'], $_REQUEST['INPUT_ID'])
    && (string) $_REQUEST['ajax_call'] === 'y'
    && (string) $_REQUEST['INPUT_ID'] === 'title-search-input';

if ($isTitleSearchAjax) {
    define('PUBLIC_AJAX_MODE', true);
    require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php';
} else {
    require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';
}

$APPLICATION->SetTitle('Поиск');

require_once $_SERVER['DOCUMENT_ROOT'] . '/local/lib/CentrProgress/Search/PrefixQuery.php';
$GLOBALS['CENTR_PROGRESS_SEARCH_ORIGINAL_QUERY'] = isset($_REQUEST['q']) ? (string) $_REQUEST['q'] : '';

// search.title must use a dedicated, deterministic entry point. Rendering it
// from the course footer lets the catalog page consume the AJAX request first
// and returns an entire HTML document instead of the suggestion fragment.
if ($isTitleSearchAjax) {
    require_once $_SERVER['DOCUMENT_ROOT'] . '/local/lib/CentrProgress/Search/CatalogSearch.php';
    $query = $GLOBALS['CENTR_PROGRESS_SEARCH_ORIGINAL_QUERY'];
    $results = \CentrProgress\Search\CatalogSearch::search($query, 5);
    if ($results) {
        echo '<div class="bx_searche">';
        foreach ($results as $element) {
            $pictureId = !empty($element['PREVIEW_PICTURE']) ? $element['PREVIEW_PICTURE'] : $element['DETAIL_PICTURE'];
            $picture = $pictureId ? CFile::ResizeImageGet($pictureId, array('width' => 75, 'height' => 75), BX_RESIZE_IMAGE_PROPORTIONAL, true) : null;
            echo '<div class="bx_item_block">';
            if (is_array($picture) && !empty($picture['src'])) {
                echo '<div class="bx_img_element"><div class="bx_image" style="background-image:url(\'' . htmlspecialcharsbx($picture['src']) . '\')"></div></div>';
            }
            echo '<div class="bx_item_element"><a href="' . htmlspecialcharsbx($element['DETAIL_PAGE_URL']) . '">' . htmlspecialcharsbx($element['NAME']) . '</a></div><div style="clear:both"></div></div>';
        }
        echo '<div class="bx_item_block all_result"><div class="bx_item_element"><span class="all_result_title"><a href="/search/index.php?q=' . rawurlencode($query) . '">Все результаты</a></span></div></div></div>';
    }
    require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/epilog_after.php';
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
