<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
if(empty($arResult))
	return;?>
<ul>
	<?foreach($arResult as $itemIdex => $arItem):?>
	<li<?=$arItem["SELECTED"] ? " class='Active'" : ""?>><a href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a></li>
	<?endforeach;?>
</ul>