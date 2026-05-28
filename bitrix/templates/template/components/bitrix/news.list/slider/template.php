<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use Bas\Pict;
?>
<div class="Slider">
	<div id="owl-demo" class="owl-carousel">
	<?
	$item=0;
	foreach($arResult["ITEMS"] as $arItem):?>
		<?
		$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
		$PICTURE = CFile::ResizeImageGet($arItem["PREVIEW_PICTURE"], Array('width'=>2560, 'height'=>696), BX_RESIZE_IMAGE_EXACT, true);
		?>
		<div class="Item<?if($arItem['PROPERTIES']['BG']['VALUE']=="Да"):?> BG<?endif;?>" style="background-image:url(<?=Pict::getResizeWebpSrc($arItem['PREVIEW_PICTURE'], 2560, 696)?>);" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
			<div class="DescBlock">
				<div class="Desc">
					<div class="Title"><?=$arItem["NAME"]?></div>
					<div class="Anonse"><?=$arItem["PREVIEW_TEXT"]?></div>
					<?if($arItem['PROPERTIES']['CHECK']['VALUE']=="Да"):?>
					<?if($arItem['PROPERTIES']['LINK']['VALUE']):?>
					<a href="<?echo $arItem['PROPERTIES']['LINK']['VALUE'];?>" class="Btn"><span><?echo $arItem['PROPERTIES']['TEXT_LINK']['VALUE'];?></span></a>
					<?endif;?>
					<?endif;?>
				</div>
			</div>
		</div>
	<?endforeach;?>
	</div>
</div>