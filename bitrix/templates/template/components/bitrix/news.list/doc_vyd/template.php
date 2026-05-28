<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>


		<div class="doc_vyd_zag">Образцы выдаваемых документов</div>
		<div class="doc_vyd_list">
 
<?
$i=0;
foreach($arResult["ITEMS"] as $arItem):?>
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	$i++;
	?>

<?
if ($i==1){
?>
	<div class="doc_vyd_list_item">
<?	
}
?>
<?
if (($i==2) or ($i==4)) {
?>
	<div class="doc_vyd_list_item">
<?	
}
?>


			<a href="<?=$arItem['PREVIEW_PICTURE']['SRC']?>" data-fancybox="images" class="doc_vyd_list_item_1 <?if ($i==4){echo 'doc_vyd_list_item_4';}?>">
				<img class="brands-list__image" src="<?=$arItem['PREVIEW_PICTURE']['SRC']?>" alt="<?=$arItem['NAME']?>" title="<?=$arItem['NAME']?>">
			</a>
<?
if ($i==1){
?>
	</div>
	<div class="doc_vyd_list_item doc_vyd_list_item_col">
	
<?	
}
?>
<?
if ($i==2){
?>
	
<?	
}
?>

<?
if (($i==3) or ($i==5)) {
?>
	</div>
<?	
}
?>


<?endforeach;?>
				
<?
if (($i==2) or ($i==4)) {
?>
</div>
<?	
}
?>


			</div>

		</div>
