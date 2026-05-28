<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if (!empty($arResult)):?>
	<ul>
	<?
	$previousLevel = 0;
	foreach($arResult as $arItem):
	?>
		<?if ($previousLevel && $arItem["DEPTH_LEVEL"] < $previousLevel):?>
			<?=str_repeat("</ul></li>", ($previousLevel - $arItem["DEPTH_LEVEL"]));?>
		<?endif?>
		<?if ($arItem["IS_PARENT"]):?>
				<li class="Parent">
					<a href="<?=$arItem["LINK"]?>"<?if($arItem["CHILD_SELECTED"] == true):?> class="Selected"<?endif?>><?=$arItem["TEXT"]?></a>
					<ul>
		<?else:?>
			<?if ($arItem["PERMISSION"] > "D"):?>
					<li<?if ($arItem["SELECTED"]):?> class="Active"<?endif?>><a href="<?=$arItem["LINK"]?>"><span><?=$arItem["TEXT"]?></span></a></li>
			<?endif?>
		<?endif?>
		<?$previousLevel = $arItem["DEPTH_LEVEL"];?> 
	<?endforeach?>
	<?if ($previousLevel > 1)://close last item tags?>
		<?=str_repeat("</ul></li>", ($previousLevel-1) );?>
	<?endif?>
	</ul>
<?endif?>