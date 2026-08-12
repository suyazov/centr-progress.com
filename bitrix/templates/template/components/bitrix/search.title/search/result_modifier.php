<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$PREVIEW_WIDTH = intval($arParams["PREVIEW_WIDTH"]);
if ($PREVIEW_WIDTH <= 0)
	$PREVIEW_WIDTH = 75;

$PREVIEW_HEIGHT = intval($arParams["PREVIEW_HEIGHT"]);
if ($PREVIEW_HEIGHT <= 0)
	$PREVIEW_HEIGHT = 75;

$arParams["PRICE_VAT_INCLUDE"] = $arParams["PRICE_VAT_INCLUDE"] !== "N";

$arCatalogs = false;

$arResult["ELEMENTS"] = array();
$arResult["SEARCH"] = array();
foreach($arResult["CATEGORIES"] as $category_id => $arCategory)
{
	foreach($arCategory["ITEMS"] as $i => $arItem)
	{
		if(isset($arItem["ITEM_ID"]))
		{
			$arResult["SEARCH"][] = &$arResult["CATEGORIES"][$category_id]["ITEMS"][$i];
			if (
				$arItem["MODULE_ID"] == "iblock"
				&& substr($arItem["ITEM_ID"], 0, 1) !== "S"
			)
			{
				// Current names are required even when the content iblock is not
				// configured as a Bitrix catalog.
				$arResult["ELEMENTS"][$arItem["ITEM_ID"]] = $arItem["ITEM_ID"];
				if ($arCatalogs === false)
				{
					$arCatalogs = array();
					if (CModule::IncludeModule("catalog"))
					{
						$rsCatalog = CCatalog::GetList(array(
							"sort" => "asc",
						));
						while ($ar = $rsCatalog->Fetch())
						{
							if ($ar["PRODUCT_IBLOCK_ID"])
								$arCatalogs[$ar["PRODUCT_IBLOCK_ID"]] = 1;
							else
								$arCatalogs[$ar["IBLOCK_ID"]] = 1;
						}
					}
				}

			}
		}
	}
}

if (!empty($arResult["ELEMENTS"]) && CModule::IncludeModule("iblock"))
{
	$arConvertParams = array();
	if ('Y' == $arParams['CONVERT_CURRENCY'])
	{
		if (!CModule::IncludeModule('currency'))
		{
			$arParams['CONVERT_CURRENCY'] = 'N';
			$arParams['CURRENCY_ID'] = '';
		}
		else
		{
			$arCurrencyInfo = CCurrency::GetByID($arParams['CURRENCY_ID']);
			if (!(is_array($arCurrencyInfo) && !empty($arCurrencyInfo)))
			{
				$arParams['CONVERT_CURRENCY'] = 'N';
				$arParams['CURRENCY_ID'] = '';
			}
			else
			{
				$arParams['CURRENCY_ID'] = $arCurrencyInfo['CURRENCY'];
				$arConvertParams['CURRENCY_ID'] = $arCurrencyInfo['CURRENCY'];
			}
		}
	}

	$obParser = new CTextParser;

	if (is_array($arParams["PRICE_CODE"]))
		$arResult["PRICES"] = CIBlockPriceTools::GetCatalogPrices(0, $arParams["PRICE_CODE"]);
	else
		$arResult["PRICES"] = array();

	$arSelect = array(
		"ID",
		"IBLOCK_ID",
		"NAME",
		"PREVIEW_TEXT",
		"PREVIEW_PICTURE",
		"DETAIL_PICTURE",
	);
	$arFilter = array(
		"IBLOCK_LID" => SITE_ID,
		"IBLOCK_ACTIVE" => "Y",
		"ACTIVE_DATE" => "Y",
		"ACTIVE" => "Y",
		"CHECK_PERMISSIONS" => "Y",
		"MIN_PERMISSION" => "R",
	);
	foreach($arResult["PRICES"] as $value)
	{
		$arSelect[] = $value["SELECT"];
		$arFilter["CATALOG_SHOP_QUANTITY_".$value["ID"]] = 1;
	}
	$arFilter["=ID"] = $arResult["ELEMENTS"];
	$arResult["ELEMENTS"] = array();
	$rsElements = CIBlockElement::GetList(array(), $arFilter, false, false, $arSelect);
	while($arElement = $rsElements->Fetch())
	{
		$arElement["PRICES"] = CIBlockPriceTools::GetItemPrices($arElement["IBLOCK_ID"], $arResult["PRICES"], $arElement, $arParams['PRICE_VAT_INCLUDE'], $arConvertParams);
		if($arParams["PREVIEW_TRUNCATE_LEN"] > 0)
			$arElement["PREVIEW_TEXT"] = $obParser->html_cut($arElement["PREVIEW_TEXT"], $arParams["PREVIEW_TRUNCATE_LEN"]);

		$arResult["ELEMENTS"][$arElement["ID"]] = $arElement;
	}
}

foreach($arResult["SEARCH"] as $i=>$arItem)
{
	switch($arItem["MODULE_ID"])
	{
		case "iblock":
			if(array_key_exists($arItem["ITEM_ID"], $arResult["ELEMENTS"]))
			{
				$arElement = &$arResult["ELEMENTS"][$arItem["ITEM_ID"]];
				// The search index can retain an old short title. Suggestions must
				// render the current element name, not stale indexed display text.
				$arResult["SEARCH"][$i]["NAME"] = htmlspecialcharsbx($arElement["NAME"]);

				if ($arParams["SHOW_PREVIEW"] == "Y")
				{
					if ($arElement["PREVIEW_PICTURE"] > 0)
						$arElement["PICTURE"] = CFile::ResizeImageGet($arElement["PREVIEW_PICTURE"], array("width"=>$PREVIEW_WIDTH, "height"=>$PREVIEW_HEIGHT), BX_RESIZE_IMAGE_PROPORTIONAL, true);
					elseif ($arElement["DETAIL_PICTURE"] > 0)
						$arElement["PICTURE"] = CFile::ResizeImageGet($arElement["DETAIL_PICTURE"], array("width"=>$PREVIEW_WIDTH, "height"=>$PREVIEW_HEIGHT), BX_RESIZE_IMAGE_PROPORTIONAL, true);
				}
			}
			break;
	}

	$arResult["SEARCH"][$i]["ICON"] = true;
}

// The search index order is not suitable for quick suggestions. Rank only
// currently active, readable iblock elements by their current names, then
// render a bounded list. No course-specific values are encoded here.
$searchQuery = isset($_REQUEST['q']) ? trim((string) $_REQUEST['q']) : '';
if (class_exists('CentrProgress\\Search\\PrefixQuery'))
	$searchQuery = trim((string) \CentrProgress\Search\PrefixQuery::originalQuery());

$normalizeSearchText = static function ($value) {
	$value = html_entity_decode(strip_tags((string) $value), ENT_QUOTES, SITE_CHARSET);
	return function_exists('mb_strtolower')
		? mb_strtolower($value, SITE_CHARSET)
		: strtolower($value);
};
$normalizedQuery = $normalizeSearchText($searchQuery);
$rankedItems = array();

foreach ($arResult["CATEGORIES"] as $arCategory)
{
	foreach ($arCategory["ITEMS"] as $arItem)
	{
		$itemId = isset($arItem["ITEM_ID"]) ? (string) $arItem["ITEM_ID"] : '';
		if ($itemId === '' || !isset($arResult["ELEMENTS"][$itemId]))
			continue;

		$name = (string) $arResult["ELEMENTS"][$itemId]["NAME"];
		$normalizedName = $normalizeSearchText($name);
		$position = $normalizedQuery === '' ? false : strpos($normalizedName, $normalizedQuery);
		if ($position === false)
			continue;

		$wordPrefix = $position === 0;
		if (!$wordPrefix && function_exists('preg_match'))
		{
			$wordPrefix = preg_match(
				'/(?:^|[^\\p{L}\\p{N}])' . preg_quote($normalizedQuery, '/') . '/u',
				$normalizedName
			) === 1;
		}

		$arItem["NAME"] = htmlspecialcharsbx($name);
		$rankedItems[] = array(
			"ITEM" => $arItem,
			"RANK" => $position === 0 ? 0 : ($wordPrefix ? 1 : 2),
			"POSITION" => $position,
			"NAME" => $normalizedName,
			"ID" => (int) $itemId,
		);
	}
}

usort($rankedItems, static function ($left, $right) {
	foreach (array("RANK", "POSITION", "NAME", "ID") as $key)
	{
		if ($left[$key] == $right[$key])
			continue;
		return $left[$key] < $right[$key] ? -1 : 1;
	}
	return 0;
});

$suggestions = array();
foreach (array_slice($rankedItems, 0, 5) as $rankedItem)
	$suggestions[] = $rankedItem["ITEM"];

$allItems = isset($arResult["CATEGORIES"]["all"]["ITEMS"])
	? $arResult["CATEGORIES"]["all"]["ITEMS"]
	: array();
// Bitrix builds the "all results" URL from the backend query. Keep the
// wildcard/stem expression internal just like the visible search inputs and
// full-search pager links.
if (class_exists('CentrProgress\\Search\\PrefixQuery'))
{
	foreach ($allItems as &$allItem)
	{
		if (isset($allItem["URL"]))
			$allItem["URL"] = \CentrProgress\Search\PrefixQuery::restoreOriginalInUserOutput($allItem["URL"]);
	}
	unset($allItem);
}
$arResult["CATEGORIES"] = array();
if (!empty($suggestions))
	$arResult["CATEGORIES"]["suggestions"] = array("ITEMS" => $suggestions);
if (!empty($allItems))
	$arResult["CATEGORIES"]["all"] = array("ITEMS" => array_slice($allItems, 0, 1));
$arResult['CATEGORIES_ITEMS_EXISTS'] = !empty($suggestions);

?>
