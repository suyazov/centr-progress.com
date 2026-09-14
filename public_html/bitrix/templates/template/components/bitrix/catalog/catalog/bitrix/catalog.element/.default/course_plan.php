<?php

const REQUIRED_COURSE_NAME = 'Обучение по общим вопросам охраны труда и функционирования системы управления охраной труда';
const REQUIRED_COURSE_SECTION_COUNT = 6;
const REQUIRED_COURSE_TOTAL_HOURS = 16;

function coursePlanCellText($html)
{
	$text = html_entity_decode(strip_tags($html), ENT_QUOTES, 'UTF-8');
	$text = str_replace("\xc2\xa0", ' ', $text);
	return trim(preg_replace('/\s+/u', ' ', $text));
}

function coursePlanHasRequiredStructure($planHtml)
{
	preg_match_all('/<tr\b[^>]*>.*?<\/tr>/is', $planHtml, $rows);
	$sections = array();
	$total = null;

	foreach ($rows[0] as $row) {
		preg_match_all('/<t[dh]\b[^>]*>(.*?)<\/t[dh]>/is', $row, $cells);
		if (count($cells[1]) < 3) {
			continue;
		}

		$number = coursePlanCellText($cells[1][0]);
		$title = coursePlanCellText($cells[1][1]);
		$hoursText = str_replace(',', '.', coursePlanCellText($cells[1][2]));
		if (!is_numeric($hoursText)) {
			continue;
		}

		if (preg_match('/^[1-6]$/', $number)) {
			$sections[(int) $number] = (float) $hoursText;
		} elseif (strpos($title, 'Итого') !== false) {
			$total = (float) $hoursText;
		}
	}

	ksort($sections);
	return array_keys($sections) === range(1, REQUIRED_COURSE_SECTION_COUNT)
		&& abs(array_sum($sections) - REQUIRED_COURSE_TOTAL_HOURS) < 0.001
		&& $total !== null
		&& abs($total - REQUIRED_COURSE_TOTAL_HOURS) < 0.001;
}

function coursePlanLeafTables($html)
{
	preg_match_all('/<\/?table\b[^>]*>/is', $html, $tokens, PREG_OFFSET_CAPTURE);
	$stack = array();
	$tables = array();

	foreach ($tokens[0] as $token) {
		$tag = $token[0];
		$offset = $token[1];
		if (stripos($tag, '</table') === 0) {
			if (!$stack) {
				continue;
			}
			$open = array_pop($stack);
			if (!$open['nested']) {
				$length = $offset + strlen($tag) - $open['offset'];
				$tables[] = substr($html, $open['offset'], $length);
			}
			continue;
		}

		if ($stack) {
			$stack[count($stack) - 1]['nested'] = true;
		}
		$stack[] = array('offset' => $offset, 'nested' => false);
	}

	return $tables;
}

function coursePlanExtractHtml($value)
{
	if (is_array($value) && isset($value['TEXT']) && is_string($value['TEXT'])) {
		return array($value['TEXT'], true);
	}
	if (!is_string($value)) {
		return array('', false);
	}

	if (preg_match('/^a:\d+:\{s:4:"TEXT";s:\d+:"/A', $value, $header)) {
		$decoded = @unserialize($value, array('allowed_classes' => false));
		if (is_array($decoded) && isset($decoded['TEXT']) && is_string($decoded['TEXT'])) {
			return array($decoded['TEXT'], true);
		}

		// Some historical Bitrix values were cut at the TEXT column limit. The
		// first complete curriculum table is still recoverable from that prefix.
		$html = substr($value, strlen($header[0]));
		$html = preg_replace('/";s:4:"TYPE";s:\d+:"[^"]*";\}\s*$/s', '', $html);
		return array($html, true);
	}

	return array($value, false);
}

function renderCoursePlan($courseName, $planValue)
{
	if ($courseName !== REQUIRED_COURSE_NAME) {
		return $planValue;
	}

	list($planHtml, $wasWrapped) = coursePlanExtractHtml($planValue);
	$leafTables = coursePlanLeafTables($planHtml);
	$validTables = array();
	foreach ($leafTables as $table) {
		if (coursePlanHasRequiredStructure($table)) {
			$validTables[] = $table;
		}
	}

	if (!$validTables) {
		return $planValue;
	}

	$normalized = array();
	foreach ($validTables as $table) {
		$normalized[hash('sha256', coursePlanCellText($table))] = true;
	}
	if (count($normalized) > 1) {
		return $planValue;
	}

	if (!$wasWrapped && count($leafTables) === 1) {
		return $planValue;
	}

	return $validTables[0];
}
