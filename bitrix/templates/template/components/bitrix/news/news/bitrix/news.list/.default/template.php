<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use Bas\Pict;?>
<div class="NewsCont">
	<div class="Items">
<?
foreach($arResult["ITEMS"] as $arItem):?>
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>
	<div class="Item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
		<div class="Item_Inner">
		<?if($arParams["DISPLAY_PICTURE"]!="N" && is_array($arItem["PREVIEW_PICTURE"])):
			$PICTURE = CFile::ResizeImageGet($arItem["PREVIEW_PICTURE"], Array('width'=>630, 'height'=>420), BX_RESIZE_IMAGE_EXACT, true);
		?>
			<div class="Image">
				<?if(!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])):?>
				<a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><img src="<?=Pict::getResizeWebpSrc($arItem['PREVIEW_PICTURE'], 630, 420)?>" width="630px" height="420px"  alt="<?=$arItem["NAME"]?>" title="<?=$arItem["NAME"]?>" /></a>
				<?else:?>
				<img src="<?=Pict::getResizeWebpSrc($arItem['PREVIEW_PICTURE'], 630, 420)?>" alt="<?=$arItem["NAME"]?>" title="<?=$arItem["NAME"]?>" />
				<?endif;?>
				<?if($arItem["PROPERTIES"]["TYPE"]["VALUE"]=="Статья"):?><span>Статья</span><?elseif($arItem["PROPERTIES"]["TYPE"]["VALUE"]=="Новость"):?><span class="News">Новость</span><?endif;?>
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
		</div>
	</div>
<?
endforeach;?>
	</div>
</div>
<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
	<?=$arResult["NAV_STRING"]?>
<?endif;?>