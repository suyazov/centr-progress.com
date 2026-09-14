<?php

require __DIR__ . '/course_plan.php';

$rows = '';
foreach (array(2, 3, 2, 3, 2, 4) as $number => $hours) {
	$rows .= '<tr class="course-plan-section"><td>Раздел ' . ($number + 1) . '</td><td class="course-plan-hours">' . $hours . '</td></tr>';
}
$plan = '<table>' . $rows . '</table>';
$duplicatedPlan = $plan . $plan;

if (!coursePlanHasRequiredStructure($plan)) {
	throw new RuntimeException('Expected six sections with a total of 16 hours.');
}
if (substr_count(renderCoursePlan(REQUIRED_COURSE_NAME, $duplicatedPlan), '<table>') !== 1) {
	throw new RuntimeException('Expected the duplicate course-plan table to be removed.');
}
if (renderCoursePlan('Другой курс', $duplicatedPlan) !== $duplicatedPlan) {
	throw new RuntimeException('Unexpected modification of another course plan.');
}

echo "course_plan_test: PASS\n";
