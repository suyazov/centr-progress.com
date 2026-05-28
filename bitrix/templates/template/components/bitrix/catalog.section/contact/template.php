<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="Items">
	<?foreach($arResult["ITEMS"] as $cell=>$arElement):?>
		<?
		$this->AddEditAction($arElement['ID'], $arElement['EDIT_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($arElement['ID'], $arElement['DELETE_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BCS_ELEMENT_DELETE_CONFIRM')));
		?>
		<div class="Item" id="<?=$this->GetEditAreaId($arElement['ID']);?>">
			<div class="Flex">
				<?if($arParams["DISPLAY_PICTURE"]!="N" && is_array($arElement["PREVIEW_PICTURE"])):
					$PICTURE = CFile::ResizeImageGet($arElement["PREVIEW_PICTURE"], Array('width'=>464, 'height'=>310), BX_RESIZE_IMAGE_EXACT, true);
				?>
				<div class="ImageBlock" style="background-image:url(<?=$PICTURE["src"]?>);">
					<img src="<?=SITE_TEMPLATE_PATH?>/images/transparent.gif" height="310px" alt="<?=$arItem["NAME"]?>" />
				</div>
				<?endif?>
				<div class="AdressBlock">
					<span class="Adress"><?echo $arElement["NAME"]?></span>
					<?if($arElement["DISPLAY_PROPERTIES"]["GRAFIK"]["VALUE"]):?>
					<div class="Grafik"><i class="fa"><i class="svg inline  svg-inline-clock colored" aria-hidden="true"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14">
					<defs>
						<style>
						  .cccls-1 {
							fill: #27aaf5;
							fill-rule: evenodd;
						  }
						</style>
					  </defs>
					  <path class="cccls-1" d="M7,0A7,7,0,1,1,0,7,7,7,0,0,1,7,0ZM7,2A5,5,0,1,1,2,7,5,5,0,0,1,7,2ZM9.434,9.434a1,1,0,0,1-1.414,0L6.293,7.707A1.014,1.014,0,0,1,6,7H6V4.656a1,1,0,0,1,2,0v1.93L9.434,8.02A1,1,0,0,1,9.434,9.434Z"></path>
					</svg>
					</i></i><span class="Text"><?=$arElement["DISPLAY_PROPERTIES"]["GRAFIK"]["VALUE"]?></span>
					</div>
					<?endif?>
					<?if($arElement["DISPLAY_PROPERTIES"]["MAIL"]["VALUE"]):?>
					<div class="MailLink">
						<i class="fa"><i class="svg inline  svg-inline-email colored" aria-hidden="true"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="13" viewBox="0 0 16 13">
						  <defs>
							<style>
							  .ecls-1 {
								fill: #27aaf5;
								fill-rule: evenodd;
							  }
							</style>
						  </defs>
						  <path class="ecls-1" d="M14,13H2a2,2,0,0,1-2-2V2A2,2,0,0,1,2,0H14a2,2,0,0,1,2,2v9A2,2,0,0,1,14,13ZM3.534,2L8.015,6.482,12.5,2H3.534ZM14,3.5L8.827,8.671a1.047,1.047,0,0,1-.812.3,1.047,1.047,0,0,1-.811-0.3L2,3.467V11H14V3.5Z"></path>
						</svg>
						</i></i><span class="Text"><a href="mailto:<?=$arElement["DISPLAY_PROPERTIES"]["MAIL"]["VALUE"]?>"><?=$arElement["DISPLAY_PROPERTIES"]["MAIL"]["VALUE"]?></a></span>
					</div>
					<?endif?> 
				</div>
				<div class="TelBlock">
					<?foreach($arElement["DISPLAY_PROPERTIES"]["TEL"]["VALUE"] as $k=>$value):?> 
					<a href="tel:<?=$value?>"><?=$value?></a>
					<?endforeach?>
					<?if($arElement["DISPLAY_PROPERTIES"]["FAX"]["VALUE"]):?>
					<span class="Fax"><?=$arElement["DISPLAY_PROPERTIES"]["FAX"]["NAME"]?>: <?=$arElement["DISPLAY_PROPERTIES"]["FAX"]["VALUE"]?></span>	
					<?endif?>
				</div>
			</div>
		</div>
	<?endforeach; // foreach($arResult["ITEMS"] as $arElement):?>
</div>