<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>
<?if($arResult['DESCRIPTION']):?>
<div class="Description">
<?=$arResult["DESCRIPTION"]?>
</div>
<?if($arResult["ITEMS"]):?>
	<hr />
<?endif;?>
<?endif;?>
<div class="FilesList">
	<?foreach($arResult["ITEMS"] as $cell=>$arElement):?>
<?if($arElement["PROPERTIES"]["HIDDEN"]["VALUE"]!="Да"):?>
		<?
		$this->AddEditAction($arElement['ID'], $arElement['EDIT_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($arElement['ID'], $arElement['DELETE_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BCS_ELEMENT_DELETE_CONFIRM')));
		?>
		<div class="Item<?if($arElement["DETAIL_TEXT"]):?> Detail<?endif?>" id="<?=$this->GetEditAreaId($arElement['ID']);?>">
			<?if($arElement["DETAIL_TEXT"]):?>
			<?
			$arFilters = Array(array("name" => "watermark", "position" => "center", "size"=>"real", 'type'=>'image', "file"=>$_SERVER['DOCUMENT_ROOT']."/images/water-mark.png"));
			$PICTURE = CFile::ResizeImageGet($arElement["PREVIEW_PICTURE"], Array('width'=>205, 'height'=>145), BX_RESIZE_IMAGE_EXACT, true);
			?>
			<?if($arElement["PREVIEW_PICTURE"]):?>
			<div class="Image"><a href="<?=$arElement["DETAIL_PAGE_URL"]?>"><img src="<?=$PICTURE["src"]?>" /></a></div>
			<?endif;?> 
			<div class="Desc<?if($arElement["PREVIEW_PICTURE"]):?> Img<?endif;?>">
			<?if(count($arElement["PROPERTIES"]["FILE"]["VALUE"])>=2):?>
				<div class="DocsInfo">
					<div class="Info">
						<div class="IconDoc"><span><?=count($arElement["PROPERTIES"]["FILE"]["VALUE"])?></span></div>
						<div class="Name"><a href="<?=$arElement["DETAIL_PAGE_URL"]?>"><?=$arElement["NAME"]?></a></div>
						<?if($arElement["PROPERTIES"]["DATEPUBLIC"]["VALUE"]!="Да"):?>
						<?if($arElement["ACTIVE_FROM"]):?>
						<div class="PublicDate">
							<?
							   $arDATE = ParseDateTime($arElement["ACTIVE_FROM"], FORMAT_DATETIME);
							  echo $arDATE["DD"]." ".ToLower(GetMessage("MONTH_".intval($arDATE["MM"])."_S"))." ".$arDATE["YYYY"];
							?>
						</div> 
						<?endif?>
						<?endif?>
						<?if($arElement["PREVIEW_TEXT"]):?>
							<div class="Anonse"><?echo $arElement["PREVIEW_TEXT"];?></div>
						<?endif?>
					</div>
				</div> 
				<?else:?>
				<div class="Name"><a href="<?=$arElement["DETAIL_PAGE_URL"]?>"><?=$arElement["NAME"]?></a></div>
				<?if($arElement["PROPERTIES"]["DATEPUBLIC"]["VALUE"]!="Да"):?>
						<?if($arElement["ACTIVE_FROM"]):?>
						<div class="PublicDate">
							<?
							   $arDATE = ParseDateTime($arElement["ACTIVE_FROM"], FORMAT_DATETIME);
							  echo $arDATE["DD"]." ".ToLower(GetMessage("MONTH_".intval($arDATE["MM"])."_S"))." ".$arDATE["YYYY"];
							?>
						</div> 
						<?endif?>
					<?endif?>
				<?if($arElement["PREVIEW_TEXT"]):?>
				<div class="Anonse"><?echo $arElement["PREVIEW_TEXT"];?></div>
				<?endif?>
			<?endif?>
			</div>
			<div class="Clear"></div>
			<?elseif(count($arElement["PROPERTIES"]["FILE"]["VALUE"])==0):?>
				<div class="Name"><?=$arElement["NAME"]?></div>
				<?if($arElement["ACTIVE_FROM"]):?>
				<div class="PublicDate">
					<?
					   $arDATE = ParseDateTime($arElement["ACTIVE_FROM"], FORMAT_DATETIME);
					   echo $arDATE["DD"]." ".ToLower(GetMessage("MONTH_".intval($arDATE["MM"])."_S"))." ".$arDATE["YYYY"];
					?>
				</div> 
				<?endif?>
				<?if($arElement["PREVIEW_TEXT"]):?>
				<div class="Anonse"><?echo $arElement["PREVIEW_TEXT"];?></div>
				<?endif?>
				<?if($arElement["PROPERTIES"]["LINK"]["VALUE"]):?>
				<div class="Link"><a href="<?=$arElement["PROPERTIES"]["LINK"]["VALUE"]?>" target="_blank">Подробнее</a></div>
				<?endif?>
			<?elseif(count($arElement["PROPERTIES"]["FILE"]["VALUE"])==1):?>
			<div class="DocList">
				<table>	
					<tr>
						<?if($arElement["PROPERTIES"]['FILE']['FILE_VALUE']['SRC']):
							$ext=substr($arElement["PROPERTIES"]['FILE']['FILE_VALUE']['SRC'], strrpos($arElement["PROPERTIES"]['FILE']['FILE_VALUE']['SRC'], '.') + 1);?>
							<td class="IconTD"><span class="<?=$ext?>"></span></td>
							<td class="NameTD">
								<div class="Name">
									<?if($arElement["PROPERTIES"]["FILE_LINK"]["VALUE"]):?>
									<a href="<?=$arElement["PROPERTIES"]["FILE_LINK"]["VALUE"]?>"><?=$arElement["NAME"]?></a>
									<?else:?>
									<a href="<?=$arElement["PROPERTIES"]['FILE']['FILE_VALUE']['SRC']?>"><?=$arElement["NAME"]?></a>
									<?endif?>
								</div>
								<?if($arElement["PROPERTIES"]["DATEPUBLIC"]["VALUE"]!="Да"):?>
								<?if($arElement["ACTIVE_FROM"]):?>
								<div class="PublicDate">
									<?
									   $arDATE = ParseDateTime($arElement["ACTIVE_FROM"], FORMAT_DATETIME);
									  echo $arDATE["DD"]." ".ToLower(GetMessage("MONTH_".intval($arDATE["MM"])."_S"))." ".$arDATE["YYYY"];
									?>
								</div> 
								<?endif?>
								<?endif?>
								<?if($arElement["PREVIEW_TEXT"]):?>
								<div class="Anonse"><?echo $arElement["PREVIEW_TEXT"];?></div>
								<?endif?>
								<div class="Format"><span>.<?=$ext?>,</span> <?=formatFileSize($arElement["PROPERTIES"]['FILE']['FILE_VALUE']['FILE_SIZE'])?></div>
							</td>
						<?endif;?>	
					</tr>
				</table>
			</div>
			<?elseif(count($arElement["PROPERTIES"]["FILE"]["VALUE"])>=2):?>
			<div class="DocsInfo">
				<div class="Info">
					<div class="IconDoc"><span><?=count($arElement["PROPERTIES"]["FILE"]["VALUE"])?></span></div>
					<div class="Name"><a href="<?=$arElement["DETAIL_PAGE_URL"]?>"><?=$arElement["NAME"]?></a></div>
					<?if($arElement["PROPERTIES"]["DATEPUBLIC"]["VALUE"]!="Да"):?>
						<?if($arElement["ACTIVE_FROM"]):?>
						<div class="PublicDate">
							<?
							   $arDATE = ParseDateTime($arElement["ACTIVE_FROM"], FORMAT_DATETIME);
							  echo $arDATE["DD"]." ".ToLower(GetMessage("MONTH_".intval($arDATE["MM"])."_S"))." ".$arDATE["YYYY"];
							?>
						</div> 
						<?endif?>
						<?endif?>
					<?if($arElement["PREVIEW_TEXT"]):?>
						<div class="Anonse"><?echo $arElement["PREVIEW_TEXT"];?></div>
					<?endif?>
				</div>
			</div>
			<?endif?>
		</div>
			<?endif?>
	<?endforeach; // foreach($arResult["ITEMS"] as $arElement):?>
</div>
<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
	<?=$arResult["NAV_STRING"]?>
<?endif;?>