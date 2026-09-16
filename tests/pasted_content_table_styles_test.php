<?php

$root = dirname(__DIR__);

$stylesheets = array(
    'bitrix/templates/template/template_styles.css',
    'bitrix/templates/template/template_styles-min.css',
    'public_html/bitrix/templates/template/template_styles.css',
    'public_html/bitrix/templates/template/template_styles-min.css',
);

$fail = function ($message) {
    fwrite(STDERR, $message . "\n");
    exit(1);
};

// 1. Every mirrored stylesheet normalizes pasted typography on cells AND on
//    nested pasted descendants (span, p, font) that carry the inline styles.
foreach ($stylesheets as $path) {
    $css = file_get_contents($root . '/' . $path);
    foreach (array(
        '.Content table td',
        '.Content table th',
        '.Content table td *',
        '.Content table th *',
        'font-family: inherit !important',
        'font-size: inherit !important',
        'line-height: inherit !important',
    ) as $contract) {
        if (strpos($css, $contract) === false) {
            $fail("{$path}: missing pasted-table typography contract: {$contract}");
        }
    }

    // 2. The pasted-table block must stay typography-only: layout overrides
    //    (width, border collapsing, padding, vertical alignment) regress
    //    intentionally sized content tables and are not part of the diagnosis.
    $marker = strpos($css, 'Normalize typography of tables pasted through the visual editor.');
    if ($marker === false) {
        $fail("{$path}: missing pasted-table normalization block");
    }
    $ruleStart = strpos($css, '{', $marker);
    $ruleEnd = $ruleStart === false ? false : strpos($css, '}', $ruleStart);
    if ($ruleEnd === false) {
        $fail("{$path}: incomplete pasted-table normalization rule");
    }
    $declarations = substr($css, $ruleStart + 1, $ruleEnd - $ruleStart - 1);
    foreach (array('border-collapse', 'width', 'vertical-align', 'padding') as $layoutProperty) {
        if (preg_match('/(?:^|;)\s*' . preg_quote($layoutProperty, '/') . '\s*:/i', $declarations)) {
            $fail("{$path}: pasted-table block must not override layout property: {$layoutProperty}");
        }
    }
}

// 3. The fixture must actually exercise the reported failure modes so the
//    contract above is verified against realistic pasted markup.
$fixture = file_get_contents($root . '/tests/fixtures/pasted_content_table.html');
foreach (array(
    // nested pasted inline styles below the cell level
    "<span style=\"font-family:Arial,sans-serif;font-size:10pt;\">",
    "face=\"Verdana\"",
    "<span style=\"line-height:3;\">",
    // unequal column structures
    'colspan="2"',
    'rowspan="2"',
    // reported paste methods: Microsoft Word and Google Docs
    'MsoNormal',
    'docs-internal-guid',
) as $case) {
    if (strpos($fixture, $case) === false) {
        $fail("fixture tests/fixtures/pasted_content_table.html: missing paste regression case: {$case}");
    }
}

// 4. The fixture must only use inline typography properties that the scoped
//    rule normalizes; anything else would be unverified by this contract.
if (preg_match_all('/style="([^"]*)"/', $fixture, $matches)) {
    foreach ($matches[1] as $styleAttribute) {
        foreach (explode(';', $styleAttribute) as $declaration) {
            $declaration = trim($declaration);
            if ($declaration === '') {
                continue;
            }
            $property = trim(strtok($declaration, ':'));
            if (!in_array($property, array('font-family', 'font-size', 'line-height'), true)) {
                $fail("fixture uses inline property outside the confirmed diagnosis: {$property}");
            }
        }
    }
}

echo "pasted content table styles contract OK\n";
