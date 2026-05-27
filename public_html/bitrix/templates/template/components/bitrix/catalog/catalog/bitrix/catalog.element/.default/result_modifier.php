<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$arElement = CIblockElement::GetById($arResult["ID"])->GetNext();
$arResult['DETAIL_PAGE_URL'] = $arElement['DETAIL_PAGE_URL'];

if ($arResult["CODE"] == "otsenka-usloviy-truda") {
    $arResult['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'] = "«Специальная оценка условий труда»";
}

$cp = $this->__component; 
if (is_object($cp))
    $cp->SetResultCacheKeys(array('DETAIL_PAGE_URL'));