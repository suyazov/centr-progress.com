<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$this->setFrameMode(true);

if(empty($arResult))
	return;?>
<?foreach($arResult as $itemIdex => $arItem):?>
<a href="<?=$arItem["LINK"]?>" target="_blank" title="<?=$arItem["TEXT"]?>" class="<?=$arItem['PARAMS']['icon']?>" rel="nofollow"><span><?=$arItem["TEXT"]?></span></a>
<?endforeach;?>