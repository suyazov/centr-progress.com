<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$this->setFrameMode(true);?>

<ul class="store-horizontal" itemscope="" itemtype="https://schema.org/SiteNavigationElement">
	<?if(!empty($arResult)):
		$previousLevel = 0;					
		foreach($arResult as $arItem):
			if($previousLevel && $arItem["DEPTH_LEVEL"] < $previousLevel):
				echo str_repeat("</ul></li>", ($previousLevel - $arItem["DEPTH_LEVEL"]));
			endif;
			if($arItem["IS_PARENT"]):?>
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