<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use Bas\Pict;?>
<div class="AboutBlock">
	<?
	$item=0;
	foreach($arResult["ITEMS"] as $arItem):?>
		<?
		$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
		$PICTURE = CFile::ResizeImageGet($arItem["PREVIEW_PICTURE"], Array('width'=>2560, 'height'=>696), BX_RESIZE_IMAGE_EXACT, true);
		?>
		<div class="Flex" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
			<div class="ImageBlock" style="background-image:url(<?=Pict::getResizeWebpSrc($arItem['PREVIEW_PICTURE'], 2560, 696)?>);" title="<?=$arItem["NAME"]?>"></div>
			<div class="TextBlock">
				<div class="Text">
					<h2 class="Title"><?=$arItem["NAME"]?></h2>
					<?=$arItem["PREVIEW_TEXT"]?>
				</div>
			</div>
		</div>
	<?endforeach;?>
</div>