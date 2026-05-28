<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
if(empty($arResult))
	return;?>
<?
use \Bitrix\Main\Page\Asset;
Asset::getInstance()->addCss( SITE_TEMPLATE_PATH . '/css/new_menu.css' );
CModule::IncludeModule("iblock");
?>


<ul itemscope="" itemtype="https://schema.org/SiteNavigationElement">
	<?foreach($arResult as $itemIdex => $arItem):?>

<?
// echo '<pre style="display:none">';
// Print_r($arItem);
// echo '</pre>';
?>

<?
$class='';
$class_t='';

if (($arItem['TEXT']=='Повышение квалификации') or ($arItem['TEXT']=='Профессиональная переподготовка') or ($arItem['TEXT']=='Профессиональная переподготовка') or ($arItem['TEXT']=='Дополнительное образование') or ($arItem['TEXT']=='Профессиональное обучение') or ($arItem['TEXT']=='Семинары')){
	$class_t='dropdown ';
}

if ($arItem["SELECTED"]==1){
	$class_t=$class_t.'Active ';
}

if ($class_t!=''){
	$class='class="'.$class_t.'"';
}
?>


	<li <?=$class?>>
		<a href="<?=$arItem["LINK"]?>" itemprop="discussionUrl"><?=$arItem["TEXT"]?></a>
		<?
if ($arItem['TEXT']=='Повышение квалификации'){
?>
	<ul class="dropdown-menu">
<?
  $arSelect_1 = Array('ID', 'NAME', 'SECTION_PAGE_URL', 'UF_MENU');
  $arFilter_1 = Array('IBLOCK_ID'=>7, 'GLOBAL_ACTIVE'=>'Y', 'SECTION_ID'=>5);
  $row1 = CIBlockSection::GetList(Array("NAME"=>"ASC"), $arFilter_1, false, $arSelect_1, Array("nPageSize"=>100));	
  while($mass_row1 = $row1->GetNext())
  {
  
  if ($mass_row1['UF_MENU']==2){continue;}
?>
			<li >
				<a href="<?=$mass_row1['SECTION_PAGE_URL']?>"><?=$mass_row1['NAME']?></a>			
			</li>

<?  	
	
  }
?>	
		</ul>
<?
}
		?>

		<?
if ($arItem['TEXT']=='Профессиональная переподготовка'){
?>
	<ul class="dropdown-menu">
<?
  $arSelect_1 = Array('ID', 'NAME', 'SECTION_PAGE_URL', 'UF_MENU');
  $arFilter_1 = Array('IBLOCK_ID'=>7, 'GLOBAL_ACTIVE'=>'Y', 'SECTION_ID'=>6);
  $row1 = CIBlockSection::GetList(Array("NAME"=>"ASC"), $arFilter_1, false, $arSelect_1, Array("nPageSize"=>100));	
  while($mass_row1 = $row1->GetNext())
  {
   if ($mass_row1['UF_MENU']==2){continue;}
?>
			<li >
				<a href="<?=$mass_row1['SECTION_PAGE_URL']?>"><?=$mass_row1['NAME']?></a>			
			</li>

<?  	
	
  }
?>	
		</ul>
<?
}
		?>

		<?
if ($arItem['TEXT']=='Дополнительное образование'){
?>
	<ul class="dropdown-menu">
<?
  $arSelect_1 = Array('ID', 'NAME', 'SECTION_PAGE_URL', 'UF_MENU');
  $arFilter_1 = Array('IBLOCK_ID'=>7, 'GLOBAL_ACTIVE'=>'Y', 'SECTION_ID'=>7);
  $row1 = CIBlockSection::GetList(Array("NAME"=>"ASC"), $arFilter_1, false, $arSelect_1, Array("nPageSize"=>100));	
  while($mass_row1 = $row1->GetNext())
  {
   if ($mass_row1['UF_MENU']==2){continue;}
?>
			<li >
				<a href="<?=$mass_row1['SECTION_PAGE_URL']?>"><?=$mass_row1['NAME']?></a>			
			</li>

<?  	
	
  }
?>	
		</ul>
<?
}
		?>

		<?
if ($arItem['TEXT']=='Профессиональное обучение'){
?>
	<ul class="dropdown-menu">
<?
  $arSelect_1 = Array('ID', 'NAME', 'SECTION_PAGE_URL', 'UF_MENU');
  $arFilter_1 = Array('IBLOCK_ID'=>7, 'GLOBAL_ACTIVE'=>'Y', 'SECTION_ID'=>8);
  $row1 = CIBlockSection::GetList(Array("NAME"=>"ASC"), $arFilter_1, false, $arSelect_1, Array("nPageSize"=>100));	
  while($mass_row1 = $row1->GetNext())
  {
   if ($mass_row1['UF_MENU']==2){continue;}
?>
			<li >
				<a href="<?=$mass_row1['SECTION_PAGE_URL']?>"><?=$mass_row1['NAME']?></a>			
			</li>

<?  	
	
  }
?>	
		</ul>
<?
}
		?>
	</li>
	<?endforeach;?>
</ul>