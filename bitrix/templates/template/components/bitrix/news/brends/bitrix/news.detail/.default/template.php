<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
function formatFileSize($bytes) 
{
            if (!is_numeric($bytes) || !$bytes) {
                return '';
            }
            if ($bytes >= 1000000000) {
                return round($bytes / 1000000000,2).' '.GetMessage("GB");
            }
            if ($bytes >= 1000000) {
                return round($bytes / 1000000,2).' '.GetMessage("MB");
            }
            return round($bytes / 1000,2). ' '.GetMessage("KB");
}
?>
<div class="BrendsDetail">
	<?if($arResult["PREVIEW_TEXT"]):?>
	<div class="Desc">
		<?if($arResult["PREVIEW_PICTURE"]):?>
		<div class="PhotoBlock">
			<div class="Image">
			<?
			$PICTURE = CFile::ResizeImageGet($arResult["PREVIEW_PICTURE"], Array('width'=>810, 'height'=>450), BX_RESIZE_IMAGE_EXACT, true);
			?>
				<img src="<?=$PICTURE["src"]?>" alt="<?=$arResult["NAME"]?>" title="<?=$arResult["NAME"]?>" />
			</div>
		</div>
		<?endif;?>
		<?echo $arResult["PREVIEW_TEXT"];?>
	</div>
	<?endif?>
	<?
	$arProperty == "FILE";
	foreach($arResult["DISPLAY_PROPERTIES"] as $pid=>$arProperty):?>
	<?if($arResult["DISPLAY_PROPERTIES"]["FILE"]["VALUE"]):?>
	<div class="DocBlock">
		<div class="TitleDoc">Прикрепленные документы</div>
		<div class="FilesList">
			<?if(is_array($arResult["DISPLAY_PROPERTIES"]['FILE']["DISPLAY_VALUE"])):
			foreach($arResult["DISPLAY_PROPERTIES"]['FILE']["DISPLAY_VALUE"] as $key=>$value):				
			$ext=substr($arResult["DISPLAY_PROPERTIES"]['FILE']['FILE_VALUE'][$key]['SRC'], strrpos($arResult["DISPLAY_PROPERTIES"]['FILE']['FILE_VALUE'][$key]['SRC'], '.') + 1);?>
			<div class="Item">
				<table>	
					<tr>
						<td class="NameTD">
							<div class="Name">
								<a href="<?=$arResult["DISPLAY_PROPERTIES"]['FILE']['FILE_VALUE'][$key]['SRC']?>"><?if($arResult["DISPLAY_PROPERTIES"]['FILE']['FILE_VALUE'][$key]['DESCRIPTION']):?>
								<?=$arResult["DISPLAY_PROPERTIES"]['FILE']['FILE_VALUE'][$key]['DESCRIPTION']?><?else:?><?=$arResult["NAME"]?><?endif?></a>
							</div>
							<div class="Format"><span>.<?=$ext?></span>, <?=formatFileSize($arResult["DISPLAY_PROPERTIES"]['FILE']['FILE_VALUE'][$key]['FILE_SIZE'])?></div>
						</td>
					</tr>
				</table>	
			</div>
			<?endforeach;
				elseif($arResult["DISPLAY_PROPERTIES"]['FILE']['FILE_VALUE']['SRC']):
				$ext=substr($arResult["DISPLAY_PROPERTIES"]['FILE']['FILE_VALUE']['SRC'], strrpos($arResult["DISPLAY_PROPERTIES"]['FILE']['FILE_VALUE']['SRC'], '.') + 1);?>
			<div class="Item">
				<table>	
					<tr>
						<td class="NameTD">
							<div class="Name">
								<a href="<?=$arResult["DISPLAY_PROPERTIES"]['FILE']['FILE_VALUE']['SRC']?>"><?if($arResult["DISPLAY_PROPERTIES"]['FILE']['FILE_VALUE']['DESCRIPTION']):?><?=$arResult["DISPLAY_PROPERTIES"]['FILE']['FILE_VALUE']['DESCRIPTION']?>
								<?else:?><?=$arResult["NAME"]?><?endif?></a>
							</div>
							<div class="Format"><span>.<?=$ext?></span>, <?=formatFileSize($arResult["DISPLAY_PROPERTIES"]['FILE']['FILE_VALUE']['FILE_SIZE'])?></div>
						</td>
					</tr>
				</table>
			</div>
			<?endif;?>	
		</div>
	</div>					
	<?endif?>
	<?endforeach;?>
</div>	
<?if($arResult["PROPERTIES"]["TITLE"]["VALUE"]):?>
	<h2><?=$arResult["PROPERTIES"]["TITLE"]["VALUE"]?></h2>
<?endif?>
	  <?
				$GLOBALS['arrFilter'] = array("PROPERTY_BREND" => $arResult["ID"]);
					$APPLICATION->IncludeComponent(
	"bitrix:catalog.section", 
	"product-brend", 
	array(
		"IBLOCK_TYPE" => "catalog",
		"IBLOCK_ID" => "17",
		"ELEMENT_SORT_FIELD" => $sort,
		"ELEMENT_SORT_ORDER" => $sort_order,
		"ELEMENT_SORT_FIELD2" => $sort,
		"ELEMENT_SORT_ORDER2" => $sort_order,
		"PROPERTY_CODE" => array(
			0 => "",
			1 => "BREND",
			2 => "MEASURE",
			3 => "NALICHIE",
			4 => "STIKER",
			5 => "OLD_PRICE",
			6 => "",
		),
		"META_KEYWORDS" => $arParams["LIST_META_KEYWORDS"],
		"META_DESCRIPTION" => $arParams["LIST_META_DESCRIPTION"],
		"BROWSER_TITLE" => "-",
		"SET_LAST_MODIFIED" => "N",
		"INCLUDE_SUBSECTIONS" => "Y",
		"SHOW_ALL_WO_SECTION" => "Y",
		"BASKET_URL" => $arParams["BASKET_URL"],
		"ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
		"PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
		"SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
		"PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
		"PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
		"FILTER_NAME" => "arrFilter",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => $arParams["CACHE_TIME"],
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "N",
		"SET_TITLE" => "N",
		"MESSAGE_404" => $arParams["MESSAGE_404"],
		"SET_STATUS_404" => "N",
		"SHOW_404" => "N",
		"FILE_404" => $arParams["FILE_404"],
		"DISPLAY_COMPARE" => "N",
		"PAGE_ELEMENT_COUNT" => "9",
		"LINE_ELEMENT_COUNT" => $arParams["LINE_ELEMENT_COUNT"],
		"PRICE_CODE" => array(
			0 => "BASE",
		),
		"USE_PRICE_COUNT" => "N",
		"SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],
		"PRICE_VAT_INCLUDE" => "N",
		"USE_PRODUCT_QUANTITY" => "N",
		"ADD_PROPERTIES_TO_BASKET" => "N",
		"PARTIAL_PRODUCT_PROPERTIES" => "N",
		"PRODUCT_PROPERTIES" => array(
		),
		"DISPLAY_TOP_PAGER" => "N",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"PAGER_TITLE" => $arParams["PAGER_TITLE"],
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => "nav",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
		"PAGER_SHOW_ALL" => "N",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_BASE_LINK" => $arParams["PAGER_BASE_LINK"],
		"PAGER_PARAMS_NAME" => $arParams["PAGER_PARAMS_NAME"],
		"OFFERS_CART_PROPERTIES" => $arParams["OFFERS_CART_PROPERTIES"],
		"OFFERS_FIELD_CODE" => $arParams["LIST_OFFERS_FIELD_CODE"],
		"OFFERS_PROPERTY_CODE" => $arParams["LIST_OFFERS_PROPERTY_CODE"],
		"OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
		"OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
		"OFFERS_SORT_FIELD2" => $arParams["OFFERS_SORT_FIELD2"],
		"OFFERS_SORT_ORDER2" => $arParams["OFFERS_SORT_ORDER2"],
		"OFFERS_LIMIT" => $arParams["LIST_OFFERS_LIMIT"],
		"SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
		"SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
		"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
		"DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["element"],
		"USE_MAIN_ELEMENT_SECTION" => "N",
		"CONVERT_CURRENCY" => $arParams["CONVERT_CURRENCY"],
		"CURRENCY_ID" => $arParams["CURRENCY_ID"],
		"HIDE_NOT_AVAILABLE" => $arParams["HIDE_NOT_AVAILABLE"],
		"LABEL_PROP" => $arParams["LABEL_PROP"],
		"ADD_PICT_PROP" => $arParams["ADD_PICT_PROP"],
		"PRODUCT_DISPLAY_MODE" => $arParams["PRODUCT_DISPLAY_MODE"],
		"OFFER_ADD_PICT_PROP" => $arParams["OFFER_ADD_PICT_PROP"],
		"OFFER_TREE_PROPS" => $arParams["OFFER_TREE_PROPS"],
		"PRODUCT_SUBSCRIPTION" => $arParams["PRODUCT_SUBSCRIPTION"],
		"SHOW_DISCOUNT_PERCENT" => $arParams["SHOW_DISCOUNT_PERCENT"],
		"SHOW_OLD_PRICE" => $arParams["SHOW_OLD_PRICE"],
		"MESS_BTN_BUY" => $arParams["MESS_BTN_BUY"],
		"MESS_BTN_ADD_TO_BASKET" => $arParams["MESS_BTN_ADD_TO_BASKET"],
		"MESS_BTN_SUBSCRIBE" => $arParams["MESS_BTN_SUBSCRIBE"],
		"MESS_BTN_DETAIL" => $arParams["MESS_BTN_DETAIL"],
		"MESS_NOT_AVAILABLE" => $arParams["MESS_NOT_AVAILABLE"],
		"TEMPLATE_THEME" => (isset($arParams["TEMPLATE_THEME"])?$arParams["TEMPLATE_THEME"]:""),
		"ADD_SECTIONS_CHAIN" => "N",
		"ADD_TO_BASKET_ACTION" => $basketAction,
		"SHOW_CLOSE_POPUP" => isset($arParams["COMMON_SHOW_CLOSE_POPUP"])?$arParams["COMMON_SHOW_CLOSE_POPUP"]:"",
		"COMPARE_PATH" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["compare"],
		"COMPONENT_TEMPLATE" => "product-brend",
		"SECTION_USER_FIELDS" => array(
			0 => "",
			1 => "",
		),
		"BACKGROUND_IMAGE" => "-",
		"ADAPTABLE" => "N",
		"SHOW_LEFT_MENU_IN_ELEMENT" => "N",
		"SHOW_CUT_PROPS_OF_ELEMENT" => "N",
		"SHOW_SLIDER_IN_ELEMENT" => "N",
		"USE_COMMON_CURRENCY" => "N",
		"SEF_MODE" => "N",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"SET_BROWSER_TITLE" => "Y",
		"SET_META_KEYWORDS" => "Y",
		"SET_META_DESCRIPTION" => "Y",
		"PROPERTY_ARTICLE" => "",
		"PROPERTY_MORE_PICTURES" => "",
		"PROPERTY_MORE_PICTURES_OFFERS" => "",
		"CATALOG_MENU" => "catalog",
		"GRID_CATALOG_ROOT_SECTIONS_COUNT" => "5",
		"GRID_CATALOG_SECTIONS_COUNT" => "4",
		"REVIEWS_IBLOCK_TYPE" => "info",
		"REVIEWS_IBLOCK_ID" => "",
		"COMPATIBLE_MODE" => "Y",
		"DISABLE_INIT_JS_IN_COMPONENT" => "N"
	),
	false
);?> 