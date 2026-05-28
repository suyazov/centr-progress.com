<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
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
};?>
						<div class="Product" itemscope itemtype="http://schema.org/Product">
							<div class="Flex">
								<div class="DetailInfo">
								<h1 itemprop="name"><?$APPLICATION->ShowTitle(true);?></h1>
									<div class="Mobile CostBlock">
									<div class="CostBlock">
								<div class="Box">
								<div class="Order">
									<div class="Title">Записаться на курс</div>
									<?if (is_array($arResult["PROPERTIES"]["HIT"]["VALUE_XML_ID"])):?>
									<div class="Icon">
										<?foreach($arResult["PROPERTIES"]["HIT"]["VALUE_XML_ID"] as $key=>$class){?>
										<span class="<?=$class?>"><?=$arResult["PROPERTIES"]["HIT"]["VALUE"][$key]?></span>
										<?}?>
									</div>
									<?endif;?>
											<div class="Prices">
															<?if($arResult["PROPERTIES"]["DIST_PRICE"]["VALUE"]):?>
															<div class="Type" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
																<div class="Value">Очная с применением <br /> электронного обучения</div>
																<div class="Price">
																	<span itemprop="price" content="<?=number_format($arResult["PROPERTIES"]["DIST_PRICE"]["VALUE"], 0, ',', ' ' );?>"><?=number_format($arResult["PROPERTIES"]["DIST_PRICE"]["VALUE"], 0, ',', ' ' );?></span> руб.
																</div>
																<meta itemprop="name" content="Очная с применением электронного обучения">
																<link itemprop="availability" href="http://schema.org/InStock">
																<meta content="RUB" itemprop="priceCurrency">
															</div>
															<?endif?>
															<?if($arResult["PROPERTIES"]["PRICE"]["VALUE"]):?>
															<div class="Type" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
																<div class="Value">Очно</div>
																<div class="Price">
																	<span itemprop="price" content="<?=number_format($arResult["PROPERTIES"]["PRICE"]["VALUE"], 0, ',', ' ' );?>"><?=number_format($arResult["PROPERTIES"]["PRICE"]["VALUE"], 0, ',', ' ' );?></span> руб.
																</div>
																<meta itemprop="name" content="Очно">
																<link itemprop="availability" href="http://schema.org/InStock">
																<meta content="RUB" itemprop="priceCurrency">
															</div>
															<?endif?>
															<?if($arResult["PROPERTIES"]["DISTANSE_PRICE"]["VALUE"]):?>
															<div class="Type" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
																<div class="Value">Дистанционно</div>
																<div class="Price">
																	<span itemprop="price" content="<?=number_format($arResult["PROPERTIES"]["DISTANSE_PRICE"]["VALUE"], 0, ',', ' ' );?>"><?=number_format($arResult["PROPERTIES"]["DISTANSE_PRICE"]["VALUE"], 0, ',', ' ' );?></span> руб.
																</div>
																<meta itemprop="name" content="Дистанционно">
																<link itemprop="availability" href="http://schema.org/InStock">
																<meta content="RUB" itemprop="priceCurrency">
															</div>
															<?endif?>
											</div>
									<a data-fancybox="" data-src="#hidden-content" href="javascript:;" class="Btn Red">Заявка на обучение</a>
								</div>
									<div class="Props">
									<?if ($arResult["PROPERTIES"]["TIME"]["VALUE"]):?>
										<p><span class="Name"><?=$arResult["PROPERTIES"]["TIME"]["NAME"]?></span>
										<?=$arResult["PROPERTIES"]["TIME"]["VALUE"]?>
										</p>
									<?endif?>
									</div>
								</div>
							</div>
									</div>
									<div class="ProductTabs">
										<ul class="Links">
											<?if($arResult["DETAIL_TEXT"]):?>
											<li class="Active">Описание</li>
											<?endif;?>
											<?if($arResult["DISPLAY_PROPERTIES"]["PLAN"]["VALUE"]):?>
											<li>Учебный план</li>
											<?endif;?>
											<li>Выдаваемые документы</li>
										</ul>
										<?if($arResult["DETAIL_TEXT"]):?>
										<div class="BoxInfo Active">
											<div class="Anonse" itemprop="description"><?=$arResult["PREVIEW_TEXT"]?></div>
											<div class="InfoEducation">
												<div class="Items">
													<?if($arResult["DISPLAY_PROPERTIES"]["FORM"]["VALUE"]):?>
													<div class="Item">
														<div class="Item_Inner">
															<span><?=$arResult["DISPLAY_PROPERTIES"]["FORM"]["NAME"]?></span>
															<?if(is_array($arResult["PROPERTIES"]["FORM"]["VALUE"])):?><?=implode(', &nbsp;',$arResult["PROPERTIES"]["FORM"]["VALUE"]);?><?else:?><?=$arResult["PROPERTIES"]["FORM"]["VALUE"];?><?endif?>
														</div>
													</div>
													<?endif;?>
													<?if($arResult["DISPLAY_PROPERTIES"]["TYPE"]["VALUE"]):?>
													<div class="Item">
														<div class="Item_Inner">
														<span><?=$arResult["DISPLAY_PROPERTIES"]["TYPE"]["NAME"]?></span>
														<?=$arResult["DISPLAY_PROPERTIES"]["TYPE"]["VALUE"]?>
														</div>
													</div>
													<?endif;?>
													<?if($arResult["DISPLAY_PROPERTIES"]["TREBOVANIA"]["VALUE"]):?>
													<div class="Item">
														<div class="Item_Inner">
														<span><?=$arResult["DISPLAY_PROPERTIES"]["TREBOVANIA"]["NAME"]?></span>
														<?=$arResult["DISPLAY_PROPERTIES"]["TREBOVANIA"]["VALUE"]?>
														</div>
													</div>
													<?endif;?>
													<?if($arResult["DISPLAY_PROPERTIES"]["AGE"]["VALUE"]):?>
													<div class="Item">
														<div class="Item_Inner">
														<span><?=$arResult["DISPLAY_PROPERTIES"]["AGE"]["NAME"]?></span>
														<?=$arResult["DISPLAY_PROPERTIES"]["AGE"]["VALUE"]?>
														</div>
													</div>
													<?endif;?>
												</div>
											</div>
											<div class="BenefitsCont">
												<div class="Items">
													<div class="Item">
														<div class="Item_Inner">Скидки до 20% при коллективном обучении</div>
													</div>
													<div class="Item">
														<div class="Item_Inner">Удобная дистанционная платформа обучения</div>
													</div>
													<div class="Item">
														<div class="Item_Inner">Бессрочный доступ к учебным материалам</div>
													</div>
												</div>
											</div>
											<div class="Desc"><?=$arResult["DETAIL_TEXT"]?></div>
										</div>
										<?endif;?>
										<?if($arResult["DISPLAY_PROPERTIES"]["PLAN"]["VALUE"]):?>
										<div class="BoxInfo">
											<div class="TableBox">
												<?=htmlspecialcharsBack($arResult["DISPLAY_PROPERTIES"]["PLAN"]["VALUE"]["TEXT"])?>
											</div>
										</div>
										<?endif;?>
										<div class="BoxInfo">  
										<?if($arResult["DISPLAY_PROPERTIES"]["FILE"]["VALUE"]):?>
											<div class="FilesList Detail">
													<?if(is_array($arResult["DISPLAY_PROPERTIES"]['FILE']["DISPLAY_VALUE"])):
													foreach($arResult["DISPLAY_PROPERTIES"]['FILE']["DISPLAY_VALUE"] as $key=>$value):				
													$ext=substr($arResult["DISPLAY_PROPERTIES"]['FILE']['FILE_VALUE'][$key]['SRC'], strrpos($arResult["DISPLAY_PROPERTIES"]['FILE']['FILE_VALUE'][$key]['SRC'], '.') + 1);?>
													<div class="Item">
														<div class="DocList">
															<table>	
																<tr>
																	<td class="IconTD"><span class="<?=$ext?>"></span></td>
																	<td class="NameTD">
																		<div class="Name">
																			<a href="<?=$arResult["DISPLAY_PROPERTIES"]['FILE']['FILE_VALUE'][$key]['SRC']?>"><?if($arResult["DISPLAY_PROPERTIES"]['FILE']['FILE_VALUE'][$key]['DESCRIPTION']):?>
																			<?=$arResult["DISPLAY_PROPERTIES"]['FILE']['FILE_VALUE'][$key]['DESCRIPTION']?><?else:?><?=$arResult["NAME"]?><?endif?></a>
																		</div>
																		<div class="Format"><?=formatFileSize($arResult["DISPLAY_PROPERTIES"]['FILE']['FILE_VALUE'][$key]['FILE_SIZE'])?></div>
																	</td>
																</tr>
															</table>	
														</div>
													</div>
													<?endforeach;
														elseif($arResult["DISPLAY_PROPERTIES"]['FILE']['FILE_VALUE']['SRC']):
														$ext=substr($arResult["DISPLAY_PROPERTIES"]['FILE']['FILE_VALUE']['SRC'], strrpos($arResult["DISPLAY_PROPERTIES"]['FILE']['FILE_VALUE']['SRC'], '.') + 1);?>
													<div class="Item">
														<div class="DocList">
															<table>	
																<tr>
																	<td class="IconTD"><span class="<?=$ext?>"></span></td>
																	<td class="NameTD">
																		<div class="Name">
																			<a href="<?=$arResult["DISPLAY_PROPERTIES"]['FILE']['FILE_VALUE']['SRC']?>"><?if($arResult["DISPLAY_PROPERTIES"]['FILE']['FILE_VALUE']['DESCRIPTION']):?><?=$arResult["DISPLAY_PROPERTIES"]['FILE']['FILE_VALUE']['DESCRIPTION']?>
																			<?else:?><?=$arResult["NAME"]?><?endif?></a>
																		</div>
																		<div class="Format"><?=formatFileSize($arResult["DISPLAY_PROPERTIES"]['FILE']['FILE_VALUE']['FILE_SIZE'])?></div>
																	</td>
																</tr>
															</table>
														</div>
													</div>
												<?endif;?>	
											</div>
											<?endif?>
											<?$APPLICATION->IncludeComponent(
		"bitrix:catalog.section", 
		"docs", 
		array(
			"SEF_MODE" => "N",
			"SEF_RULE" => "",
			"AJAX_MODE" => "N",
			"IBLOCK_TYPE" => "info",
			"IBLOCK_ID" => "20",
			"SECTION_ID" => $_REQUEST["SECTION_ID"],
			"SECTION_CODE" => "",
			"SECTION_USER_FIELDS" => array(
				0 => "",
				1 => "FILE",
			),
			"ELEMENT_SORT_FIELD" => "sort",
			"ELEMENT_SORT_ORDER" => "asc",
			"ELEMENT_SORT_FIELD2" => "sort",
			"ELEMENT_SORT_ORDER2" => "asc",
			"FILTER_NAME" => "arrFilter",
			"INCLUDE_SUBSECTIONS" => "Y",
			"SHOW_ALL_WO_SECTION" => "Y",
			"SECTION_URL" => "",
			"DETAIL_URL" => "",
			"SECTION_ID_VARIABLE" => "SECTION_ID",
			"SET_TITLE" => "N",
			"SET_BROWSER_TITLE" => "N",
			"BROWSER_TITLE" => "-",
			"SET_META_KEYWORDS" => "N",
			"META_KEYWORDS" => "-",
			"SET_META_DESCRIPTION" => "N",
			"META_DESCRIPTION" => "-",
			"SET_LAST_MODIFIED" => "N",
			"USE_MAIN_ELEMENT_SECTION" => "N",
			"ADD_SECTIONS_CHAIN" => "N",
			"PAGE_ELEMENT_COUNT" => "20",
			"LINE_ELEMENT_COUNT" => "1",
			"OFFERS_LIMIT" => "0",
			"PRICE_CODE" => array(
			),
			"USE_PRICE_COUNT" => "N",
			"SHOW_PRICE_COUNT" => "1",
			"PRICE_VAT_INCLUDE" => "Y",
			"BASKET_URL" => "/personal/basket.php",
			"ACTION_VARIABLE" => "action",
			"PRODUCT_ID_VARIABLE" => "id",
			"USE_PRODUCT_QUANTITY" => "N",
			"PRODUCT_QUANTITY_VARIABLE" => "quantity",
			"ADD_PROPERTIES_TO_BASKET" => "Y",
			"PRODUCT_PROPS_VARIABLE" => "prop",
			"PARTIAL_PRODUCT_PROPERTIES" => "N",
			"BACKGROUND_IMAGE" => "-",
			"CACHE_TYPE" => "A",
			"CACHE_TIME" => "36000000",
			"CACHE_FILTER" => "N",
			"CACHE_GROUPS" => "Y",
			"COMPATIBLE_MODE" => "Y",
			"DISABLE_INIT_JS_IN_COMPONENT" => "N",
			"PAGER_TEMPLATE" => ".default",
			"DISPLAY_TOP_PAGER" => "N",
			"DISPLAY_BOTTOM_PAGER" => "Y",
			"PAGER_TITLE" => "Товары",
			"PAGER_SHOW_ALWAYS" => "N",
			"PAGER_DESC_NUMBERING" => "N",
			"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
			"PAGER_SHOW_ALL" => "N",
			"PAGER_BASE_LINK_ENABLE" => "N",
			"SET_STATUS_404" => "N",
			"SHOW_404" => "N",
			"MESSAGE_404" => "",
			"DISPLAY_COMPARE" => "N",
			"AJAX_OPTION_JUMP" => "N",
			"AJAX_OPTION_STYLE" => "Y",
			"AJAX_OPTION_HISTORY" => "N",
			"COMPONENT_TEMPLATE" => "docs",
			"AJAX_OPTION_ADDITIONAL" => "",
			"COMPOSITE_FRAME_MODE" => "A",
			"COMPOSITE_FRAME_TYPE" => "AUTO"
		),
		false
	);?>
										</div>
									</div>
								</div>
							<div class="CostBlock Desktop">
								<div class="Box">
								<div class="Order">
									<div class="Title">Записаться на курс</div>
									<?if (is_array($arResult["PROPERTIES"]["HIT"]["VALUE_XML_ID"])):?>
									<div class="Icon">
										<?foreach($arResult["PROPERTIES"]["HIT"]["VALUE_XML_ID"] as $key=>$class){?>
										<span class="<?=$class?>"><?=$arResult["PROPERTIES"]["HIT"]["VALUE"][$key]?></span>
										<?}?>
									</div>
									<?endif;?>
									<div class="Prices">
										
															<?if($arResult["PROPERTIES"]["DIST_PRICE"]["VALUE"]):?>
															<div class="Type">
																<span>Очная с применением <br /> электронного обучения</span>
																<div class="Flex Baseline">
																	<div class="Price">
																		<span><?=number_format($arResult["PROPERTIES"]["DIST_PRICE"]["VALUE"], 0, ',', ' ' );?></span> руб.
																	</div>
																</div>
															</div>
															<?endif?>
															<?if($arResult["PROPERTIES"]["PRICE"]["VALUE"]):?>
															<div class="Type">
																<span>Очно</span>
																<div class="Flex Baseline">
																	<div class="Price">
																		<span><?=number_format($arResult["PROPERTIES"]["PRICE"]["VALUE"], 0, ',', ' ' );?></span> руб.
																	</div>
																</div>
															</div>
															<?endif?>
															<?if($arResult["PROPERTIES"]["DISTANSE_PRICE"]["VALUE"]):?>
															<div class="Type">
																<span>Дистанционно</span>
																<div class="Flex Baseline">
																	<div class="Price">
																		<span><?=number_format($arResult["PROPERTIES"]["DISTANSE_PRICE"]["VALUE"], 0, ',', ' ' );?></span> руб.
																	</div>
																</div>
															</div>
															<?endif?>
									</div>
									<a data-fancybox="" data-src="#hidden-content" href="javascript:;" class="Btn Red">Заявка на обучение</a>
								</div>
									<div class="Props">
									<?if ($arResult["PROPERTIES"]["TIME"]["VALUE"]):?>
										<p><span class="Name"><?=$arResult["PROPERTIES"]["TIME"]["NAME"]?></span>
										<?=$arResult["PROPERTIES"]["TIME"]["VALUE"]?>
										</p>
									<?endif?>
									</div>
									<?/*if($arResult["DISPLAY_PROPERTIES"]["PROGRAMM"]["VALUE"]):
									$file=substr($arResult["DISPLAY_PROPERTIES"]['PROGRAMM']['FILE_VALUE']['SRC'], strrpos($arResult["DISPLAY_PROPERTIES"]['PROGRAMM']['FILE_VALUE']['SRC'], '.') + 1);
									?>
									<div class="Files">
										<span class="Name">Образовательная программа</span>
										<a href="<?=$arResult["DISPLAY_PROPERTIES"]['PROGRAMM']['FILE_VALUE']['SRC']?>">Скачать</a> / <span class="Size"><?=formatFileSize($arResult["DISPLAY_PROPERTIES"]['PROGRAMM']['FILE_VALUE']['FILE_SIZE'])?></span> /
									</div>
									<?endif;*/?>
								</div>
							</div>
							</div>
								<meta itemprop="name" content="<?=$arResult['NAME']?>" />
								<meta itemprop="category" content="<?=$arResult['ORIGINAL_PARAMETERS']['CURRENT_BASE_PAGE']?>" />
						</div>
							<div class="ServiceBlock Detail">
							<?global $arRelPrFilter;
							$arRelPrFilter = Array("!ID" => $arResult["ID"]);
							$APPLICATION->IncludeComponent(
								"bitrix:catalog.section", 
								"related", 
								array(
									"IBLOCK_TYPE" => "info",
									"IBLOCK_ID" => $arParams["IBLOCK_ID"],
									"ELEMENT_SORT_FIELD" => $sort,
									"ELEMENT_SORT_ORDER" => $sort_order,
									"ELEMENT_SORT_FIELD2" => $sort,
									"ELEMENT_SORT_ORDER2" => $sort_order,
									"PROPERTY_CODE" => array(
										1 => "BREND",
										4 => "MEASURE",
										5 => "NALICHIE",
										6 => "STIKER",
										9 => "OLD_PRICE",
									),
									"META_KEYWORDS" => $arParams["LIST_META_KEYWORDS"],
									"META_DESCRIPTION" => $arParams["LIST_META_DESCRIPTION"],
									"BROWSER_TITLE" => "N",
									"SET_LAST_MODIFIED" => "N",
									"INCLUDE_SUBSECTIONS" => "Y",
									"SHOW_ALL_WO_SECTION" => "Y",
									"BASKET_URL" => $arParams["BASKET_URL"],
									"ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
									"PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
									"SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
									"PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
									"PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
									"FILTER_NAME" => "arRelPrFilter",
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
									"PAGE_ELEMENT_COUNT" => "3",
									"LINE_ELEMENT_COUNT" => $arParams["LINE_ELEMENT_COUNT"],
									"PRICE_CODE" => array(
									),
									"USE_PRICE_COUNT" => "N",
									"SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],
									"PRICE_VAT_INCLUDE" => "N",
									"USE_PRODUCT_QUANTITY" => "N",
									"ADD_PROPERTIES_TO_BASKET" => "N",
									"PARTIAL_PRODUCT_PROPERTIES" => "N",
									"PRODUCT_PROPERTIES" => $arParams["PRODUCT_PROPERTIES"],
									"DISPLAY_TOP_PAGER" => "N",
									"DISPLAY_BOTTOM_PAGER" => "N",
									"PAGER_TITLE" => $arParams["PAGER_TITLE"],
									"PAGER_SHOW_ALWAYS" => "N",
									"PAGER_TEMPLATE" => $arParams["PAGER_TEMPLATE"],
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
									"COMPONENT_TEMPLATE" => "related",
									"SECTION_USER_FIELDS" => array(
										0 => "",
										1 => "",
									),
									"BACKGROUND_IMAGE" => "-",
									"SEF_MODE" => "N",
									"AJAX_MODE" => "N",
									"AJAX_OPTION_JUMP" => "N",
									"AJAX_OPTION_STYLE" => "Y",
									"AJAX_OPTION_HISTORY" => "N",
									"AJAX_OPTION_ADDITIONAL" => "",
									"SET_BROWSER_TITLE" => "N",
									"SET_META_KEYWORDS" => "N",
									"SET_META_DESCRIPTION" => "N",
									"COMPOSITE_FRAME_MODE" => "A",
									"COMPOSITE_FRAME_TYPE" => "AUTO",
									"COMPATIBLE_MODE" => "Y",
									"DISABLE_INIT_JS_IN_COMPONENT" => "N"
								),
								false
							);?> 
							</div>