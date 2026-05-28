<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use Bas\Pict;
?>
<div class="StaffDetail"> 
	<?if(is_array($arResult["PREVIEW_PICTURE"])):
		$PICTURE = CFile::ResizeImageGet($arResult["PREVIEW_PICTURE"], Array('width'=>240, 'height'=>285), BX_RESIZE_IMAGE_EXACT, true);
	?>
	<div class="Image"><img src="<?=Pict::getResizeWebpSrc($arItem['PREVIEW_PICTURE'], 240, 285)?>" width="240px" height="85px" alt="<?=$arResult["NAME"]?>" title="<?=$arResult["NAME"]?>" /></div>
	<?else:?>
	<div class="Image"><img src="/files/no-photo.png" alt="<?=$arResult["NAME"]?>" title="<?=$arResult["NAME"]?>" /></div><?endif?>
	<?if($arResult["DISPLAY_PROPERTIES"]):?>
	<div class="Props">
		<?if($arResult["DISPLAY_PROPERTIES"]["PROP1"]["VALUE"]):?>
		<div class="Post"><?=$arResult["DISPLAY_PROPERTIES"]["PROP1"]["NAME"]?>: <?=$arResult["DISPLAY_PROPERTIES"]["PROP1"]["VALUE"]?></div>
		<?endif?>
		<?if($arResult["DISPLAY_PROPERTIES"]["PROP3"]["VALUE"]):?>
		<div class="Prop"><?=$arResult["DISPLAY_PROPERTIES"]["PROP3"]["NAME"]?>: <?=$arResult["DISPLAY_PROPERTIES"]["PROP3"]["VALUE"]?></div>
		<?endif?>
	</div>
	<?endif?>
	<hr />
	<?if($arResult["PREVIEW_TEXT"]):?>
	<div class="Desc">
		<?=$arResult["PREVIEW_TEXT"]?>
	</div>
	<?endif;?>
<div class="Clear"></div>
</div>