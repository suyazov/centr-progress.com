<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$this->setFrameMode(true);?>
<?
\Bitrix\Main\Page\Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . '/css/new_menu.css');
\Bitrix\Main\Page\Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/js/alphabet-menu.js');
CModule::IncludeModule('iblock');

if (!function_exists('cpAlphabetMenuCompare'))
{
	function cpAlphabetMenuCompare($a, $b)
	{
		$alphabet = 'АБВГДЕЁЖЗИЙКЛМНОПРСТУФХЦЧШЩЪЫЬЭЮЯ';
		$toKey = function($value) use ($alphabet) {
			$value = mb_strtoupper($value, 'UTF-8');
			$key = array();
			for ($i = 0, $len = mb_strlen($value, 'UTF-8'); $i < $len; $i++) {
				$char = mb_substr($value, $i, 1, 'UTF-8');
				$pos = mb_strpos($alphabet, $char, 0, 'UTF-8');
				$key[] = ($pos === false) ? 1000 : $pos;
			}
			return $key;
		};
		$left = $toKey($a);
		$right = $toKey($b);
		for ($i = 0, $len = max(count($left), count($right)); $i < $len; $i++) {
			$leftChar = isset($left[$i]) ? $left[$i] : -1;
			$rightChar = isset($right[$i]) ? $right[$i] : -1;
			if ($leftChar !== $rightChar) return $leftChar < $rightChar ? -1 : 1;
		}
		return 0;
	}
}
if (!function_exists('cpAlphabetMenuGroup'))
{
	function cpAlphabetMenuGroup($sections)
	{
		$groups = array();
		$seen = array();
		foreach ($sections as $section) {
			$name = trim((string)$section['NAME']);
			$url = trim((string)$section['SECTION_PAGE_URL']);
			if ($name === '' || $url === '') continue;
			$hash = $name . '|' . $url;
			if (isset($seen[$hash])) continue;
			$seen[$hash] = true;
			$letter = mb_strtoupper(mb_substr($name, 0, 1, 'UTF-8'), 'UTF-8');
			$groups[$letter][] = array('NAME' => $name, 'SECTION_PAGE_URL' => $url);
		}
		uksort($groups, 'cpAlphabetMenuCompare');
		foreach ($groups as &$items) usort($items, function($left, $right) { return cpAlphabetMenuCompare($left['NAME'], $right['NAME']); });
		unset($items);
		return $groups;
	}
}
$cpAlphabetSections = array();
$cpAlphabetResult = CIBlockSection::GetList(
	array('NAME' => 'ASC'),
	array('IBLOCK_ID' => 7, 'GLOBAL_ACTIVE' => 'Y'),
	true,
	array('ID', 'NAME', 'SECTION_PAGE_URL', 'UF_MENU'),
	array('nPageSize' => 500)
);
while ($section = $cpAlphabetResult->GetNext()) {
	if ((int)$section['UF_MENU'] === 2 || (int)$section['ELEMENT_CNT'] <= 0) continue;
	$cpAlphabetSections[] = array('NAME' => $section['NAME'], 'SECTION_PAGE_URL' => $section['SECTION_PAGE_URL']);
}
$cpAlphabetGroups = cpAlphabetMenuGroup($cpAlphabetSections);
?>

<ul class="store-horizontal" itemscope="" itemtype="https://schema.org/SiteNavigationElement">
	<?if(!empty($arResult)):
		$previousLevel = 0;					
		foreach($arResult as $arItem):
			if($previousLevel && $arItem["DEPTH_LEVEL"] < $previousLevel):
				echo str_repeat("</ul></li>", ($previousLevel - $arItem["DEPTH_LEVEL"]));
			endif;
			<?if($arItem['TEXT'] === 'Алфавитный указатель' || (isset($arItem['PARAMS']['ALPHABET_MENU']) && $arItem['PARAMS']['ALPHABET_MENU'] === 'Y')):?>
				<li class="dropdown alphabet-dropdown<?=($arItem['SELECTED'] ? ' Active' : '');?>">
					<a href="<?=$arItem['LINK']?>" itemprop="discussionUrl" aria-haspopup="true" aria-expanded="false"><span><?=$arItem['TEXT']?><i></i></span></a>
					<?if($cpAlphabetGroups):?>
					<div class="dropdown-menu alphabet-mega" role="menu">
						<div class="alphabet-groups">
							<?foreach($cpAlphabetGroups as $letter => $items):?>
							<div class="alphabet-group"><span class="alphabet-letter"><?=htmlspecialcharsbx($letter)?></span><ul>
								<?foreach($items as $item):?><li><a href="<?=htmlspecialcharsbx($item['SECTION_PAGE_URL'])?>" role="menuitem"><?=htmlspecialcharsbx($item['NAME'])?></a></li><?endforeach;?>
							</ul></div>
							<?endforeach;?>
						</div>
						<a class="alphabet-all" href="/napravleniya-obucheniya/">Все направления</a>
					</div>
					<?endif;?>
				</li>
			<?elseif($arItem["IS_PARENT"]):?>
				<li class="dropdown<?=($arItem['SELECTED'] ? ' Active' : '');?>">
					<a href="<?=$arItem['LINK']?>" itemprop="discussionUrl"><span><?=$arItem["TEXT"]?><i></i></span></a> 
					<ul class="dropdown-menu">
			<?else:?>
				<li<?=$arItem["SELECTED"] ? " class='Active'" : ""?>>
					<a href="<?=$arItem['LINK']?>" itemprop="discussionUrl"><span><?=$arItem["TEXT"]?><i></i></span></a>
				</li>
			<?endif;
			$previousLevel = $arItem["DEPTH_LEVEL"];						
		endforeach;
		if($previousLevel > 1):
			echo str_repeat("</ul></li>", ($previousLevel - 1));
		endif;
	endif;?>
</ul>

<script type="text/javascript">
	//<![CDATA[
	$(function() {
		//DROPDOWN//	
		$(".Menu ul.store-horizontal .dropdown:not(.more)").on({		
			mouseenter: function() {
				var menu = $(this).closest(".store-horizontal"),
					menuWidth = menu.outerWidth(),
					menuLeft = menu.offset().left,
					menuRight = menuLeft + menuWidth,
					isParentDropdownMenu = $(this).closest(".dropdown-menu"),					
					dropdownMenu = $(this).children(".dropdown-menu"),
					dropdownMenuWidth = dropdownMenu.outerWidth(),					
					dropdownMenuLeft = isParentDropdownMenu.length > 0 ? $(this).offset().left + $(this).outerWidth() : $(this).offset().left,
					dropdownMenuRight = dropdownMenuLeft + dropdownMenuWidth;
				if(dropdownMenuRight > menuRight) {
					if(isParentDropdownMenu.length > 0) {
						dropdownMenu.css({"left": "auto", "right": "100%"});
					} else {
						dropdownMenu.css({"right": "0"});
					}
				}
				$(this).children(".dropdown-menu").stop(true, true).delay(50).fadeIn(50);
			},
			mouseleave: function() {
				$(this).children(".dropdown-menu").stop(true, true).delay(50).fadeOut(50);
			}
		});
	});
	//]]>
</script>
