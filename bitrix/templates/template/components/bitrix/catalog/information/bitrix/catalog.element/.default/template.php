<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>
<div class="InfoDetail">
	<?if($arResult["ACTIVE_FROM"]):?>
		<div class="Date">
			<?$arDATE = ParseDateTime($arResult["ACTIVE_FROM"], FORMAT_DATETIME);
			echo "Опубликовано: ".$arDATE["DD"]." ".ToLower(GetMessage("MONTH_".intval($arDATE["MM"])."_S"))." ".$arDATE["YYYY"];
			?>
		</div> 
	<?endif?>
	<?if($arResult["PREVIEW_PICTURE"]):?>
	<div class="PhotoBlock">
	<?if(count($arResult["PHOTO"])>0):?>
		<div id="PhotoBlock">
             <div id="PhotoNews" class="owl-carousel owl-theme">
				<?if($arResult["PREVIEW_PICTURE"]):
					$DETAIL_PICTURE = CFile::ResizeImageGet($arResult["PREVIEW_PICTURE"], Array('width'=>1040, 'height'=>600), BX_RESIZE_IMAGE_EXACT, true);
				?>
				<div class="item">
					<img src="<?=$DETAIL_PICTURE["src"]?>" alt="<?=$arResult["NAME"]?>" title="<?=$arResult["NAME"]?>" />
				</div>
				<?endif?>
				<?$i=0;
									$detphoto=Array();
									foreach($arResult["PHOTO"] as $PHOTO){
										$i++;
										$PICTURE_SMALL = CFile::ResizeImageGet($PHOTO["ID"], Array('width'=>1040, 'height'=>600), BX_RESIZE_IMAGE_EXACT, true);
									?>
									<div class="item">
										<img src="<?=$PICTURE_SMALL["src"]?>" alt="<?=$arResult["NAME"]?>" title="<?=$arResult["NAME"]?>" />
									</div>
								<?}?>
             </div>
		</div>
	<?else:?>
		<?if($arResult["PREVIEW_PICTURE"]):
			$PICTURE = CFile::ResizeImageGet($arResult["PREVIEW_PICTURE"], Array('width'=>1040, 'height'=>600), BX_RESIZE_IMAGE_EXACT, true);
		?>
		<div class="ImageBlock">
			<img src="<?=$PICTURE["src"]?>" alt="<?=$arResult["NAME"]?>" title="<?=$arResult["NAME"]?>" />
		</div>
		<?endif?>
	<?endif;?>
	</div>
	<?endif;?>
	<?if($arResult["DETAIL_TEXT"]):?>
	<div class="TableBox">
		<?echo $arResult["DETAIL_TEXT"];?>
	</div>
	<?else:?>
		<?echo $arResult["PREVIEW_TEXT"];?>
	<?endif?>
	<?if($arResult["DISPLAY_PROPERTIES"]["FILE"]["VALUE"]):?>
	<div class="DocBlock">
		<?if($arResult["DETAIL_TEXT"]):?>
		<div class="TitleDoc">Прикрепленные документы</div>
		<?endif?>
	<?if($arResult["DISPLAY_PROPERTIES"]["FILE"]["VALUE"]):?>
		<div class="FilesList DocList">
			<?if(is_array($arResult["DISPLAY_PROPERTIES"]['FILE']["DISPLAY_VALUE"])):
			foreach($arResult["DISPLAY_PROPERTIES"]['FILE']["DISPLAY_VALUE"] as $key=>$value):				
			$ext=substr($arResult["DISPLAY_PROPERTIES"]['FILE']['FILE_VALUE'][$key]['SRC'], strrpos($arResult["DISPLAY_PROPERTIES"]['FILE']['FILE_VALUE'][$key]['SRC'], '.') + 1);?>
			<div class="Item">
				<table>	
					<tr>
						<td class="IconTD"><span class="<?=$ext?>"></span></td>
						<td class="NameTD">
							<div class="Name">
								<a href="<?=$arResult["DISPLAY_PROPERTIES"]['FILE']['FILE_VALUE'][$key]['SRC']?>"><?if($arResult["DISPLAY_PROPERTIES"]['FILE']['FILE_VALUE'][$key]['DESCRIPTION']):?>
								<?=$arResult["DISPLAY_PROPERTIES"]['FILE']['FILE_VALUE'][$key]['DESCRIPTION']?><?else:?><?=$arResult["NAME"]?><?endif?></a>
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
					<tr>
						<td class="IconTD"><span class="<?=$ext?>"></span></td>
						<td class="NameTD">
							<div class="Name">
								<a href="<?=$arResult["DISPLAY_PROPERTIES"]['FILE']['FILE_VALUE']['SRC']?>"><?if($arResult["DISPLAY_PROPERTIES"]['FILE']['FILE_VALUE']['DESCRIPTION']):?><?=$arResult["DISPLAY_PROPERTIES"]['FILE']['FILE_VALUE']['DESCRIPTION']?>
								<?else:?><?=$arResult["NAME"]?><?endif?></a>
							</div>
							<div class="Format"><?=formatFileSize($arResult["DISPLAY_PROPERTIES"]['FILE']['FILE_VALUE']['FILE_SIZE'])?></div>
						</td>
					</tr>
				</table>
			</div>
				<?endif;?>	
		</div>					
			<?endif?>
	</div>
	<?endif?>
	<?if(is_array($arResult["SECTION"])):?>
		<div class="BackLink"><a href="<?=$arResult["SECTION"]["SECTION_PAGE_URL"]?>"><?=GetMessage("CATALOG_BACK")?></a></div>
	<?endif?>
</div>
