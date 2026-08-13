<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

if (!CModule::IncludeModule('iblock')) {
    return;
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/local/lib/CentrProgress/Search/CatalogSearch.php';
$query = isset($GLOBALS['CENTR_PROGRESS_SEARCH_ORIGINAL_QUERY'])
    ? (string) $GLOBALS['CENTR_PROGRESS_SEARCH_ORIGINAL_QUERY']
    : (isset($_REQUEST['q']) ? (string) $_REQUEST['q'] : '');
$catalogResults = \CentrProgress\Search\CatalogSearch::search($query, 50);
if ($catalogResults) {
    $arResult['SEARCH'] = array();
    foreach ($catalogResults as $element) {
        $arResult['SEARCH'][] = array(
            'MODULE_ID' => 'iblock',
            'ITEM_ID' => (string) $element['ID'],
            'URL' => $element['DETAIL_PAGE_URL'],
            'TITLE' => htmlspecialcharsbx($element['NAME']),
            'TITLE_FORMATED' => htmlspecialcharsbx($element['NAME']),
            'BODY_FORMATED' => htmlspecialcharsbx($element['PREVIEW_TEXT']),
            'TAGS' => array(),
            'CHAIN_PATH' => '',
        );
    }
}

if (empty($arResult['SEARCH'])) {
    return;
}

$elementIds = array();
foreach ($arResult['SEARCH'] as $item) {
    if (
        isset($item['MODULE_ID'], $item['ITEM_ID'])
        && $item['MODULE_ID'] === 'iblock'
        && ctype_digit((string) $item['ITEM_ID'])
    ) {
        $elementIds[] = (int) $item['ITEM_ID'];
    }
}

if (!$elementIds) {
    return;
}

$currentNames = array();
$elements = CIBlockElement::GetList(
    array('SORT' => 'ASC', 'ID' => 'ASC'),
    array(
        '=ID' => array_values(array_unique($elementIds)),
        'ACTIVE' => 'Y',
        'CHECK_PERMISSIONS' => 'Y',
        'MIN_PERMISSION' => 'R',
    ),
    false,
    false,
    array('ID', 'NAME')
);
while ($element = $elements->Fetch()) {
    $currentNames[(string) $element['ID']] = (string) $element['NAME'];
}

foreach ($arResult['SEARCH'] as &$item) {
    $itemId = isset($item['ITEM_ID']) ? (string) $item['ITEM_ID'] : '';
    if (isset($currentNames[$itemId])) {
        $safeName = htmlspecialcharsbx($currentNames[$itemId]);
        $item['TITLE'] = $safeName;
        $item['TITLE_FORMATED'] = $safeName;
    }
}
unset($item);
