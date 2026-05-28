<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if (!CModule::IncludeModule('intec.startshop')) return;?>
<?
	global $APPLICATION;

	$this->setFrameMode(true);

	switch ($arParams['LINE_ELEMENT_COUNT']) {
		case 3: $sGridStyle = "startshop-33"; break;
		case 4: $sGridStyle = "startshop-25"; break;
		case 5: $sGridStyle = "startshop-20"; break;
		default : $sGridStyle = "startshop-50"; break;
	}
?>
<h2>Сопутствующие товары</h2>
<div class="Catalog startshop-catalog<?=$arParams['ADAPTABLE'] == "Y" ? " adaptiv" : ""?>">
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
                    $sAddToBasketUrl = $APPLICATION->GetCurPageParam(
                        urlencode('CatalogBasketAction').'=Add&'.
                        urlencode('CatalogBasketItem').'='.urlencode($arItem['ID']),
                        array('CatalogBasketAction', 'CatalogBasketItem')
                    );

                    $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], $strElementEdit);
                    $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], $strElementDelete, $arItemDeleteParams);
                ?>
                <div class="Item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
                    <div class="Item_Inner">
						<div class="Image">
							<?if (is_array($arItem["PROPERTIES"]["STIKER"]["VALUE_XML_ID"])):?>
							<div class="Stiker">
								<?foreach($arItem["PROPERTIES"]["STIKER"]["VALUE_XML_ID"] as $key=>$class){?>
								<span class="<?=$class?>"><?=$arItem["PROPERTIES"]["STIKER"]["VALUE"][$key]?></span>
								<?}?>
							</div>
							<?endif;?>
							<?if($arItem["PREVIEW_PICTURE"]):
								$PICTURE = CFile::ResizeImageGet($arItem["PREVIEW_PICTURE"], Array('width'=>235, 'height'=>160), BX_RESIZE_IMAGE_EXACT, true);
							?>  
							<a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><img src="<?=$PICTURE["src"]?>" alt="<?=$arItem["NAME"]?>" title="<?=$arItem["NAME"]?>" /></a>
							<?endif?>
						</div>
						<?if($arItem["PROPERTIES"]["BREND"]["VALUE"]):?>  
						<div class="Brend">
							<?
							$res = CIBlockElement::GetByID($arItem["PROPERTIES"]["BREND"]["VALUE"]);
							if($ar_res = $res->GetNext())
							  echo "<a href=".$ar_res['DETAIL_PAGE_URL'].">".$ar_res['NAME']."</a>";
							?>
							</div>
						<?endif?>
						<div class="Name"><a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><?=$arItem["NAME"]?></a></div>			
						<div class="buys">		
							<div class="PriceBlock">							
								<?if (empty($arItem['STARTSHOP']['OFFERS'])):?>
                                    <div class="Price">
										<span><?=$arItem['STARTSHOP']['PRICES']['MINIMAL']['PRINT_VALUE']?></span> 
										<?if($arItem["PROPERTIES"]["MEASURE"]["VALUE"]):?><?=$arItem["PROPERTIES"]["MEASURE"]["~VALUE"]?><?endif?>
									</div>
                                <?else:?>
                                    <?$arPrice = CStartShopToolsIBlock::GetOffersMinPrice($arItem);?>
                                    <?if (!empty($arPrice)):?>
                                        <div class="Price"><?=GetMessage("FROM")?> <span><?=$arPrice['PRINT_VALUE']?></span> 
										<?if($arItem["PROPERTIES"]["MEASURE"]["VALUE"]):?><?=$arItem["PROPERTIES"]["MEASURE"]["~VALUE"]?><?endif?>
									</div>
                                    <?endif;?>
                                    <?unset($arPrice);?>
                                <?endif;?>			
							</div>
							<?if($arItem["PROPERTIES"]["NALICHIE"]["VALUE"]):?>
							<div class="Availability"><?if($arItem["PROPERTIES"]["NALICHIE"]["VALUE_ENUM_ID"]=="30"):?><div class="available"><?else:?><div class="unavailable"><?endif?><?=$arItem["PROPERTIES"]["NALICHIE"]["VALUE"]?></div></div>
							<?endif?>	
						</div>
					</div>
                </div>
			<?endforeach;?>
		</div>
	<?endif;?>
	<?$frame->end();?>
</div>