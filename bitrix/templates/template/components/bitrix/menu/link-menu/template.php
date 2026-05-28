<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
if(empty($arResult))
	return;?>
<ul itemscope="" itemtype="https://schema.org/SiteNavigationElement">
	<?foreach($arResult as $itemIdex => $arItem):?>
	<li<?=$arItem["SELECTED"] ? " class='Active'" : ""?>><a href="<?=$arItem["LINK"]?>" itemprop="discussionUrl"><?=$arItem["TEXT"]?></a></li>
	<?endforeach;?>
</ul>