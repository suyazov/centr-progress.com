<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
function formatFileSize($bytes) 
{
            if (!is_numeric($bytes) || !$bytes) {
                return '';
            }
            if ($bytes >= 1000000000) {
                return round($bytes / 1000000000,2).' '.GetMessage("GB");
            }
            if ($bytes >= 1000000) {
                return round($bytes / 1000000,2).' '.GetMessage("MB");
            }
            return round($bytes / 1000,2). ' '.GetMessage("KB");
};?>
<div class="FilesList">
	<?foreach($arResult["ITEMS"] as $cell=>$arElement):?>
		<?
		$this->AddEditAction($arElement['ID'], $arElement['EDIT_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($arElement['ID'], $arElement['DELETE_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BCS_ELEMENT_DELETE_CONFIRM')));
		?>
		<div class="Item" id="<?=$this->GetEditAreaId($arElement['ID']);?>">
			<?if($arElement["DETAIL_TEXT"]):?>
				<div class="Name"><a href="<?=$arElement["DETAIL_PAGE_URL"]?>"><?=$arElement["NAME"]?></a></div>
				<?if($arElement["PREVIEW_TEXT"]):?>
				<div class="Anonse"><?echo $arElement["PREVIEW_TEXT"];?></div>
				<?endif?>
				<?if($arElement["DISPLAY_PROPERTIES"]["DATE"]["VALUE"]):?>
				<div class="PublicDate"><?=$arElement["DISPLAY_PROPERTIES"]["DATE"]["NAME"]?>: <?=$arElement["DISPLAY_PROPERTIES"]["DATE"]["VALUE"]?></div>
				<?endif?>
			<?elseif(count($arElement["DISPLAY_PROPERTIES"]["FILE"]["VALUE"])==0):?>
				<div class="Name"><?=$arElement["NAME"]?></div>
				<?if($arElement["PREVIEW_TEXT"]):?>
				<div class="Anonse"><?echo $arElement["PREVIEW_TEXT"];?></div>
				<?endif?>
				<?if($arElement["DISPLAY_PROPERTIES"]["LINK"]["VALUE"]):?>
				<div class="Link"><a href="<?=$arElement["DISPLAY_PROPERTIES"]["LINK"]["VALUE"]?>" target="_blank">Подробнее</a></div>
				<?endif?>
				<?if($arElement["DISPLAY_PROPERTIES"]["DATE"]["VALUE"]):?>
				<div class="PublicDate"><?=$arElement["DISPLAY_PROPERTIES"]["DATE"]["NAME"]?>: <?=$arElement["DISPLAY_PROPERTIES"]["DATE"]["VALUE"]?></div>
				<?endif?>
			<?elseif(count($arElement["DISPLAY_PROPERTIES"]["FILE"]["VALUE"])==1):?>
			<div class="DocList">
				<table>	
					<tr>
						<?if($arElement["DISPLAY_PROPERTIES"]['FILE']['FILE_VALUE']['SRC']):
							$ext=substr($arElement["DISPLAY_PROPERTIES"]['FILE']['FILE_VALUE']['SRC'], strrpos($arElement["DISPLAY_PROPERTIES"]['FILE']['FILE_VALUE']['SRC'], '.') + 1);?>
							<td class="IconTD"><span class="<?=$ext?>"></span></td>
							<td class="NameTD">
								<div class="Name">
									<a href="<?=$arElement["DISPLAY_PROPERTIES"]['FILE']['FILE_VALUE']['SRC']?>"><?=$arElement["NAME"]?></a>
								</div>
								<?if($arElement["DISPLAY_PROPERTIES"]['FILE']['FILE_VALUE']['DESCRIPTION']):?>
									<?=$arElement["DISPLAY_PROPERTIES"]['FILE']['FILE_VALUE']['DESCRIPTION']?>
								<?endif?>
								<?if($arElement["PREVIEW_TEXT"]):?>
								<div class="Anonse"><?echo $arElement["PREVIEW_TEXT"];?></div>
								<?endif?>
								<?if($arElement["DISPLAY_PROPERTIES"]["DATE"]["VALUE"]):?>
								<div class="PublicDate"><?=$arElement["DISPLAY_PROPERTIES"]["DATE"]["NAME"]?>: <?=$arElement["DISPLAY_PROPERTIES"]["DATE"]["VALUE"]?></div>
								<?endif?>
								<div class="Format"><?=formatFileSize($arElement["DISPLAY_PROPERTIES"]['FILE']['FILE_VALUE']['FILE_SIZE'])?></div>
							</td>
						<?endif;?>	
					</tr>
				</table>
			</div>
			<?elseif(count($arElement["DISPLAY_PROPERTIES"]["FILE"]["VALUE"])>=2):?>
			<div class="Name"><a href="<?=$arElement["DETAIL_PAGE_URL"]?>"><?=$arElement["NAME"]?></a></div>
			<?if($arElement["PREVIEW_TEXT"]):?>
				<div class="Anonse"><?echo $arElement["PREVIEW_TEXT"];?></div>
			<?endif?>
			<?if($arElement["DISPLAY_PROPERTIES"]["DATE"]["VALUE"]):?>
			<div class="PublicDate"><?=$arElement["DISPLAY_PROPERTIES"]["DATE"]["NAME"]?>: <?=$arElement["DISPLAY_PROPERTIES"]["DATE"]["VALUE"]?></div>
			<?endif?>
			<?endif?>
		</div>
	<?endforeach; // foreach($arResult["ITEMS"] as $arElement):?>
</div>
<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
	<?=$arResult["NAV_STRING"]?>
<?endif;?>