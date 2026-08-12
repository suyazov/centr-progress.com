<?php

// Production read-back for TASK-ISSUE-SUYAZOV_CENTR-PROGRESS.COM-907.
// This intentionally exercises the real public route without mocks or request
// injection. Run only after the controlled production-maintenance lifecycle.

$baseUrl = isset($argv[1]) ? rtrim((string) $argv[1], '/') : 'https://centr-progress.com';
$cases = array(
    'лиф' => 'Лифтер 1-2 разряд',
    'лифт' => 'Лифтер 1-2 разряд',
    'тёпл' => 'теплопотребляющие установки',
);

foreach ($cases as $query => $requiredText) {
    $url = $baseUrl . '/search/index.php?q=' . rawurlencode($query);
    $context = stream_context_create(array('http' => array(
        'timeout' => 20,
        'follow_location' => 1,
        'max_redirects' => 5,
        'user_agent' => 'CentrProgress production search read-back',
    )));
    $html = @file_get_contents($url, false, $context);
    if ($html === false) {
        fwrite(STDERR, "Unable to read {$url}\n");
        exit(1);
    }

    $dom = new DOMDocument();
    $previous = libxml_use_internal_errors(true);
    $loaded = $dom->loadHTML('<?xml encoding="UTF-8">' . $html);
    libxml_clear_errors();
    libxml_use_internal_errors($previous);
    if (!$loaded) {
        fwrite(STDERR, "Unable to parse {$url}\n");
        exit(1);
    }

    $xpath = new DOMXPath($dom);
    $inputs = $xpath->query('//form//input[@name="q"]');
    if ($inputs->length < 1 || $inputs->item(0)->getAttribute('value') !== $query) {
        fwrite(STDERR, "Search input did not preserve query {$query}\n");
        exit(1);
    }

    $bodyText = $dom->textContent;
    foreach (array(' OR ', 'Internal Server Error', 'Fatal error') as $forbiddenText) {
        if (strpos($bodyText, $forbiddenText) !== false) {
            fwrite(STDERR, "Forbidden text found for {$query}: {$forbiddenText}\n");
            exit(1);
        }
    }
    if (strpos($bodyText, $requiredText) === false) {
        fwrite(STDERR, "Required result missing for {$query}: {$requiredText}\n");
        exit(1);
    }

    foreach ($xpath->query('//form | //a[@href]') as $node) {
        $attribute = $node->nodeName === 'form' ? 'action' : 'href';
        $target = html_entity_decode($node->getAttribute($attribute), ENT_QUOTES, 'UTF-8');
        if (strpos($target, ' OR ') !== false || preg_match('/(?:^|[?&])q=[^&]*(?:%20|\+)OR(?:%20|\+)/i', $target)) {
            fwrite(STDERR, "Expanded query leaked into {$attribute} for {$query}\n");
            exit(1);
        }
    }
}

echo "OK\n";
