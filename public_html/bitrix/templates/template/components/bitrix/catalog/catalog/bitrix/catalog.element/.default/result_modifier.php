<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$arElement = CIblockElement::GetById($arResult["ID"])->GetNext();
$arResult['DETAIL_PAGE_URL'] = $arElement['DETAIL_PAGE_URL'];

// Убираем "по профессии" из заголовка
if (!empty($arResult['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE']) && strpos($arResult['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'], 'по профессии') !== false) {
    $arResult['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'] = str_replace(' по профессии ', ' ', $arResult['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE']);
}

$cp = $this->__component; 
if (is_object($cp))
    $cp->SetResultCacheKeys(array('DETAIL_PAGE_URL'));