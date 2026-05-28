<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="Staff">
<?if($arResult["ITEMS"]):?>
	<div class="Items">
	<?foreach($arResult["ITEMS"] as $cell=>$arElement):?>
		<?
			$this->AddEditAction($arElement['ID'], $arElement['EDIT_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT"));
			$this->AddDeleteAction($arElement['ID'], $arElement['DELETE_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BCST_ELEMENT_DELETE_CONFIRM')));
		?>
		<div class="Item" id="<?=$this->GetEditAreaId($arElement['ID']);?>">
			<div class="Item_Inner">
				<?if(is_array($arElement["PREVIEW_PICTURE"])):
					$PICTURE = CFile::ResizeImageGet($arElement["PREVIEW_PICTURE"], Array('width'=>240, 'height'=>285), BX_RESIZE_IMAGE_EXACT, true);
				?>
				<div class="Image"><span><img src="<?=$PICTURE["src"]?>" alt="<?=$arElement["NAME"]?>" title="<?=$arElement["NAME"]?>" /></span></div>
				<?else:?>
				<div class="Image"><span><img src="/files/no-photo.png" alt="<?=$arElement["NAME"]?>" title="<?=$arElement["NAME"]?>" /></span></div><?endif?>
				<div class="Name"><?=$arElement["NAME"]?></div>
				<?if($arElement["DISPLAY_PROPERTIES"]["PROP1"]["VALUE"]):?>
				<div class="Post"><?=$arElement["DISPLAY_PROPERTIES"]["PROP1"]["VALUE"]?></div>
				<?endif?>
				<?if($arElement["DISPLAY_PROPERTIES"]["PROP3"]["VALUE"]):?>
				<div class="Prop"><?=$arElement["DISPLAY_PROPERTIES"]["PROP3"]["NAME"]?>: <?=$arElement["DISPLAY_PROPERTIES"]["PROP3"]["VALUE"]?></div>
				<?endif?>
			</div>
		</div>
	<?endforeach;?>
	</div>
<?endif;?>
</div>
<script type="text/javascript">
$(document).ready(function(){
$(".Name a").html(function () {
    var text = $(this).text().trim().split(" ");
    var first = text.shift();
    return (text.length >= 0 ? "<span>" + first + "</span> " : first) + text.join(" ");
});
});
</script>
