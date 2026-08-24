<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
if(empty($arResult)) return;

$cpMenuAssetVersion = '20260824-2';
\Bitrix\Main\Page\Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . '/css/new_menu.css?v=' . $cpMenuAssetVersion);
\Bitrix\Main\Page\Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . '/css/service-mega-menu.css?v=' . $cpMenuAssetVersion);
\Bitrix\Main\Page\Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/js/service-mega-menu.js?v=' . $cpMenuAssetVersion);
CModule::IncludeModule('iblock');

if (!function_exists('cpServiceMenuGroups'))
{
	function cpServiceMenuGroups($parentId)
	{
		$groups = array();
		$seen = array();
		$result = CIBlockSection::GetList(
			array('NAME' => 'ASC'),
			array('IBLOCK_ID' => 7, 'GLOBAL_ACTIVE' => 'Y', 'SECTION_ID' => (int)$parentId),
			false,
			array('ID', 'NAME', 'SECTION_PAGE_URL', 'UF_MENU'),
			array('nPageSize' => 300)
		);
		while ($section = $result->GetNext()) {
			if ((int)$section['UF_MENU'] === 2) continue;
			$name = trim((string)$section['NAME']);
			$url = trim((string)$section['SECTION_PAGE_URL']);
			$dedupeKey = mb_strtolower(preg_replace('/\s+/u', ' ', $name), 'UTF-8');
			if ($name === '' || $url === '' || isset($seen[$dedupeKey])) continue;
			$seen[$dedupeKey] = true;
			$letter = mb_strtoupper(mb_substr($name, 0, 1, 'UTF-8'), 'UTF-8');
			$groups[$letter][] = array('NAME' => $name, 'URL' => $url);
		}
		ksort($groups, SORT_LOCALE_STRING);
		return $groups;
	}
}

$cpServiceRoots = array(
	'Повышение квалификации' => 5,
	'Профессиональная переподготовка' => 6,
	'Дополнительное образование' => 7,
	'Профессиональное обучение' => 8,
);
?>

<ul class="service-menu" itemscope="" itemtype="https://schema.org/SiteNavigationElement">
	<?foreach($arResult as $arItem):?>
		<?
		$groups = array();
		if (isset($cpServiceRoots[$arItem['TEXT']])) {
			$groups = cpServiceMenuGroups($cpServiceRoots[$arItem['TEXT']]);
		} elseif ($arItem['TEXT'] === 'Семинары') {
			$groups = array('С' => array(array('NAME' => 'Все семинары', 'URL' => $arItem['LINK'])));
		}
		$isDropdown = !empty($groups);
		?>
		<li class="<?=$isDropdown ? 'dropdown service-mega-dropdown ' : ''?><?=$arItem['SELECTED'] ? 'Active' : ''?>">
			<a class="<?=$isDropdown ? 'service-mega-toggle' : ''?>" href="<?=htmlspecialcharsbx($arItem['LINK'])?>" itemprop="discussionUrl"<?=$isDropdown ? ' aria-haspopup="true" aria-expanded="false"' : ''?>><?=htmlspecialcharsbx($arItem['TEXT'])?></a>
			<?if($isDropdown):?>
			<div class="dropdown-menu service-mega" role="menu">
				<div class="service-mega-groups">
					<?foreach($groups as $letter => $items):?>
					<section class="service-mega-group">
						<div class="service-mega-letter"><?=htmlspecialcharsbx($letter)?></div>
						<ul>
							<?foreach($items as $item):?>
							<li><a href="<?=htmlspecialcharsbx($item['URL'])?>" role="menuitem"><?=htmlspecialcharsbx($item['NAME'])?></a></li>
							<?endforeach;?>
						</ul>
					</section>
					<?endforeach;?>
				</div>
				<a class="service-mega-all" href="<?=htmlspecialcharsbx($arItem['LINK'])?>">Смотреть все</a>
			</div>
			<?endif;?>
		</li>
	<?endforeach;?>
</ul>
