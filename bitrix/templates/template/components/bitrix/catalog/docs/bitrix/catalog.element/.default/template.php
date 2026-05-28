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
}

function human_plural_form($number, $titles)
{
    $cases = array (2, 0, 1, 1, 1, 2);
    return $number." ".$titles[ ($number%100 >4 && $number%100< 20)? 2 : $cases[min($number%10, 5)] ];
}
?>
<div class="InfoDetail">
	<?if($arResult["ACTIVE_FROM"]):?>
		<div class="Date">
			<?$arDATE = ParseDateTime($arResult["ACTIVE_FROM"], FORMAT_DATETIME);
			echo "Опубликовано: ".$arDATE["DD"]." ".ToLower(GetMessage("MONTH_".intval($arDATE["MM"])."_S"))." ".$arDATE["YYYY"];
			?>
		</div> 
	<?endif?>
	<?if($arResult["DETAIL_TEXT"]):?>
		<?echo $arResult["DETAIL_TEXT"];?>
	<?else:?>
		<?echo $arResult["PREVIEW_TEXT"];?>
	<?endif?>
	<?if($arResult["DISPLAY_PROPERTIES"]["FILE"]["VALUE"]):?>
	<div class="DocBlock">
		<?if($arResult["DETAIL_TEXT"]):?>
		<div class="TitleDoc">Прикрепленные документы</div>
		<?endif?>
	<?if($arResult["DISPLAY_PROPERTIES"]["FILE"]["VALUE"]):?>
		<div class="FilesList">
			<?if(is_array($arResult["DISPLAY_PROPERTIES"]['FILE']["DISPLAY_VALUE"])):
			foreach($arResult["DISPLAY_PROPERTIES"]['FILE']["DISPLAY_VALUE"] as $key=>$value):				
			$ext=substr($arResult["DISPLAY_PROPERTIES"]['FILE']['FILE_VALUE'][$key]['SRC'], strrpos($arResult["DISPLAY_PROPERTIES"]['FILE']['FILE_VALUE'][$key]['SRC'], '.') + 1);?>
			<div class="Item">
				<table>	
					<tr>
						<td class="NameTD">
							<div class="Name">
								<a href="<?=$arResult["DISPLAY_PROPERTIES"]['FILE']['FILE_VALUE'][$key]['SRC']?>"><?if($arResult["DISPLAY_PROPERTIES"]['FILE']['FILE_VALUE'][$key]['DESCRIPTION']):?>
								<?=$arResult["DISPLAY_PROPERTIES"]['FILE']['FILE_VALUE'][$key]['DESCRIPTION']?><?else:?><?=$arResult["NAME"]?><?endif?></a>
							</div>
							<div class="Format"><span>.<?=$ext?>,</span> <?=formatFileSize($arResult["DISPLAY_PROPERTIES"]['FILE']['FILE_VALUE'][$key]['FILE_SIZE'])?></div>
						</td>
					</tr>
				</table>	
			</div>
			<?endforeach;
				elseif($arResult["DISPLAY_PROPERTIES"]['FILE']['FILE_VALUE']['SRC']):
				$ext=substr($arResult["DISPLAY_PROPERTIES"]['FILE']['FILE_VALUE']['SRC'], strrpos($arResult["DISPLAY_PROPERTIES"]['FILE']['FILE_VALUE']['SRC'], '.') + 1);?>
			<div class="Item">
				<table>	
					<tr>
						<td class="NameTD">
							<div class="Name">
								<a href="<?=$arResult["DISPLAY_PROPERTIES"]['FILE']['FILE_VALUE']['SRC']?>"><?if($arResult["DISPLAY_PROPERTIES"]['FILE']['FILE_VALUE']['DESCRIPTION']):?><?=$arResult["DISPLAY_PROPERTIES"]['FILE']['FILE_VALUE']['DESCRIPTION']?>
								<?else:?><?=$arResult["NAME"]?><?endif?></a>
							</div>
							<div class="Format"><span>.<?=$ext?>,</span> <?=formatFileSize($arResult["DISPLAY_PROPERTIES"]['FILE']['FILE_VALUE']['FILE_SIZE'])?></div>
						</td>
					</tr>
				</table>
			</div>
				<?endif;?>						
			<?endif?>
		</div>
	</div>
	<?endif?>
	<?if(is_array($arResult["SECTION"])):?>
		<div class="BackLink"><a href="<?=$arResult["SECTION"]["SECTION_PAGE_URL"]?>"><?=GetMessage("CATALOG_BACK")?></a></div>
	<?endif?>
</div>
