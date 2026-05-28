<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="FaqList">
<?foreach($arResult["ITEMS"] as $cell=>$arElement):?>
<div class="Item">
	<div class="QuestionBlock"><strong>Вопрос:</strong> <?=$arElement["PREVIEW_TEXT"]?></div>
	<?
		echo '<div class="Author">'. $arElement["NAME"]. ' / '. $arElement["DATE_CREATE"]. '</div>';
	?>
	<?if($arElement["DETAIL_TEXT"]):?>
	<div class="ResponseBlock"> <?=$arElement["DETAIL_TEXT"]?></div>
	<?endif;?>
</div>
<?endforeach;?>
</div>
<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
<?=$arResult["NAV_STRING"]?>
<?endif;?>