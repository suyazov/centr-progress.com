<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="Reviews">
	<div class="Wrapper">
		<div class="Title">
			 Что клиенты говорят о нас
		</div>
		<div class="Items">
			<div id="Reviews" class="owl-carousel">
			<?foreach($arResult["ITEMS"] as $arItem):?>
			<?
			$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
			$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
			?>
			<div id="<?=$this->GetEditAreaId($arItem['ID']);?>" class="Item">
				<?if($arItem["PREVIEW_TEXT"]):?>
				<div class="Text"><?=$arItem["PREVIEW_TEXT"]?></div>
				<?endif;?>
				<?if($arItem["PROPERTIES"]["AUTHOR"]["VALUE"]):?><div class="Author"><?=$arItem["PROPERTIES"]["AUTHOR"]["VALUE"]?></div><?endif;?>
				<?if($arItem["PROPERTIES"]["FILE"]["VALUE"]):?>
				<div class="File"><a href="<?=CFile::GetPath($arItem["PROPERTIES"]["FILE"]["VALUE"])?>" target="_blank"><?=$arItem["PROPERTIES"]["FILE"]["DESCRIPTION"]?></a></div>
				<?endif;?>
			</div>
			<?endforeach;?>
			</div>
		</div>
	</div>
</div>