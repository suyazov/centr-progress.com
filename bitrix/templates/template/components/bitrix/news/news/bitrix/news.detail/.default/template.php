<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use Bas\Pict;
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
?>
<div class="NewsDetail" itemscope=""itemtype="http://schema.org/Article">
	<span itemprop="name" class="Hidden"><?echo $arResult["NAME"];?></span>
	<?if($arParams["DISPLAY_DATE"]!="N" && $arResult["DISPLAY_ACTIVE_FROM"]):?>
	<div class="Date">
	<?
	   $arDATE = ParseDateTime($arResult["DISPLAY_ACTIVE_FROM"], FORMAT_DATETIME);
	   echo "<span>".$arDATE["DD"]." ".ToLower(GetMessage("MONTH_".intval($arDATE["MM"])."_S"))." ".$arDATE["YYYY"]."</span>";
	?>
	</div>
	<?endif;?>
	
	<?if(count($arResult["PHOTO"])>0):?>
	<div class="PhotoBlock">
		<div id="Gallery" class="owl-carousel">
			<?if($arResult["PREVIEW_PICTURE"]):
				$PICTURE = CFile::ResizeImageGet($arResult["PREVIEW_PICTURE"], Array('width'=>960, 'height'=>674), BX_RESIZE_IMAGE_EXACT, true);
			?>
			<div class="Item">
				<img src="<?=Pict::getResizeWebpSrc($arResult['PREVIEW_PICTURE'], 960, 674)?>" width="960px" height="674px"  alt="<?=$arResult["NAME"]?>" title="<?=$arResult["NAME"]?>" />
			</div>
			<?endif?>
			<?foreach($arResult["PHOTO"] as $PHOTO){
				$PICTURE_SMALL = CFile::ResizeImageGet($PHOTO["ID"], Array('width'=>960, 'height'=>674), BX_RESIZE_IMAGE_EXACT, true);
			?>
			<div class="Item">
				<img src="<?=Pict::getResizeWebpSrc($PHOTO['ID'], 960, 674)?>" width="960px" height="674px" alt="<?=$arResult["NAME"]?>" title="<?=$arResult["NAME"]?>" />
			</div> 
			<?}?>
		</div>
	</div>
	<?else:?>
		<?if($arResult["DETAIL_PICTURE"]):?>
			<div class="PhotoBlock">
			<?
			$PICTURE = CFile::ResizeImageGet($arResult["DETAIL_PICTURE"], Array('width'=>1000, 'height'=>500), BX_RESIZE_IMAGE_EXACT, true);
			$PICTUR_BIG = CFile::ResizeImageGet($arResult["DETAIL_PICTURE"], Array('width'=>1000, 'height'=>1000), BX_RESIZE_IMAGE_PROPORTIONAL, true);
			?>
				<div class="ImageBlock">
					<img src="<?=Pict::getResizeWebpSrc($arResult['DETAIL_PICTURE'], 1000, 500)?>" width="1000px" height="500px" alt="<?=$arResult["NAME"]?>" title="<?=$arResult["NAME"]?>" />
					<?if($arResult["PROPERTIES"]["TYPE"]["VALUE"]=="Статья"):?><span>Статья</span><?elseif($arResult["PROPERTIES"]["TYPE"]["VALUE"]=="Новость"):?><span class="News">Новость</span><?endif;?>
				</div>
			</div>
			<?elseif($arResult["PREVIEW_PICTURE"]):?>
			<div class="PhotoBlock">
			<?
			$PICT = CFile::ResizeImageGet($arResult["PREVIEW_PICTURE"], Array('width'=>1000, 'height'=>500), BX_RESIZE_IMAGE_EXACT, true);
			$PICT_BIG = CFile::ResizeImageGet($arResult["PREVIEW_PICTURE"], Array('width'=>1000, 'height'=>1000), BX_RESIZE_IMAGE_PROPORTIONAL, true);
			?>
				<div class="ImageBlock">
					<img src="<?=Pict::getResizeWebpSrc($arResult['PREVIEW_PICTURE'], 1000, 500)?>" width="1000px" height="500px" alt="<?=$arResult["NAME"]?>" title="<?=$arResult["NAME"]?>" />
					<?if($arResult["PROPERTIES"]["TYPE"]["VALUE"]=="Статья"):?><span>Статья</span><?elseif($arResult["PROPERTIES"]["TYPE"]["VALUE"]=="Новость"):?><span class="News">Новость</span><?endif;?>
				</div>
			</div>
		<?endif;?>
	<?endif;?>
	<?if($arResult["DETAIL_TEXT"]):?>
	<div class="DetailText" itemprop="articleBody"><?echo $arResult["DETAIL_TEXT"];?></div>
	<?endif?>	
	<?
	$arProperty == "FILE";
	foreach($arResult["DISPLAY_PROPERTIES"] as $pid=>$arProperty):?>
	<?if($arResult["DISPLAY_PROPERTIES"]["FILE"]["VALUE"]):?>
	<div class="DocBlock">
		<div class="TitleDoc">Прикрепленные документы</div>
		<div class="FilesList">
			<?if(is_array($arResult["DISPLAY_PROPERTIES"]['FILE']["DISPLAY_VALUE"])):
			foreach($arResult["DISPLAY_PROPERTIES"]['FILE']["DISPLAY_VALUE"] as $key=>$value):				
			$ext=substr($arResult["DISPLAY_PROPERTIES"]['FILE']['FILE_VALUE'][$key]['SRC'], strrpos($arResult["DISPLAY_PROPERTIES"]['FILE']['FILE_VALUE'][$key]['SRC'], '.') + 1);?>
			<div class="Item">
				<table>	
					<tr>
						<td class="IconTD"><span class="<?=$ext?>"></span></td>
							<td class="NameTD">
								<div class="Name">
								<a href="<?=$arResult["DISPLAY_PROPERTIES"]['FILE']['FILE_VALUE'][$key]['SRC']?>"><?=$arResult["DISPLAY_PROPERTIES"]['FILE']['FILE_VALUE'][$key]['DESCRIPTION']?></a>
								</div>
								<div class="Format"><?=formatFileSize($arResult["DISPLAY_PROPERTIES"]['FILE']['FILE_VALUE'][$key]['FILE_SIZE'])?></div>
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
						<td class="IconTD"><span class="<?=$ext?>"></span></td>
							<td class="NameTD">
								<div class="Name">
								<a href="<?=$arResult["DISPLAY_PROPERTIES"]['FILE']['FILE_VALUE']['SRC']?>"><?=$arResult["DISPLAY_PROPERTIES"]['FILE']['FILE_VALUE']['DESCRIPTION']?></a>
								</div>
								<div class="Format"><?=formatFileSize($arResult["DISPLAY_PROPERTIES"]['FILE']['FILE_VALUE']['FILE_SIZE'])?></div>
							</td>
					</tr>
				</table>
			</div>
			<?endif;?>	
		</div>
	</div>					
	<?endif?>
	<?endforeach;?>
</div>