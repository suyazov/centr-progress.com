<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="Benefits">
	<div class="Wrapper">
		<?if ($GLOBALS["APPLICATION"]->GetCurPage() == "/"):?>
			<h1 class="Title">Учебный центр<br> дополнительного профессионального образования<br> «Прогресс»</h1>
		<?else:?>
			<h2 class="Title">Учебный центр<br> дополнительного профессионального образования<br> «Прогресс»</h2>
		<?endif;?>
		<div class="Items">
		<?foreach($arResult["ITEMS"] as $arItem):?>
			<?
			$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
			$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
			?>
			<div id="<?=$this->GetEditAreaId($arItem['ID']);?>" class="Item">
				<?if($arItem["PREVIEW_TEXT"]):?>
				<div class="Item_Inner">
				<?=$arItem["PREVIEW_TEXT"]?>
				</div>
				<?endif;?>
			</div>
		<?endforeach;?>
		</div>
	</div>
</div>