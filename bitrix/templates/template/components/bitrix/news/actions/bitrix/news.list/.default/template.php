<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if($arResult["ITEMS"]):?>
<div class="ActionList">
<?foreach($arResult["ITEMS"] as $arItem):?>
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>
	<div class="Item<?if($arItem["PREVIEW_PICTURE"]):?> Image<?endif;?>" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
		<?if($arParams["DISPLAY_PICTURE"]!="N" && is_array($arItem["PREVIEW_PICTURE"])):
			$PICTURE = CFile::ResizeImageGet($arItem["PREVIEW_PICTURE"], Array('width'=>250, 'height'=>150), BX_RESIZE_IMAGE_EXACT, true);
		?>
		<div class="Image">
			<div class="Stiker"><span class="Sale">Акция</span></div>
			<?if(!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])):?>
			<a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><img src="<?=$PICTURE["src"]?>" alt="<?=$arItem["NAME"]?>" title="<?=$arItem["NAME"]?>" /></a>
			<?else:?>
			<img src="<?=$PICTURE["src"]?>" alt="<?=$arItem["NAME"]?>" title="<?=$arItem["NAME"]?>" />
			<?endif;?>
		</div>
		<?endif?>
		<div class="Desc<?if($arItem["PREVIEW_PICTURE"]):?> Img<?endif;?>">
		<?if($arParams["DISPLAY_NAME"]!="N" && $arItem["NAME"]):?>
		<?if(!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])):?>
		<div class="Name"><a href="<?echo $arItem["DETAIL_PAGE_URL"]?>"><?echo $arItem["NAME"]?></a></div>
			<?else:?>
			<?if($arItem["DISPLAY_PROPERTIES"]["FILE"]["VALUE"]):?>
				<div class="Name"><a href="<?echo $arItem["DETAIL_PAGE_URL"]?>"><?echo $arItem["NAME"]?></a></div>
			<?else:?>
				<div class="Name"><?echo $arItem["NAME"]?></div>
			<?endif;?>
		<?endif;?>
		<?endif;?>
		<?if($arParams["DISPLAY_DATE"]!="N" && $arItem["DISPLAY_ACTIVE_FROM"]):?>
		<div class="Date"> 
			Срок действия: с <?=$arItem["DISPLAY_ACTIVE_FROM"]?> по <?=$arItem["DATE_ACTIVE_TO"]?>
		</div> 
		<?endif?>
		<?if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arItem["PREVIEW_TEXT"]):?>
		<div class="Anonse"><?echo $arItem["PREVIEW_TEXT"];?></div>
		<?endif;?>
		<?if($arItem["DISPLAY_PROPERTIES"]["LINK"]["VALUE"]):?>
		<div class="Link"><a href="<?=$arItem["DISPLAY_PROPERTIES"]["LINK"]["VALUE"]?>">Подробнее</a></div>
		<?endif?>
		</div>
	</div>
<?
endforeach;?>
</div>
<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
	<?=$arResult["NAV_STRING"]?>
<?endif;?>
<?else:?>
В данный момент акции временно отсутствуют.
<?endif;?>