<?php

const REQUIRED_COURSE_NAME = 'Обучение по общим вопросам охраны труда и функционирования системы управления охраной труда';
const REQUIRED_COURSE_SECTION_COUNT = 6;
const REQUIRED_COURSE_TOTAL_HOURS = 16;

function coursePlanHasRequiredStructure($planHtml)
{
	preg_match_all('/<tr\\b[^>]*class=["\'][^"\']*course-plan-section[^"\']*["\'][^>]*>.*?<\\/tr>/is', $planHtml, $sections);
	if (count($sections[0]) !== REQUIRED_COURSE_SECTION_COUNT) {
		return false;
	}

	preg_match_all('/<td\\b[^>]*class=["\'][^"\']*course-plan-hours[^"\']*["\'][^>]*>\\s*(\\d+)\\s*<\\/td>/is', $planHtml, $hours);
	return array_sum(array_map('intval', $hours[1])) === REQUIRED_COURSE_TOTAL_HOURS;
}

function renderCoursePlan($courseName, $planHtml)
{
	if ($courseName !== REQUIRED_COURSE_NAME) {
		return $planHtml;
	}

	preg_match_all('/<table\\b[^>]*>.*?<\\/table>/is', $planHtml, $tables);
	if (count($tables[0]) < 2) {
		return $planHtml;
	}

	$normalizedFirst = preg_replace('/\\s+/u', ' ', strip_tags($tables[0][0]));
	$normalizedSecond = preg_replace('/\\s+/u', ' ', strip_tags($tables[0][1]));
	if ($normalizedFirst !== $normalizedSecond) {
		return $planHtml;
	}

	return substr_replace($planHtml, '', strpos($planHtml, $tables[0][1]), strlen($tables[0][1]));
}
