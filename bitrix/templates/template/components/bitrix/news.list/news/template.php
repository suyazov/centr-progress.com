<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use Bas\Pict;?>
<?if($arResult["ITEMS"]):?>
<?foreach($arResult["ITEMS"] as $arItem):?>
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>
	<div class="Item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
		<?if($arParams["DISPLAY_PICTURE"]!="N" && is_array($arItem["PREVIEW_PICTURE"])):
			$PICTURE = CFile::ResizeImageGet($arItem["PREVIEW_PICTURE"], Array('width'=>464, 'height'=>310), BX_RESIZE_IMAGE_EXACT, true);
		?>
		<div class="Image">
			<a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><img src="<?=Pict::getResizeWebpSrc($arItem['PREVIEW_PICTURE'], 464, 310)?>" width="464" height="310" title="<?=$arItem["NAME"]?>" alt="<?=$arItem["NAME"]?>"></a>
		</div>
		<?endif?>
		<?if($arParams["DISPLAY_DATE"]!="N" && $arItem["DISPLAY_ACTIVE_FROM"]):?>
		<div class="Date">
			<?
			   $arDATE = ParseDateTime($arItem["DISPLAY_ACTIVE_FROM"], FORMAT_DATETIME);
			   echo "<span>".$arDATE["DD"]." ".ToLower(GetMessage("MONTH_".intval($arDATE["MM"])."_S"))."</span>";
			?>
		</div> 
		<?endif?>
		<div class="Name"><a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><?=$arItem["NAME"]?></a></div>
		<?if($arItem["PREVIEW_TEXT"]):?>
		<div class="Anonse"><?echo $arItem["PREVIEW_TEXT"]?></div>
		<?endif?>
	</div>
<?endforeach;?>
<?endif?>