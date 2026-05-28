<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
 
global $APPLICATION;
// мы не хотим показывать для первой страницы в Тайтл номер страницы
if($arResult["NavPageNomer"] > 1) {
    $APPLICATION->SetPageProperty("NavPageNomer", $arResult["NavPageNomer"]);
    $APPLICATION->SetPageProperty("NavPageCount", $arResult["NavPageCount"]);
}?>