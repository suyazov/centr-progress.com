<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main\Localization\Loc;
use Bitrix\Highloadblock\HighloadBlockTable as HLBT;

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $item
 * @var array $actualItem
 * @var array $minOffer
 * @var array $itemIds
 * @var array $price
 * @var array $measureRatio
 * @var bool $haveOffers
 * @var bool $showSubscribe
 * @var array $morePhoto
 * @var bool $showSlider
 * @var bool $itemHasDetailUrl
 * @var string $imgTitle
 * @var string $productTitle
 * @var string $buttonSizeClass
 * @var CatalogSectionComponent $component
 */
?>
<?if (empty($arResult['STARTSHOP']['OFFERS'])):?>
   <?if($arResult["PROPERTIES"]["ORDER"]["VALUE"]=="Да"):?>
		<div class="Button"><a data-fancybox data-src="#OrderProduct" href="javascript:;" class="Btn"><span><?=GetMessage('SH_CE_DEFAULT_ORDER')?></span></a></div>
	<?endif?>
</div>
<?else:?>
    <?foreach ($arResult['STARTSHOP']['OFFERS'] as $arOffer):?>
	<div class="Calc startshop-order StartShopOffersOrder<?=$arOffer['ID']?>" style="display: none;">
	<?=$arOffer['ID']?>
	</div>
    <?endforeach;?>
<?endif;?>