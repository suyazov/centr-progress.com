<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if($arResult["ITEMS"]):?>
<div class="Affiliates">
	<h2>Филиалы</h2> 
	<div class="Items">
	<?foreach($arResult["ITEMS"] as $arItem):?>
		<?
		$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
		?>
		<div class="Item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
			<div class="Name"><?echo $arItem["NAME"]?></div>
			<div class="Adress">
				<?if($arItem["PREVIEW_TEXT"]):?>
				<?echo $arItem["PREVIEW_TEXT"]?>
				<?endif?>
			</div>
		</div>
	<?endforeach;?>
	</div>
</div>
<?endif?>