<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use Bas\Pict;?>
						<div class="ContBlock">
							<div class="Content">
<?if($arResult["DEPTH_LEVEL"]>=2):?>
<?
$this->SetViewTarget('category');
$APPLICATION->IncludeComponent(
	"bitrix:catalog.section.list",
	"category",
	array(
		"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
		"IBLOCK_ID" => $arParams["IBLOCK_ID"],
		"SECTION_ID" => $arResult["IBLOCK_SECTION_ID"],
		"SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
		"CACHE_TYPE" => $arParams["CACHE_TYPE"],
		"CACHE_TIME" => $arParams["CACHE_TIME"],
		"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
		"COUNT_ELEMENTS" => $arParams["SECTION_COUNT_ELEMENTS"],
		"TOP_DEPTH" => $arParams["SECTION_TOP_DEPTH"],
		"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
		"VIEW_MODE" => $arParams["SECTIONS_VIEW_MODE"],
		"SHOW_PARENT_NAME" => $arParams["SECTIONS_SHOW_PARENT_NAME"],
		"HIDE_SECTION_NAME" => (isset($arParams["SECTIONS_HIDE_SECTION_NAME"]) ? $arParams["SECTIONS_HIDE_SECTION_NAME"] : "N"),
		"ADD_SECTIONS_CHAIN" => "N"
	),
	$component,
	array("HIDE_ICONS" => "Y")
);
$this->EndViewTarget();
?>
<?endif;?>

<div class="Service">
	<?$frame = $this->createFrame()->begin()?>
	<?if (!empty($arResult['ITEMS'])):?>
		<div class="Items">
			<?
				$strElementEdit = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT");
				$strElementDelete = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE");
				$arItemDeleteParams = array("CONFIRM" => GetMessage('SH_CS_TILE_ELEMENT_DELETE_CONFIRM'));
			?>
			<?foreach($arResult["ITEMS"] as $sKey => $arItem):?>
                <?
                    $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], $strElementEdit);
                    $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], $strElementDelete, $arItemDeleteParams);
                ?>
							<div class="Item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
								<div class="Flex">
									<div class="DescBlock">
										<div class="Name"><a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><?=$arItem["NAME"]?></a></div>	
										<?if($arItem["PROPERTIES"]["PROPS"]["VALUE"]):?> 
										<div class="Info">
											<?foreach($arItem["PROPERTIES"]["PROPS"]["VALUE"] as $k=>$value):?>
											<p><?=$value?><?if($arItem["PROPERTIES"]["PROPS"]["DESCRIPTION"][$k]):?>: <?=$arItem["PROPERTIES"]["PROPS"]["DESCRIPTION"][$k]?><?endif;?></p>
											<?endforeach?> 
										</div>
										<?endif;?>  
									</div>
										<div class="PriceInfo">
											<div class="Box">
												<div class="PriceBlock">
														<?if($arItem["PROPERTIES"]["PRICE"]["VALUE"]):?>
														<div class="Type">
															<div class="Value">Очно</div>
															<div class="Price">
																<span><?=number_format($arItem["PROPERTIES"]["PRICE"]["VALUE"], 0, ',', ' ' );?></span> руб.
															</div>
														</div>
														<?endif?>
														<?if($arItem["PROPERTIES"]["DISTANSE_PRICE"]["VALUE"]):?>
														<div class="Type">
															<div class="Value">Дистанционно</div>
															<div class="Price">
																<span><?=number_format($arItem["PROPERTIES"]["DISTANSE_PRICE"]["VALUE"], 0, ',', ' ' );?></span> руб.
															</div>
														</div>
														<?endif?>
														<?if($arItem["PROPERTIES"]["DIST_PRICE"]["VALUE"]):?>
														<div class="Type">
															<div class="Value">Очная с применением электронного обучения</div>
															<div class="Price">
																<span><?=number_format($arItem["PROPERTIES"]["DIST_PRICE"]["VALUE"], 0, ',', ' ' );?></span> руб.
															</div>
														</div>
														<?endif?>
												</div>
												<div class="Link"><a href="<?=$arItem["DETAIL_PAGE_URL"]?>">Подробнее</a></div>
											</div>
										</div>
								</div>
							</div>
			<?endforeach;?>
		</div>
		<?if ($arParams["DISPLAY_BOTTOM_PAGER"]):?>
			<?=$arResult['NAV_STRING']?>
		<?endif;?>
	<?else:?>
		Извините, данный раздел находится на стадии наполнения.
	<?endif;?>
	<?$frame->end();?>
</div>
<?
$this->SetViewTarget('description');
if($arResult['DESCRIPTION']):?>



<div class="Description">



	<div class="Wrapper">
		<div class="Flex">
			<?if($arResult["DETAIL_PICTURE"]):
				$PICTURE = CFile::ResizeImageGet($arResult["DETAIL_PICTURE"], Array('width'=>518, 'height'=>510), BX_RESIZE_IMAGE_EXACT, true);
			?>  
			<div class="ImageBlock">
				<img src="<?=$PICTURE["src"]?>" alt="<?=$arResult["NAME"]?>" title="<?=$arResult["NAME"]?>" />
			</div>
			<?endif?>
			<div class="InfoBlock<?if($arResult["DETAIL_PICTURE"]):?> Img<?endif;?>">
		<?=$arResult['DESCRIPTION']?>
			</div>
		</div>
	</div>
</div>	
<?endif;
$APPLICATION->IncludeComponent(
				"bitrix:news.list", 
				"benefits", 
				array(
					"ACTIVE_DATE_FORMAT" => "d.m.Y",
					"ADD_SECTIONS_CHAIN" => "Y",
					"AJAX_MODE" => "N",
					"AJAX_OPTION_ADDITIONAL" => "",
					"AJAX_OPTION_HISTORY" => "N",
					"AJAX_OPTION_JUMP" => "N",
					"AJAX_OPTION_STYLE" => "Y",
					"CACHE_FILTER" => "N",
					"CACHE_GROUPS" => "N",
					"CACHE_TIME" => "36000000",
					"CACHE_TYPE" => "A",
					"CHECK_DATES" => "Y",
					"DETAIL_URL" => "",
					"DISPLAY_BOTTOM_PAGER" => "Y",
					"DISPLAY_DATE" => "Y", 
					"DISPLAY_NAME" => "Y",
					"DISPLAY_PICTURE" => "Y",
					"DISPLAY_PREVIEW_TEXT" => "Y",
					"DISPLAY_TOP_PAGER" => "N",
					"FIELD_CODE" => array(
						0 => "",
						1 => "",
					),
					"FILTER_NAME" => "",
					"HIDE_LINK_WHEN_NO_DETAIL" => "N",
					"IBLOCK_ID" => "6",
					"IBLOCK_TYPE" => "info",
					"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
					"INCLUDE_SUBSECTIONS" => "N",
					"MESSAGE_404" => "",
					"NEWS_COUNT" => "4",
					"PAGER_BASE_LINK_ENABLE" => "N",
					"PAGER_DESC_NUMBERING" => "N",
					"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
					"PAGER_SHOW_ALL" => "N",
					"PAGER_SHOW_ALWAYS" => "N",
					"PAGER_TEMPLATE" => ".default",
					"PAGER_TITLE" => "Новости",
					"PARENT_SECTION" => "",
					"PARENT_SECTION_CODE" => "",
					"PREVIEW_TRUNCATE_LEN" => "",
					"PROPERTY_CODE" => array(
						0 => "",
						1 => "",
					),
					"SET_BROWSER_TITLE" => "N",
					"SET_LAST_MODIFIED" => "N",
					"SET_META_DESCRIPTION" => "N",
					"SET_META_KEYWORDS" => "N",
					"SET_STATUS_404" => "N",
					"SET_TITLE" => "N",
					"SHOW_404" => "N",
					"SORT_BY1" => "SORT",
					"SORT_BY2" => "SORT",
					"SORT_ORDER1" => "ASC",
					"SORT_ORDER2" => "ASC",
					"STRICT_SECTION_CHECK" => "N",
					"COMPONENT_TEMPLATE" => "benefits"
				),
   $component, // Добавляем
   array("HIDE_ICONS" => "Y") // Добавляем
);



global $USER;
if ($USER->IsAdmin()){
?>

<div class="block_doc_vyd">
	<div class="Wrapper doc_vyd">
<?/*$APPLICATION->IncludeComponent(
	"bitrix:news.list", 
	"doc_vyd_sl", 
	array(
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"ADD_SECTIONS_CHAIN" => "N",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "N",
		"CACHE_TIME" => "86400",
		"CACHE_TYPE" => "A",
		"CHECK_DATES" => "Y",
		"DETAIL_URL" => "",
		"DISPLAY_BOTTOM_PAGER" => "N",
		"DISPLAY_DATE" => "Y",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"DISPLAY_TOP_PAGER" => "N",
		"FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"FILTER_NAME" => "",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"IBLOCK_ID" => "24",
		"IBLOCK_TYPE" => "info",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"INCLUDE_SUBSECTIONS" => "Y",
		"MESSAGE_404" => "",
		"NEWS_COUNT" => "50",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => ".default",
		"PAGER_TITLE" => "Новости",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"PREVIEW_TRUNCATE_LEN" => "",
		"PROPERTY_CODE" => array(
			0 => "",
			1 => "AUTHOR",
			2 => "",
		),
		"SET_BROWSER_TITLE" => "N",
		"SET_LAST_MODIFIED" => "N",
		"SET_META_DESCRIPTION" => "N",
		"SET_META_KEYWORDS" => "N",
		"SET_STATUS_404" => "Y",
		"SET_TITLE" => "N",
		"SHOW_404" => "Y",
		"SORT_BY1" => "SORT",
		"SORT_BY2" => "ACTIVE_FROM",
		"SORT_ORDER1" => "ASC",
		"SORT_ORDER2" => "DESC",
		"STRICT_SECTION_CHECK" => "N",
		"COMPONENT_TEMPLATE" => "doc_vyd_sl",
		"FILE_404" => "",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO"
	),
	false
);*/?>
	</div>
</div>
<div class="block_cat_fos">
	<div class="Wrapper cat_fos">
		<div class="cat_fos_left">
            <?
                $APPLICATION->IncludeComponent(
                "bitrix:main.include",
                "",
                Array(
                "AREA_FILE_SHOW" => "file", 
                "PATH" => "/includes/img_foto_cat.php",
                "EDIT_MODE" => "html" 
                )
                );
            ?>   
		</div>
		<div class="cat_fos_right">
			<div class="cat_fos_right_zag">Оставьте заявку на обучение</div>
			<div class="cat_fos_right_podzag">Бесплатно проконсультируем по всем услугам за 5 мин.</div>
			<div class="main_form_rez">
				<input type="text" id="usl_name" class="main_inp" placeholder="Ваше имя">
				<input type="text" id="usl_tel" class="main_inp inp_tel" placeholder="Введите Ваш телефон">
				<input type="hidden" id="usl_str" value="<?=$_SERVER['REQUEST_URI']?>"  >
				<div class="main_form_rez_btn" onclick="sendFosUsl()">Отправить</div>
				<div class="main_form_rez_polit">
			<input type="checkbox" name="check_status" checked="checked" value="1" class="radio_hidden" id="check_status1">
			<label class="status_check_item" for="check_status1">Нажимая на кнопку, вы даете согласие на обработку персональных данных.</label>
				</div>
			</div>

		</div>
	</div>
</div>	
<?}?>

<?
$vopr_id=array();
CModule::IncludeModule('iblock');
  $arSelect_1 = Array('ID', 'NAME', 'UF_VOPR');
  $arFilter_1 = Array('IBLOCK_ID'=>7, 'ID'=>$arResult['ID']);
  $row1 = CIBlockSection::GetList(Array("ID"=>"DESC"), $arFilter_1, false, $arSelect_1, Array("nPageSize"=>10));	
  while($mass_row1 = $row1->GetNext())
{
if ($mass_row1['UF_VOPR']){
	$vopr_id=$mass_row1['UF_VOPR'];
}
}


?>

<?
if ($vopr_id[0]!=''){
?>




<div class="block_doc_faq">
	<div class="Wrapper bl_faq">
		<div class="doc_vyd_zag">Вопрос-ответ</div>
		<div class="doc_vyd_cont">

<?


GLOBAL $arfilter2;
$arfilter2 = array(
'ID' => $vopr_id,
);
 
?>

	<?$APPLICATION->IncludeComponent(
	"bitrix:news.list", 
	"items-list", 
	array(
		"DISPLAY_DATE" => "Y",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"AJAX_MODE" => "N",
		"IBLOCK_TYPE" => "info",
		"IBLOCK_ID" => "16",
		"NEWS_COUNT" => "20",
		"SORT_BY1" => "ACTIVE_FROM",
		"SORT_ORDER1" => "DESC",
		"SORT_BY2" => "SORT",
		"SORT_ORDER2" => "ASC",
		"FILTER_NAME" => "arfilter2",
		"FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"PROPERTY_CODE" => array(
			0 => "",
			1 => "",
		),
		"CHECK_DATES" => "Y",
		"DETAIL_URL" => "",
		"PREVIEW_TRUNCATE_LEN" => "",
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"SET_TITLE" => "N",
		"SET_BROWSER_TITLE" => "N",
		"SET_META_KEYWORDS" => "N",
		"SET_META_DESCRIPTION" => "N",
		"SET_LAST_MODIFIED" => "N",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"ADD_SECTIONS_CHAIN" => "N",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"INCLUDE_SUBSECTIONS" => "Y",
		"STRICT_SECTION_CHECK" => "N",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"CACHE_NOTES" => "",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"PAGER_TEMPLATE" => ".default",
		"DISPLAY_TOP_PAGER" => "N",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"PAGER_TITLE" => "Новости",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"SET_STATUS_404" => "Y",
		"SHOW_404" => "Y",
		"MESSAGE_404" => "",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"COMPONENT_TEMPLATE" => "items-list",
		"AJAX_OPTION_ADDITIONAL" => "",
		"FILE_404" => ""
	),
	false
);?>
		</div>
	</div>
</div>
<?}?>


<?
global $USER;
if ($USER->IsAdmin()){
?>


<?$APPLICATION->IncludeComponent(
	"bitrix:news.list", 
	"reviews", 
	array(
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"ADD_SECTIONS_CHAIN" => "Y",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "N",
		"CACHE_TIME" => "86400",
		"CACHE_TYPE" => "A",
		"CHECK_DATES" => "Y",
		"DETAIL_URL" => "",
		"DISPLAY_BOTTOM_PAGER" => "N",
		"DISPLAY_DATE" => "Y",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"DISPLAY_TOP_PAGER" => "N",
		"FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"FILTER_NAME" => "",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"IBLOCK_ID" => "5",
		"IBLOCK_TYPE" => "info",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"INCLUDE_SUBSECTIONS" => "Y",
		"MESSAGE_404" => "",
		"NEWS_COUNT" => "5",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => ".default",
		"PAGER_TITLE" => "Новости",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"PREVIEW_TRUNCATE_LEN" => "",
		"PROPERTY_CODE" => array(
			0 => "AUTHOR",
			1 => "",
		),
		"SET_BROWSER_TITLE" => "N",
		"SET_LAST_MODIFIED" => "N",
		"SET_META_DESCRIPTION" => "N",
		"SET_META_KEYWORDS" => "N",
		"SET_STATUS_404" => "Y",
		"SET_TITLE" => "N",
		"SHOW_404" => "Y",
		"SORT_BY1" => "ACTIVE_FROM",
		"SORT_BY2" => "ACTIVE_FROM",
		"SORT_ORDER1" => "DESC",
		"SORT_ORDER2" => "DESC",
		"STRICT_SECTION_CHECK" => "N",
		"COMPONENT_TEMPLATE" => "reviews",
		"FILE_404" => ""
	),
	false
);?>



<?/*$APPLICATION->IncludeComponent(
	"bitrix:news.list", 
	"licenzii", 
	array(
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"ADD_SECTIONS_CHAIN" => "Y",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "N",
		"CACHE_TIME" => "86400",
		"CACHE_TYPE" => "A",
		"CHECK_DATES" => "Y",
		"DETAIL_URL" => "",
		"DISPLAY_BOTTOM_PAGER" => "N",
		"DISPLAY_DATE" => "Y",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"DISPLAY_TOP_PAGER" => "N",
		"FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"FILTER_NAME" => "",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"IBLOCK_ID" => "22",
		"IBLOCK_TYPE" => "info",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"INCLUDE_SUBSECTIONS" => "Y",
		"MESSAGE_404" => "",
		"NEWS_COUNT" => "10",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => ".default",
		"PAGER_TITLE" => "Новости",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"PREVIEW_TRUNCATE_LEN" => "",
		"PROPERTY_CODE" => array(
			0 => "AUTHOR",
			1 => "",
		),
		"SET_BROWSER_TITLE" => "N",
		"SET_LAST_MODIFIED" => "N",
		"SET_META_DESCRIPTION" => "N",
		"SET_META_KEYWORDS" => "N",
		"SET_STATUS_404" => "Y",
		"SET_TITLE" => "N",
		"SHOW_404" => "Y",
		"SORT_BY1" => "ACTIVE_FROM",
		"SORT_BY2" => "ACTIVE_FROM",
		"SORT_ORDER1" => "DESC",
		"SORT_ORDER2" => "DESC",
		"STRICT_SECTION_CHECK" => "N",
		"COMPONENT_TEMPLATE" => "reviews",
		"FILE_404" => ""
	),
	false
);*/?>
<?
}



$this->EndViewTarget();?>
</div>
</div>