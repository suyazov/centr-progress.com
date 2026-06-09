<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
global $APPLICATION;
// Убираем "по профессии" из заголовка
if (!empty($arResult['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'])) {
    $title = $arResult['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'];
    // Ищем и убираем "по профессии" из заголовка
    if (strpos($title, 'по профессии') !== false) {
        $title = str_replace(' по профессии ', ' ', $title);
        $arResult['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'] = $title;
        // Перезаписываем title
        $APPLICATION->SetTitle($title);
    }
}