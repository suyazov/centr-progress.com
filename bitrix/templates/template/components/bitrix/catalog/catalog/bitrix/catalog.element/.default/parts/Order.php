<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main\Localization\Loc;
use Bitrix\Highloadblock\HighloadBlockTable as HLBT;

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $item
 * @var array $actualItem
 * @var array $minOffer
 * @var array $itemIds
 * @var array $price
 * @var array $measureRatio
 * @var bool $haveOffers
 * @var bool $showSubscribe
 * @var array $morePhoto
 * @var bool $showSlider
 * @var bool $itemHasDetailUrl
 * @var string $imgTitle
 * @var string $productTitle
 * @var string $buttonSizeClass
 * @var CatalogSectionComponent $component
 */
?>


<?if (empty($arResult['STARTSHOP']['OFFERS'])):?>
    <?if ($arResult['STARTSHOP']['AVAILABLE']):?>
        <?
            $sAddToBasketUrl = $APPLICATION->GetCurPageParam(
                urlencode('CatalogBasketAction').'=Add&'.
                urlencode('CatalogBasketItem').'='.urlencode($arResult['ID']).'&'.
                urlencode('CatalogBasketPrice').'='.urlencode($arResult['STARTSHOP']['PRICES']['MINIMAL']['TYPE']),
                array('CatalogBasketAction', 'CatalogBasketItem', 'CatalogBasketPrice', 'CatalogBasketQuantity')
            );
        ?>
        <div class="CalcDetail startshop-order StartShopOffersOrder<?=$arResult['ID']?>">
            <?if (!$arResult['STARTSHOP']['BASKET']['INSIDE']):?>
				<div class="PriceBlock"> 
											<div class="Flex">
												<div class="Price">
													<div class="Name">Цена</div>
													<div class="startshop-price">
														от 
														<span class="startshop-current StartShopOffersPrice" data-price="<?=number_format($arResult['STARTSHOP']['PRICES']['MINIMAL']['PRINT_VALUE'], 0, ',', ' ' )?>"><?=number_format($arResult['STARTSHOP']['PRICES']['MINIMAL']['PRINT_VALUE'], 0, ',', ' ' )?></span> руб. <?if($arResult["PROPERTIES"]["MEASURE"]["VALUE"]):?>/<?=$arResult["PROPERTIES"]["MEASURE"]["~VALUE"]?><?endif?>
													</div>
												</div>
												<?if($arResult["PROPERTIES"]["OLD_PRICE"]["VALUE"]):?>
												<div class="Cost">
													<div class="Name">&nbsp;</div>
													<div class="startshop-price OldPrice">
														<span><?=$arResult["PROPERTIES"]["OLD_PRICE"]["VALUE"]?></span> руб. <?if($arResult["PROPERTIES"]["MEASURE"]["VALUE"]):?>/<?=$arResult["PROPERTIES"]["MEASURE"]["~VALUE"]?><?endif?>
													</div>
												</div>
												<?endif?>
											</div>
										</div><?if($arResult['PROPERTIES']["COLOR"]["VALUE"]):?>
										<div class="PropsColor">
											<span class="Name">Доступные цвета</span>
			<ul>
	<?
		CModule::IncludeModule('highloadblock');

		$highblock_id = 1;
		$hl_block = HLBT::getById($highblock_id)->fetch();

		// Получение имени класса
		$entity = HLBT::compileEntity($hl_block);
		$entity_data_class = $entity->getDataClass();
		
		$rs_data = $entity_data_class::getList(array(
		   'select' => array('*'),
		));
		while ($el = $rs_data->fetch()){
			?>
			<?$i=0;
			foreach($arResult["PROPERTIES"]["COLOR"]["VALUE"] as $color){?> 
			<?if($el["UF_XML_ID"]==$color):?>
				<?
				$img_path = CFile::GetPath($el["UF_FILE"]); //ПОЛУЧАЕМ ПУСТЬ К КАРТИНКЕ
				echo '<li class="Color"><img src="'.$img_path.'" title="'.$el["UF_NAME"].'" alt="'.$el["UF_NAME"].'" /><span>'.$el["UF_NAME"].'</span></li>';
				?>
			<?endif;?>
			<?
			$i++;
			if($i==5)break;
			}?>
			<?
		}
			if(count($arResult["PROPERTIES"]["COLOR"]["VALUE"])>5):
				echo "<li class=\"AllColor\"><a data-fancybox data-src=\"#Color\" href=\"javascript:;\">Все цвета</a></li>";
			endif;
	?> 
			</ul>
										</div>
											<?endif;?>
				<div class="AddCart"> 
					<div class="Flex">
						<div class="startshop-input-numeric">
							<?$arProductCount = array(
								"Value" => floatval($arResult['STARTSHOP']['QUANTITY']['RATIO']),
								"Minimum" => floatval($arResult['STARTSHOP']['QUANTITY']['RATIO']),
								"Maximum" => floatval($arResult['STARTSHOP']['QUANTITY']['VALUE']),
								"Ratio" => floatval($arResult['STARTSHOP']['QUANTITY']['RATIO']),
								"Unlimited" => !$arResult['STARTSHOP']['QUANTITY']['USE'],
								"ValueType" => "Float"
							)?>
							<button class="minus" onclick="ProductCount.Decrease();">-</button>
							<input type="text" name="count" class="quantity startshop-input-numeric-text ProductCount Count_<?=$arResult['ID']?>" onchange="ProductCount.SetValue($(this).val());" value="<?=floatval($arResult['STARTSHOP']['QUANTITY']['RATIO'])?>" />
							<button class="plus" onclick="ProductCount.Increase();">+</button>
							<script type="text/javascript">
								var ProductCount = new Startshop.Controls.NumericUpDown(<?=CUtil::PhpToJSObject($arProductCount)?>);
								ProductCount.Settings.Events.OnValueChange = function($oNumeric) {
									$('.ProductCount').val($oNumeric.GetValue());
								};	
							</script>
						</div>
						<div class="startshop-buy">
							<a rel="nofollow" class="startshop-button startshop-button-standart to-cart" id="to_cart_<?=$arElement['ID']?>" onClick="window.location.href = '<?=$sAddToBasketUrl?>&CatalogBasketQuantity=' + ProductCount.GetValue()">
								<span onclick="ym(38770565, 'reachGoal', 'Dobavit_tovar_v_korzinu'); return true;"><?=GetMessage("SH_CE_DEFAULT_ADD_TO_BASKET")?></span>
							</a>
						</div>
					</div>
				</div>
            <?else:?>
                <div class="startshop-buy">
                    <a rel="nofollow" href="<?=$arParams["BASKET_URL"];?>" id="in_cart_<?=$arElement['ID']?>" class="startshop-button startshop-button-standart startshop-status-focus to-cart-added">
                        <span><?=GetMessage("SH_CE_DEFAULT_ADDED_TO_BASKET")?></span>
                    </a>
                </div>
            <?endif;?>
        </div>
    <?endif;?>
										<div class="Flex">
											<div class="PropsList">
												<?if($arResult["PROPERTIES"]["TOLSHINA_LISTA"]["VALUE"]):?>
												<p><?=$arResult["PROPERTIES"]["TOLSHINA_LISTA"]["NAME"]?>: <?=$arResult["PROPERTIES"]["TOLSHINA_LISTA"]["VALUE"]?></p>
												<?endif;?>
												<?if($arResult["PROPERTIES"]["POVERHNOST"]["VALUE"]):?>
												<p><?=$arResult["PROPERTIES"]["POVERHNOST"]["NAME"]?>: <?=$arResult["PROPERTIES"]["POVERHNOST"]["VALUE"]?></p>
												<?endif;?>
												<?if($arResult["PROPERTIES"]["TOLSHINA_POKRYTIYA"]["VALUE"]):?>
												<p><?=$arResult["PROPERTIES"]["TOLSHINA_POKRYTIYA"]["NAME"]?>: <?=$arResult["PROPERTIES"]["TOLSHINA_POKRYTIYA"]["VALUE"]?></p>
												<?endif;?>
											</div>
										</div>
<div style="display: none;" id="Color">
	<?if($arResult['PROPERTIES']["COLOR"]["VALUE"]):?>
										<div class="Popup PopupColor">
											<div class="Title">Доступные цвета</div>
											<div class="PopupBlock">
			<ul>
	<?
		CModule::IncludeModule('highloadblock');

		$highblock_id = 1;
		$hl_block = HLBT::getById($highblock_id)->fetch();

		// Получение имени класса
		$entity = HLBT::compileEntity($hl_block);
		$entity_data_class = $entity->getDataClass();
		
		$rs_data = $entity_data_class::getList(array(
		   'select' => array('*'),
		));
		while ($elcol = $rs_data->fetch()){
			?>
			<?foreach($arResult["PROPERTIES"]["COLOR"]["VALUE"] as $color){?> 
			<?if($elcol["UF_XML_ID"]==$color):?>
				<?
				$img_path = CFile::GetPath($elcol["UF_FILE"]); //ПОЛУЧАЕМ ПУСТЬ К КАРТИНКЕ
				echo '<li class="Color"><img src="'.$img_path.'" title="'.$elcol["UF_NAME"].'" alt="'.$elcol["UF_NAME"].'" /><div class="Name">'.$elcol["UF_NAME"].'</div></li>';
				?>
			<?endif;?>
			<?}?>
			<?
		}
	?> 
			</ul>
										</div>
										</div>
											<?endif;?>
</div>
<?else:?>
    <?foreach ($arResult['STARTSHOP']['OFFERS'] as $arOffer):?>
        <?
            $sAddToBasketUrl = $APPLICATION->GetCurPageParam(
                urlencode('CatalogBasketAction').'=Add&'.
                urlencode('CatalogBasketItem').'='.urlencode($arOffer['ID']).'&'.
                urlencode('CatalogBasketPrice').'='.urlencode($arOffer['STARTSHOP']['PRICES']['MINIMAL']['TYPE']),
                array('CatalogBasketAction', 'CatalogBasketItem', 'CatalogBasketPrice', 'CatalogBasketQuantity')
            );
        ?>
        <div class="Calc startshop-order StartShopOffersOrder<?=$arOffer['ID']?>" style="display: none;">
								<?if($arOffer['PROPERTIES']["COLOR"]["VALUE"]):?>
										<div class="PropsColor">
											<span class="Name">Доступные цвета</span>
			<ul>
	<?
		CModule::IncludeModule('highloadblock');

		$highblock_id = 1;
		$hl_block = HLBT::getById($highblock_id)->fetch();

		// Получение имени класса
		$entity = HLBT::compileEntity($hl_block);
		$entity_data_class = $entity->getDataClass();
		
		$rs_data = $entity_data_class::getList(array(
		   'select' => array('*'),
		));
		while ($offer = $rs_data->fetch()){
			?>
			<?$i=0;
			foreach($arOffer["PROPERTIES"]["COLOR"]["VALUE"] as $skucolor){?> 
			<?if($offer["UF_XML_ID"]==$skucolor):?>
				<?
				$img_path = CFile::GetPath($offer["UF_FILE"]); //ПОЛУЧАЕМ ПУСТЬ К КАРТИНКЕ
				echo '<li class="Color"><img src="'.$img_path.'" title="'.$offer["UF_NAME"].'" alt="'.$offer["UF_NAME"].'" /><span>'.$offer["UF_NAME"].'</span></li>';
				?>
			<?endif;?>
			<?
			$i++;
			if($i==5)break;
			}?>
			<?
		}
			if(count($arOffer["PROPERTIES"]["COLOR"]["VALUE"])>5):
				echo "<li class=\"AllColor\"><a data-fancybox data-src=\"#ColorSku".$arOffer['ID']."\" href=\"javascript:;\">Все цвета</a></li>";
			endif;
	?> 
	
	
			</ul>
										</div>
<div style="display: none;" id="ColorSku<?=$arOffer['ID']?>">
	<?if($arOffer['PROPERTIES']["COLOR"]["VALUE"]):?>
										<div class="Popup PopupColor">
											<div class="Title">Все доступные цвета</div>
										<div class="PopupBlock">
			<ul>
	<?
		CModule::IncludeModule('highloadblock');

		$highblock_id = 1;
		$hl_block = HLBT::getById($highblock_id)->fetch();

		// Получение имени класса
		$entity = HLBT::compileEntity($hl_block);
		$entity_data_class = $entity->getDataClass();
		
		$rs_data = $entity_data_class::getList(array(
		   'select' => array('*'),
		));
		while ($el = $rs_data->fetch()){
			?>
			<?foreach($arOffer["PROPERTIES"]["COLOR"]["VALUE"] as $color){?> 
			<?if($el["UF_XML_ID"]==$color):?>
				<?
				$img_path = CFile::GetPath($el["UF_FILE"]); //ПОЛУЧАЕМ ПУСТЬ К КАРТИНКЕ
				echo '<li class="Color"><img src="'.$img_path.'" title="'.$el["UF_NAME"].'" alt="'.$el["UF_NAME"].'" /><div class="Name">'.$el["UF_NAME"].'</div></li>';
				?>
			<?endif;?>
			<?}?>
			<?
		}
	?> 
			</ul>
										</div>
										</div>
											<?endif;?>
</div>
			<?endif;?>
		   <?if($arOffer["PROPERTIES"]["STARTSHOP_ORDER"]["VALUE"]):?>
			<div class="AddCart"> 
				<div class="Flex">
					<div class="Button"><a data-fancybox data-src="#OrderProduct" href="javascript:;" class="Btn"><span class="Order"><?=GetMessage('SH_CE_DEFAULT_ORDER')?></span></a></div>
				</div>
			</div>
			<?else:?>
            <?if (!$arOffer['STARTSHOP']['BASKET']['INSIDE']):?>
				<div class="PriceBlock"> 
											<div class="Flex">
												<div class="Price">
													<div class="Name">Цена</div>
													<div class="startshop-price">
														от 
														<span class="startshop-current StartShopOffersPrice" data-price="<?=number_format($arResult['STARTSHOP']['PRICES']['MINIMAL']['PRINT_VALUE'], 0, ',', ' ' )?>"><?=number_format($arResult['STARTSHOP']['PRICES']['MINIMAL']['PRINT_VALUE'], 0, ',', ' ' )?></span> руб. <?if($arResult["PROPERTIES"]["MEASURE"]["VALUE"]):?>/<?=$arResult["PROPERTIES"]["MEASURE"]["~VALUE"]?><?endif?>
													</div>
												</div>
												<div class="Cost">
													<div class="Name">Итого</div>
													<div class="startshop-price">
														от 
														<span id="summ_<?=$arOffer['ID']?>" class="startshop-current StartShopOffersPrice count_price summ" data-price="<?=number_format($arResult['STARTSHOP']['PRICES']['MINIMAL']['PRINT_VALUE'], 0, ',', ' ' )?>"><?=number_format($arResult['STARTSHOP']['PRICES']['MINIMAL']['PRINT_VALUE'], 0, ',', ' ' )?></span> руб. <?if($arResult["PROPERTIES"]["MEASURE"]["VALUE"]):?>/<?=$arResult["PROPERTIES"]["MEASURE"]["~VALUE"]?><?endif?>
													</div>
												</div>
											</div>
										</div>
				<div class="AddCart"> 
					<div class="Flex">
						<div class="startshop-input-numeric">
							<?$arProductCount = array(
								"Value" => floatval($arOffer['STARTSHOP']['QUANTITY']['RATIO']),
								"Minimum" => floatval($arOffer['STARTSHOP']['QUANTITY']['RATIO']),
								"Maximum" => floatval($arOffer['STARTSHOP']['QUANTITY']['VALUE']),
								"Ratio" => floatval($arOffer['STARTSHOP']['QUANTITY']['RATIO']),
								"Unlimited" => !$arOffer['STARTSHOP']['QUANTITY']['USE'],
								"ValueType" => "Float"
							)?>
							<button class="minus" id="remove_one_<?=$arOffer['ID']?>" onclick="<?=$sUnique?>_StartShopOffersProductCount_<?=$arOffer['ID']?>.Decrease();">-</button>
							<input type="text" name="count" class="quantity startshop-input-numeric-text <?=$sUnique?>_StartShopOffersProductCount_<?=$arOffer['ID']?> Count_<?=$arOffer['ID']?>" onchange="<?=$sUnique?>_StartShopOffersProductCount_<?=$arOffer['ID']?>.SetValue($(this).val());" value="<?=floatval($arResult['STARTSHOP']['QUANTITY']['RATIO'])?>" />
							<button class="plus" id="add_one_<?=$arOffer['ID']?>" onclick="<?=$sUnique?>_StartShopOffersProductCount_<?=$arOffer['ID']?>.Increase();">+</button>
							<script type="text/javascript">
								var <?=$sUnique?>_StartShopOffersProductCount_<?=$arOffer['ID']?> = new Startshop.Controls.NumericUpDown(<?=CUtil::PhpToJSObject($arProductCount)?>);
								<?=$sUnique?>_StartShopOffersProductCount_<?=$arOffer['ID']?>.Settings.Events.OnValueChange = function($oNumeric) {
									$('.<?=$sUnique?>_StartShopOffersProductCount_<?=$arOffer['ID']?>').val($oNumeric.GetValue());
								};
							</script>
						</div>
						<div class="startshop-buy">
							<a rel="nofollow" class="startshop-button startshop-button-standart to-cart" id="to_cart_<?=$arElement['ID']?>" onClick="window.location.href = '<?=$sAddToBasketUrl?>&CatalogBasketQuantity=' + <?=$sUnique?>_StartShopOffersProductCount_<?=$arOffer['ID']?>.GetValue()">
								<span onclick="ym(38770565, 'reachGoal', 'Dobavit_tovar_v_korzinu'); return true;"><?=GetMessage("SH_CE_DEFAULT_ADD_TO_BASKET")?></span>
							</a>
						</div>
					</div>
                </div>
            <?else:?>
                <div class="startshop-buy">
                    <a rel="nofollow" href="<?=$arParams["BASKET_URL"];?>" id="in_cart_<?=$arElement['ID']?>" class="startshop-button startshop-button-standart startshop-status-focus to-cart-added">
                        <span><?=GetMessage("SH_CE_DEFAULT_ADDED_TO_BASKET")?></span>
                    </a>
                </div>
            <?endif;?>
			<?endif?>
										<div class="Flex">
											<div class="PropsList">
												<?if($arOffer['PROPERTIES']["TOLSHINA_LISTA"]["VALUE"]):?>
												<p><?=$arOffer['PROPERTIES']["TOLSHINA_LISTA"]["NAME"]?>: <?=$arOffer['PROPERTIES']["TOLSHINA_LISTA"]["VALUE"]?></p>
												<?endif;?>
												<?if($arOffer['PROPERTIES']["POVERHNOST"]["VALUE"]):?>
												<p><?=$arOffer['PROPERTIES']["POVERHNOST"]["NAME"]?>: <?=$arOffer['PROPERTIES']["POVERHNOST"]["VALUE"]?></p>
												<?endif;?>
												<?if($arOffer['PROPERTIES']["TOLHINA_POKRYTIA"]["VALUE"]):?>
												<p><?=$arOffer['PROPERTIES']["TOLHINA_POKRYTIA"]["NAME"]?>: <?=$arOffer['PROPERTIES']["TOLHINA_POKRYTIA"]["VALUE"]?></p>
												<?endif;?>
											</div> 
										</div> 
        </div>
    <?endforeach;?>

<?endif;?>