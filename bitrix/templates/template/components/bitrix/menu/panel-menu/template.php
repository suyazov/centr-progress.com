<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$this->setFrameMode(true);?>
<nav id="menu">
<ul>
	<?if(!empty($arResult)):
		$previousLevel = 0;					
		foreach($arResult as $arItem):
			if($previousLevel && $arItem["DEPTH_LEVEL"] < $previousLevel):
				echo str_repeat("</ul></li>", ($previousLevel - $arItem["DEPTH_LEVEL"]));
			endif;
			if($arItem["IS_PARENT"]):?>
				<li>
					<a href="<?=$arItem['LINK']?>"><?=$arItem["TEXT"]?></a> 
					<ul>
			<?else:?>
				<li>
					<a href="<?=$arItem['LINK']?>"><?=$arItem["TEXT"]?></a>
				</li>
			<?endif;
			$previousLevel = $arItem["DEPTH_LEVEL"];						
		endforeach;
		if($previousLevel > 1):
			echo str_repeat("</ul></li>", ($previousLevel - 1));
		endif;
	endif;?>
</ul>
</nav>
		<script src="<?=SITE_TEMPLATE_PATH?>/js/mmenu.js"></script>
		<script src="<?=SITE_TEMPLATE_PATH?>/js/mmenu.debugger.js"></script>
		<script>
			new Mmenu( document.querySelector( '#menu' ) );

			document.addEventListener( 'click', ( evnt ) => {
				let anchor = evnt.target.closest( 'a[href^="#/"]' );
				if ( anchor ) {
					alert('Thank you for clicking, but that\'s a demo link.');
					evnt.preventDefault();
				}
			});
		</script>