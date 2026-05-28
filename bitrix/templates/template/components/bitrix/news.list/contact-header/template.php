<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="Phones phones__inner phones__inner--with_dropdown phones__inner--big fill-theme-parent">
<?foreach($arResult["ITEMS"] as $arItem):?>
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>
	<div class="Box" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
		<?$i=0;
			foreach($arItem["PROPERTIES"]["PHONE"]["VALUE"] as $k=>$value){
			$phone=$arItem["PROPERTIES"]["PHONE"]["VALUE"][$k];
			?>
			<a href="tel:<?=preg_replace('/[^0-9\+]/', '', $phone);?>" class="Phone"><?=$arItem["PROPERTIES"]["PHONE"]["VALUE"][$k]?></a>
		<?$i++;
		if($i==1)break;}?>
		<div class="phones__dropdown">
			<div class="dropdown dropdown--relative">
				<div class="Items">
					<?foreach($arItem["PROPERTIES"]["PHONE"]["VALUE"] as $k=>$value){
						$phone=$arItem["PROPERTIES"]["PHONE"]["VALUE"][$k];
						?>
						<div class="phones__phone-more dropdown__item color-theme-hover">
							<div class="Item_Inner">
								<a href="tel:<?=preg_replace('/[^0-9\+]/', '', $phone);?>"><?=$arItem["PROPERTIES"]["PHONE"]["VALUE"][$k]?></a>
								<span><?=$arItem["PROPERTIES"]["PHONE"]["DESCRIPTION"][$k]?></span>
							</div>
						</div>
					<?}?>
				</div>
				<div class="Contact">
					<?if($arItem['PROPERTIES']['ADRESS']['VALUE']):?>
					<div class="Adress">
						<span>Наши филиалы</span>
						<?foreach($arItem["PROPERTIES"]["ADRESS"]["VALUE"] as $k=>$value){
						?>
						<p><?=$arItem["PROPERTIES"]["ADRESS"]["VALUE"][$k]?></p>
						<?}?>
					</div>
					<?endif;?>
					<div class="Mail">
						<span>E-mail</span>
						<?if($arItem['PROPERTIES']['MAIL']['VALUE']):?>
						<a href="mailto:<?echo $arItem['PROPERTIES']['MAIL']['NAME'];?>"><?echo $arItem['PROPERTIES']['MAIL']['VALUE'];?></a>
						<?endif;?>
					</div>
				</div>
				<div class="Social">
					<?$APPLICATION->IncludeComponent(
									"bitrix:menu", 
									"social", 
									array(
										"ROOT_MENU_TYPE" => "social",
										"MAX_LEVEL" => "1",
										"CHILD_MENU_TYPE" => "",
										"USE_EXT" => "Y",
										"MENU_CACHE_TYPE" => "A",
										"MENU_CACHE_TIME" => "86400",
										"MENU_CACHE_USE_GROUPS" => "N",
										"MENU_CACHE_GET_VARS" => array(
										),
										"COMPONENT_TEMPLATE" => "social",
										"DELAY" => "N",
										"ALLOW_MULTI_SELECT" => "N"
									),
					   $component, // Добавляем
					   array("HIDE_ICONS" => "Y") // Добавляем
					);?>
				</div>
			</div>
		</div>
		<?if($arItem['PROPERTIES']['GRAFIK']['VALUE']):?>
		<div class="Grafik"><?echo $arItem['PROPERTIES']['GRAFIK']['VALUE'];?></div>
		<?endif;?>
	</div>
<?endforeach;?>
</div>