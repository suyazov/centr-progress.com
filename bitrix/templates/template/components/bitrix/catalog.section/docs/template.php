<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>
<?if($arResult["ITEMS"]):?>
<div class="FilesList">
<?foreach($arResult["ITEMS"] as $cell=>$arElement):?>
<?if($arElement["PROPERTIES"]["HIDDEN"]["VALUE"]!="Да"):?>
		<?
		$this->AddEditAction($arElement['ID'], $arElement['EDIT_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($arElement['ID'], $arElement['DELETE_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BCS_ELEMENT_DELETE_CONFIRM')));
		?>
		<div class="Item<?if($arElement["DETAIL_TEXT"]):?> Detail <?if(is_countable($arElement["DISPLAY_PROPERTIES"]["FILE"]["VALUE"])>=2):?> Docs<?endif;?> <?endif?>" id="<?=$this->GetEditAreaId($arElement['ID']);?>">
			<?if($arElement["DETAIL_TEXT"]):?>
			<?
			$arFilters = Array(array("name" => "watermark", "position" => "center", "size"=>"real", 'type'=>'image', "file"=>$_SERVER['DOCUMENT_ROOT']."/images/water-mark.png"));
			$PICTURE = CFile::ResizeImageGet($arElement["PREVIEW_PICTURE"], Array('width'=>303, 'height'=>217), BX_RESIZE_IMAGE_EXACT, true);
			?>
			<div class="Desc<?if($arElement["PREVIEW_PICTURE"]):?> Img<?endif;?>">
			<?if(is_countable($arElement["DISPLAY_PROPERTIES"]["FILE"]["VALUE"])>=2):?>
				<div class="DocsInfo">
					<div class="Info">
						<div class="IconDoc"><span><?=count($arElement["DISPLAY_PROPERTIES"]["FILE"]["VALUE"])?></span></div>
						<div class="Name"><a href="<?=$arElement["DETAIL_PAGE_URL"]?>"><?=$arElement["NAME"]?></a></div>
						<?if($arElement["PROPERTIES"]["DATEPUBLIC"]["VALUE"]=="Да"):?>
						<?if($arElement["ACTIVE_FROM"]):?>
						<div class="Date">
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
				<?if($arElement["PROPERTIES"]["DATEPUBLIC"]["VALUE"]=="Да"):?>
						<?if($arElement["ACTIVE_FROM"]):?>
						<div class="Date">
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
			<?elseif(is_countable($arElement["DISPLAY_PROPERTIES"]["FILE"]["VALUE"])==0):?>
											<?if($arElement["PROPERTIES"]["FILE_LINK"]["VALUE"]):?> 
											<?foreach($arElement["PROPERTIES"]["FILE_LINK"]["VALUE"] as $k=>$value):?>
											<a href="<?=$value?>"><?if($arElement["PROPERTIES"]["FILE_LINK"]["DESCRIPTION"][$k]):?>
<?=$arElement["PROPERTIES"]["FILE_LINK"]["DESCRIPTION"][$k]?><?endif;?></a>
											<?endforeach?> 

			<?else:?> 
				<?if($arElement["DISPLAY_PROPERTIES"]["PAGE"]["VALUE"]):?>
<div class="Name"><a href="<?=$arElement["DISPLAY_PROPERTIES"]["PAGE"]["VALUE"]?>" target="_blank"><?=$arElement["NAME"]?></a></div>
						<?else:?>
<div class="Name"><?=$arElement["NAME"]?></div>
						<?endif?>
											<?endif;?>
				<?if($arElement["DISPLAY_PROPERTIES"]["FILE_LINK"]["VALUE"]):?>
				<div class="Link"><a href="<?=$arElement["DISPLAY_PROPERTIES"]["FILE_LINK"]["VALUE"]?>" target="_blank"><?=$arElement["DISPLAY_PROPERTIES"]["FILE_LINK_TEXT"]["VALUE"]?></a></div>
				<?endif?> 
				<?if($arElement["PROPERTIES"]["DATEPUBLIC"]["VALUE"]=="Да"):?>
						<?if($arElement["ACTIVE_FROM"]):?>
						<div class="Date">
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
			<?elseif(is_countable($arElement["DISPLAY_PROPERTIES"]["FILE"]["VALUE"])==1):?>
			<div class="DocsInfo">
					<?if($arElement["DISPLAY_PROPERTIES"]['FILE']['FILE_VALUE']['SRC']):
							$ext=substr($arElement["DISPLAY_PROPERTIES"]['FILE']['FILE_VALUE']['SRC'], strrpos($arElement["DISPLAY_PROPERTIES"]['FILE']['FILE_VALUE']['SRC'], '.') + 1);?>
							<div class="DocList">
														<table>	
															<tbody><tr>
																<td class="IconTD"><span class="<?=$ext?>"></span></td>
																<td class="NameTD">
																	<div class="Name">
																		<?if($arElement["PROPERTIES"]["FILE_LINK"]["VALUE"]):?>
																		<a href="<?=$arElement["PROPERTIES"]["FILE_LINK"]["VALUE"]?>"><?=$arElement["NAME"]?></a>
																		<?else:?>
																		<a href="<?=$arElement["DISPLAY_PROPERTIES"]['FILE']['FILE_VALUE']['SRC']?>"><?=$arElement["NAME"]?></a>
																		<?endif?>
																	</div>
																	<div class="Format"><?=formatFileSize($arElement["DISPLAY_PROPERTIES"]['FILE']['FILE_VALUE']['FILE_SIZE'])?></div>
																</td>
															</tr>
														</tbody></table>
													</div>
						<?endif;?>
			</div>
			<?elseif(is_countable($arElement["DISPLAY_PROPERTIES"]["FILE"]["VALUE"])>=2):?>
			<div class="DocsInfo">
				<div class="IconDoc"><span><?=count($arElement["DISPLAY_PROPERTIES"]["FILE"]["VALUE"])?></span></div>
				<div class="Name"><a href="<?=$arElement["DETAIL_PAGE_URL"]?>"><?=$arElement["NAME"]?></a></div>
					<?if($arElement["PROPERTIES"]["DATEPUBLIC"]["VALUE"]=="Да"):?>
					<?if($arElement["ACTIVE_FROM"]):?>
					<div class="Date">
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
			<?endif?>
		</div>
			<?endif?>
	<?endforeach; // foreach($arResult["ITEMS"] as $arElement):?>
</div>
<?endif;?>