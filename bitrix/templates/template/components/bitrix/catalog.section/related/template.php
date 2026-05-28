<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use Bas\Pict;?>
<?if (!empty($arResult['ITEMS'])):?>
<h3 class="Title">Похожие курсы</h3>
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
									<?if($arItem["PREVIEW_PICTURE"]):
										$PICTURE = CFile::ResizeImageGet($arItem["PREVIEW_PICTURE"], Array('width'=>266, 'height'=>280), BX_RESIZE_IMAGE_EXACT, true);
									?> 
									<a href="<?=$arItem["DETAIL_PAGE_URL"]?>" class="ImageBlock">
										<?if (is_array($arItem["PROPERTIES"]["STIKER"]["VALUE_XML_ID"])):?>
										<div class="Stiker">
											<?foreach($arItem["PROPERTIES"]["STIKER"]["VALUE_XML_ID"] as $key=>$class){?>
											<span class="<?=$class?>"><?=$arItem["PROPERTIES"]["STIKER"]["VALUE"][$key]?></span>
											<?}?>
										</div>
										<?endif;?> 
										<img src="<?=Pict::getResizeWebpSrc($arItem['PREVIEW_PICTURE'], 266, 280)?>" width="100%" height="280px" title="<?=$arItem["NAME"]?>" alt="<?=$arItem["NAME"]?>" />
									</a>
									<?endif?>
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
	<?endif;?>
	<?$frame->end();?>
</div>
	<?endif;?>