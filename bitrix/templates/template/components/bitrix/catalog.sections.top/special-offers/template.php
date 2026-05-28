<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="coda-slider-wrapper">
	<div class="coda-slider preload" id="coda-slider-1">
	<?foreach($arResult["SECTIONS"] as $arSection):?>
		<div class="panel">
			<div class="panel-wrapper">
				<div class="Tab"><?=$arSection["NAME"]?></div>
				<?
					$cell = 0;
					foreach($arSection["ITEMS"] as $arElement):
				?>
				<?
					$this->AddEditAction($arElement['ID'], $arElement['EDIT_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT"));
					$this->AddDeleteAction($arElement['ID'], $arElement['DELETE_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BCST_ELEMENT_DELETE_CONFIRM')));
				?>
				<div class="Item" id="<?=$this->GetEditAreaId($arElement['ID']);?>">
					<div class="Title"><?=$arElement["NAME"]?></div>
					<div class="Desc"><?=$arElement["PREVIEW_TEXT"]?></div>
					<div class="Links">
						<a href="<?=$arElement["DETAIL_PAGE_URL"]?>" class="Readon">Узнать больше</a>
						или    
						<a href="/spetspredlozheniya/">посмотреть все спецпредложения</a>
					</div>
				</div>
				<?endforeach?>
			</div>
		</div>
	<?endforeach?>
	</div>
</div>
