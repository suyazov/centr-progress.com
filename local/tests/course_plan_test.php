<?php

$template = file_get_contents(__DIR__ . '/../../bitrix/templates/template/components/bitrix/catalog/catalog/bitrix/catalog.element/.default/template.php');
if (!preg_match('/\/\* COURSE_PLAN_HELPER_START \*\/(.*?)\/\* COURSE_PLAN_HELPER_END \*\//s', $template, $helper)) {
	throw new RuntimeException('Course-plan helper block was not found in the live template source.');
}
eval($helper[1]);

$hoursBySection = array(1 => '4', 2 => '1,5', 3 => '6,5', 4 => '1', 5 => '1', 6 => '2');
$rows = '<tr><td>№ п/п</td><td>Наименование разделов и тем</td><td>Часы</td></tr>';
foreach ($hoursBySection as $number => $hours) {
	$rows .= '<tr><td><b>' . $number . '</b></td><td><b>Раздел ' . $number . '</b></td><td><b>' . $hours . '</b></td></tr>';
	$rows .= '<tr><td>' . $number . '.1</td><td>Тема</td><td>0,5</td></tr>';
}
$rows .= '<tr><td></td><td><b>Итого</b></td><td><b>16</b></td></tr>';
$plan = '<table class="MsoTable15Plain1" border="1"><tbody>' . $rows . '</tbody></table>';
$duplicatedPlan = '<table width="100%"><tr><td>' . $plan . $plan . '</td></tr></table>';
$serializedPlan = serialize(array('TEXT' => $duplicatedPlan, 'TYPE' => 'html'));
$truncatedPlan = 'a:2:{s:4:"TEXT";s:99999:"<table width="100%"><tr><td>' . $plan . substr($plan, 0, 80);

if (!coursePlanHasRequiredStructure($plan)) {
	throw new RuntimeException('Expected six top-level sections with a total of 16 hours.');
}
foreach (array($duplicatedPlan, $serializedPlan, $truncatedPlan) as $input) {
	$result = renderCoursePlan(REQUIRED_COURSE_NAME, $input);
	if ($result !== $plan || substr_count($result, '<table') !== 1) {
		throw new RuntimeException('Expected exactly the first complete curriculum table.');
	}
}
if (renderCoursePlan('Другой курс', $serializedPlan) !== $serializedPlan) {
	throw new RuntimeException('Unexpected modification of another course plan.');
}

$wrongTotal = str_replace('<b>16</b>', '<b>15</b>', $duplicatedPlan);
if (renderCoursePlan(REQUIRED_COURSE_NAME, $wrongTotal) !== $wrongTotal) {
	throw new RuntimeException('Unexpected modification of an invalid curriculum plan.');
}

echo "course_plan_test: PASS\n";
