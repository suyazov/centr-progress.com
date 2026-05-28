<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>
<div class="CatalogSection">
<?foreach($arResult["SECTIONS"] as $arSection):?>
<?if($arSection["ITEMS"]):?>
<div class="Category"><a href="<?=$arSection["SECTION_PAGE_URL"]?>"><?=$arSection["NAME"]?></a></div>
<?endif?>
<?if($arSection["ITEMS"]):?>
<div class="Items">
	<table class="Table"> 
		<tr class="Item" id="<?=$this->GetEditAreaId($arElement['ID']);?>">
			<td class="Name">Наименование</td>
			<td>Предназначение</td>
		</tr>
		<?
		$item = 1;
		foreach($arSection["ITEMS"] as $arElement):
		?>
		<?
		$this->AddEditAction($arElement['ID'], $arElement['EDIT_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($arElement['ID'], $arElement['DELETE_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BCST_ELEMENT_DELETE_CONFIRM')));
		?>
		<tr class="Item" id="<?=$this->GetEditAreaId($arElement['ID']);?>">
			<td class="Name"><a href="<?=$arElement["DETAIL_PAGE_URL"]?>"><?=$arElement["NAME"]?></a></td>
			<?if($arElement["PROPERTIES"]["PREDNAZNACHENIE"]["VALUE"]):?>
			<td><?=$arElement["PROPERTIES"]["PREDNAZNACHENIE"]["VALUE"]?></td>
			<?else:?> 
			<td><?=$arElement["PREVIEW_TEXT"]?></td>
			<?endif?>
		</tr>
	<?
	$item++;
	endforeach;?>
	</table>
</div>
<?endif?>
<?endforeach?>
</div>
