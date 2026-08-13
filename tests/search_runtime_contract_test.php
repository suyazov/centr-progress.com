<?php

$root = dirname(__DIR__);
$prefix = file_get_contents($root . '/local/lib/CentrProgress/Search/PrefixQuery.php');
$titleResultModifier = file_get_contents($root . '/bitrix/templates/template/components/bitrix/search.title/search/result_modifier.php');
$jsAssets = array(
    file_get_contents($root . '/bitrix/templates/template/js/scripts.js'),
    file_get_contents($root . '/bitrix/templates/template/js/scripts-min.js'),
);
$cssAssets = array(
    file_get_contents($root . '/bitrix/templates/template/template_styles.css'),
    file_get_contents($root . '/bitrix/templates/template/template_styles-min.css'),
    file_get_contents($root . '/public_html/bitrix/templates/template/template_styles.css'),
    file_get_contents($root . '/public_html/bitrix/templates/template/template_styles-min.css'),
);

foreach (array(
    'private const MIN_PREFIX_LENGTH = 3;',
    'private const MAX_INDEX_EXPANSIONS = 40;',
    'private const MAX_EXPANDED_QUERY_LENGTH = 220;',
    "s.STEM >= '",
    "s.STEM < '",
    "c.MODULE_ID = 'iblock'",
    "c.PARAM1 = 'infosection'",
    "c.PARAM2 = '7'",
) as $contract) {
    if (strpos($prefix, $contract) === false) {
        fwrite(STDERR, "Missing bounded prefix contract: {$contract}\n");
        exit(1);
    }
}
if (stripos($prefix, ' LIKE ') !== false) {
    fwrite(STDERR, "Prefix expansion must not use SQL LIKE\n");
    exit(1);
}
if (strpos($titleResultModifier, 'restoreOriginalInUserOutput($allItem["URL"])') === false) {
    fwrite(STDERR, "Quick-search all-results URL must preserve the original query\n");
    exit(1);
}

foreach ($jsAssets as $asset) {
    foreach (array('appendTo(document.body)', 'insertAfter($searchAnchor)', 'Escape') as $contract) {
        if (strpos($asset, $contract) === false) {
            fwrite(STDERR, "Missing popup lifecycle contract: {$contract}\n");
            exit(1);
        }
    }
}

foreach ($cssAssets as $asset) {
	foreach (array('z-index: 2147483600', 'overflow: visible') as $contract) {
        if (strpos($asset, $contract) === false) {
            fwrite(STDERR, "Missing popup CSS contract: {$contract}\n");
            exit(1);
        }
    }
}

foreach (array(
    'width: min(1180px, calc(100vw - 40px))',
    'max-height: calc(100dvh - 112px)',
    'body.PopupSearchOpen' => false,
) as $contract => $expected) {
    if (is_int($contract)) {
        $contract = $expected;
        $expected = true;
    }
    foreach (array_slice($cssAssets, 0, 2) as $asset) {
        if ((strpos($asset, $contract) !== false) !== $expected) {
            fwrite(STDERR, "Invalid compact popup contract: {$contract}\n");
            exit(1);
        }
    }
}

echo "OK\n";
