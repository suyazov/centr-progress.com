<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
function formatFileSize($bytes) 
{
            if (!is_numeric($bytes) || !$bytes) {
                return '';
            }
            if ($bytes >= 1000000000) {
                return round($bytes / 1000000000,2).' '.GetMessage("GB");
            }
            if ($bytes >= 1000000) {
                return round($bytes / 1000000,2).' '.GetMessage("MB");
            }
            return round($bytes / 1000,2). ' '.GetMessage("KB");
};?>
					<div class="Product" itemscope itemtype="http://schema.org/Product">
						<div class="Flex">
							<div class="DetailInfo">
								<h1 itemprop="name"><?if(!empty($arResult["IPROPERTY_VALUES"]["ELEMENT_PAGE_TITLE"])):?><?=$arResult["IPROPERTY_VALUES"]["ELEMENT_PAGE_TITLE"]?><?else:?><?=$arResult["NAME"]?><?endif?></h1>
								<div class="Mobile CostBlock">