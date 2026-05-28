<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?IncludeTemplateLangFile(__FILE__);?>
<!DOCTYPE html>
<html lang="ru">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" href="<?=SITE_TEMPLATE_PATH?>/favicon.png" type="image/x-icon">
<link rel="shortcut icon" href="<?=SITE_TEMPLATE_PATH?>/favicon.png" type="image/x-icon">
<title><?$APPLICATION->ShowTitle()?></title>
<?$APPLICATION->ShowHead();?> 

<?
$uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2);
$uri_mass = explode('/', $uri_parts[0]);

$flag_can=0;
if ($uri_mass['1']=='napravleniya-obucheniya'){
	CModule::IncludeModule('iblock');
	$count_mass=count($uri_mass);
	$pred=$count_mass-2;



		  $arSelect_2 = Array('ID', 'NAME', 'DETAIL_PAGE_URL');
		  $arFilter_2 = Array('IBLOCK_ID'=>7,'ACTIVE'=>'Y', 'CODE'=>$uri_mass[$pred]);
		  $row2 = CIBlockElement::GetList(Array("DATE"=>"DESC"), $arFilter_2, false, Array("nPageSize"=>1), $arSelect_2);	
		  while($mass_row2 = $row2->GetNext())
		  {


$flag_can=1;

echo '<link rel="canonical" href="'.$mass_row2['DETAIL_PAGE_URL'].'">';
		  }



}
?>

<?if ($flag_can==0){?>
	<link rel="canonical" href="<?=$APPLICATION->GetCurDir(); ?>">
<?}?>


<link href="<?=SITE_TEMPLATE_PATH?>/media-queries.css" rel="stylesheet" type="text/css">
<?
$asset = \Bitrix\Main\Page\Asset::getInstance();
$asset->addJs(SITE_TEMPLATE_PATH."/js/jquery.min.js");
$asset->addJs(SITE_TEMPLATE_PATH."/js/scripts.js");
$asset->addJs(SITE_TEMPLATE_PATH."/jquery.fancybox.min.js");
$asset->addJs(SITE_TEMPLATE_PATH."/js/owl.carousel.js");
$asset->addJs(SITE_TEMPLATE_PATH."/special.js");
$asset->addJs(SITE_TEMPLATE_PATH."/js/bootstrap.bundle.min.js");
$asset->addJs(SITE_TEMPLATE_PATH."/js/jquery.formstyler.min.js");
$asset->addCss(SITE_TEMPLATE_PATH."/jquery.fancybox.min.css");
$asset->addCss(SITE_TEMPLATE_PATH."/owl-carousel.css");
$asset->addCss(SITE_TEMPLATE_PATH."/special.css");
$asset->addCss(SITE_TEMPLATE_PATH."/css/fonts/font-awesome/css/font-awesome.min.css");
$asset->addCss(SITE_TEMPLATE_PATH."/mmenu.css");
?>
</head>
<body>
<div id="panel"><?$APPLICATION->ShowPanel();?></div>
<div class="Holder<?if ($GLOBALS["APPLICATION"]->GetCurPage() != "/"):?> Article<?endif;?>" id="layer">
    <div id="Blocks" class="layer_body">
    	<div class="SiteHolder">
			<div class="PanelMenu">
				<div class="Wrapper">
					<div class="Flex">
						<div class="Menu">
							<a href="#menu"><span></span></a>
						</div>
						<div class="Links">
							<div class="Mail">
								<a href="mailto:<?php include $_SERVER['DOCUMENT_ROOT']."/include/mail.php";?>"><span><?$APPLICATION->IncludeFile(
										SITE_DIR."include/mail.php",
											Array(),
											Array("MODE"=>"text")
										);
									?></span></a>
							</div>
							<div class="Tel">
								<a href="tel:<?php include $_SERVER['DOCUMENT_ROOT']."/include/phone.php";?>" onclick="ym(54496510, 'reachGoal', 'Phone'); return true;"><span><?$APPLICATION->IncludeFile(
									SITE_DIR."include/phone.php",
										Array(),
										Array("MODE"=>"text")
									);
								?></span></a>
							</div>
							<div class="Search"><span class="SearchPopup"><span></span></span></div>
						</div>
					</div>
				</div>
			</div>
			<div class="TopPanel">
				<div class="Wrapper">
					<div class="Flex">
						<div class="Special">
							<a href="#contrast" id="specialversion">Версия для слабовидящих</a>
						</div>
						<div class="Menu">
							<?$APPLICATION->IncludeComponent(
								"bitrix:menu", 
								"main-menu", 
								array(
									"ROOT_MENU_TYPE" => "top",
									"MAX_LEVEL" => "2",
									"CHILD_MENU_TYPE" => "left",
									"USE_EXT" => "Y",
									"MENU_CACHE_TYPE" => "A",
									"MENU_CACHE_TIME" => "86400",
									"MENU_CACHE_USE_GROUPS" => "N",
									"MENU_CACHE_GET_VARS" => array(
									),
									"COMPONENT_TEMPLATE" => "main-menu",
									"DELAY" => "N",
									"ALLOW_MULTI_SELECT" => "N"
								),
								false,
								array(
									"ACTIVE_COMPONENT" => "Y"
								)
							);?>
						</div>
					</div>
				</div>
			</div>
			<div class="Header">
				<div class="HeaderBlock">
					<div class="Wrapper">
						<div class="Flex">
							<div class="Logo"><a href="<?=SITE_DIR?>">
							<?if ($GLOBALS["APPLICATION"]->GetCurPage() == "/"):?>
							<img src="<?=SITE_TEMPLATE_PATH?>/images/logo.png" width="190" height="94" alt="Учебный центр дополнительного профессионального образования «Прогресс»" title="Учебный центр дополнительного профессионального образования «Прогресс»">
							<?else:?>
							<img src="<?=SITE_TEMPLATE_PATH?>/images/logo-cont.png" width="190" height="94" alt="Учебный центр дополнительного профессионального образования «Прогресс»" title="Учебный центр дополнительного профессионального образования «Прогресс»">
							<?endif;?>
							</a></div>
							<div class="Slogan">
								Центр обучения и подготовки специалистов
							</div>
							<div class="Search"><span class="SearchPopup"><span></span></span></div>
							<div class="Contacts">
								<?$APPLICATION->IncludeComponent(
									"bitrix:news.list", 
									"contact-header", 
									array(
										"DISPLAY_DATE" => "Y",
										"DISPLAY_NAME" => "Y",
										"DISPLAY_PICTURE" => "Y",
										"DISPLAY_PREVIEW_TEXT" => "Y",
										"AJAX_MODE" => "N",
										"IBLOCK_TYPE" => "info",
										"IBLOCK_ID" => "28",
										"NEWS_COUNT" => "1",
										"SORT_BY1" => "SORT",
										"SORT_ORDER1" => "ASC",
										"SORT_BY2" => "",
										"SORT_ORDER2" => "ASC",
										"FILTER_NAME" => "",
										"FIELD_CODE" => array(
											0 => "",
											1 => "",
										),
										"PROPERTY_CODE" => array(
											0 => "PHONE",
											1 => "GRAFIC",
											2 => "ADRESS",
											3 => "",
										),
										"CHECK_DATES" => "Y",
										"DETAIL_URL" => "",
										"PREVIEW_TRUNCATE_LEN" => "",
										"ACTIVE_DATE_FORMAT" => "d.m.Y",
										"SET_TITLE" => "N",
										"SET_BROWSER_TITLE" => "N",
										"SET_META_KEYWORDS" => "N",
										"SET_META_DESCRIPTION" => "N",
										"SET_LAST_MODIFIED" => "N",
										"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
										"ADD_SECTIONS_CHAIN" => "N",
										"HIDE_LINK_WHEN_NO_DETAIL" => "N",
										"PARENT_SECTION" => "",
										"PARENT_SECTION_CODE" => "",
										"INCLUDE_SUBSECTIONS" => "Y",
										"STRICT_SECTION_CHECK" => "N",
										"CACHE_TYPE" => "A",
										"CACHE_TIME" => "86400",
										"CACHE_FILTER" => "N",
										"CACHE_GROUPS" => "N",
										"PAGER_TEMPLATE" => ".default",
										"DISPLAY_TOP_PAGER" => "N",
										"DISPLAY_BOTTOM_PAGER" => "N",
										"PAGER_TITLE" => "Новости",
										"PAGER_SHOW_ALWAYS" => "N",
										"PAGER_DESC_NUMBERING" => "N",
										"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
										"PAGER_SHOW_ALL" => "N",
										"PAGER_BASE_LINK_ENABLE" => "N",
										"SET_STATUS_404" => "N",
										"SHOW_404" => "N",
										"MESSAGE_404" => "",
										"AJAX_OPTION_JUMP" => "N",
										"AJAX_OPTION_STYLE" => "Y",
										"AJAX_OPTION_HISTORY" => "N",
										"COMPONENT_TEMPLATE" => "contact-header",
										"AJAX_OPTION_ADDITIONAL" => ""
										),
									   $component, // Добавляем
									   array("HIDE_ICONS" => "N") // Добавляем
									);?>
							</div>
							<div class="Personal">
								<a href="http://learning.centr-progress.com" target="_blank" rel="nofollow"><span>Личный кабинет</span></a>
							</div>
						</div>
					</div>
				</div>
				<div class="MainMenu">
					<div class="Wrapper">
<?
//global $USER;
//if ($USER->IsAdmin()){
?>
						<?$APPLICATION->IncludeComponent(
								"bitrix:menu", 
								"link-menu-vpd", 
								array(
									"ROOT_MENU_TYPE" => "services",
									"MAX_LEVEL" => "1",
									"CHILD_MENU_TYPE" => "",
									"USE_EXT" => "Y",
									"MENU_CACHE_TYPE" => "A",
									"MENU_CACHE_TIME" => "86400",
									"MENU_CACHE_USE_GROUPS" => "N",
									"MENU_CACHE_GET_VARS" => array(
									),
									"COMPONENT_TEMPLATE" => "link-menu",
									"DELAY" => "N",
									"ALLOW_MULTI_SELECT" => "N"
								),
								false,
								array(
									"ACTIVE_COMPONENT" => "Y"
								)
							);?>
<?
/*
}
else{
?>


						<?$APPLICATION->IncludeComponent(
								"bitrix:menu", 
								"link-menu", 
								array(
									"ROOT_MENU_TYPE" => "services",
									"MAX_LEVEL" => "1",
									"CHILD_MENU_TYPE" => "",
									"USE_EXT" => "Y",
									"MENU_CACHE_TYPE" => "A",
									"MENU_CACHE_TIME" => "86400",
									"MENU_CACHE_USE_GROUPS" => "N",
									"MENU_CACHE_GET_VARS" => array(
									),
									"COMPONENT_TEMPLATE" => "link-menu",
									"DELAY" => "N",
									"ALLOW_MULTI_SELECT" => "N"
								),
								false,
								array(
									"ACTIVE_COMPONENT" => "Y"
								)
							);?>
<?
}
*/
?>


					</div>
				</div>
				<?$APPLICATION->IncludeComponent(
					"bitrix:main.include",
					"",
					Array(
						"AREA_FILE_RECURSIVE" => "N",
						"AREA_FILE_SHOW" => "page",
						"AREA_FILE_SUFFIX" => "inc",
						"EDIT_MODE" => "html",
						"EDIT_TEMPLATE" => "standard.php",
						"PATH" => SITE_DIR."index_inc.php"
					),
				false,
				Array(
					'HIDE_ICONS' => 'Y'
				)
				);?>
				<?if ($GLOBALS["APPLICATION"]->GetCurPage() != "/"):?>
				<div class="Conteiner<?if(CSite::InDir('/novosti/index.php')):?> Big<?elseif(CSite::InDir('/kontakty/')):?> Contacts<?endif;?>">
					<div class="Wrapper">
						<?$APPLICATION->IncludeComponent(
							"bitrix:breadcrumb", 
							"nav", 
							array(
								"START_FROM" => "1",
								"PATH" => "",
								"SITE_ID" => "s1",
								"COMPONENT_TEMPLATE" => "nav"
							),
							false
						);?>
						<?if(CSite::InDir('/napravleniya-obucheniya/index.php')):?><h1><?$APPLICATION->ShowTitle(true);?></h1><?endif;?>
						<?if(!CSite::InDir('/napravleniya-obucheniya/')):?><h1><?$APPLICATION->ShowTitle(true);?></h1><?endif;?>
						<?if(CSite::InDir('/novosti/index.php') || CSite::InDir('/kontakty/')):?>
						<?else:?>
						<?if(CSite::InDir('/napravleniya-obucheniya/index.php')):?>
						<div class="LeftBlock">
							<div class="LeftMenu">
							<?$APPLICATION->IncludeComponent(
								"bitrix:menu", 
								"left-menu", 
								array(
									"ROOT_MENU_TYPE" => "top",
									"MAX_LEVEL" => "2",
									"CHILD_MENU_TYPE" => "top-sub",
									"USE_EXT" => "Y",
									"MENU_CACHE_TYPE" => "A",
									"MENU_CACHE_TIME" => "86400",
									"MENU_CACHE_USE_GROUPS" => "N",
									"MENU_CACHE_GET_VARS" => array(
									),
									"COMPONENT_TEMPLATE" => "left-menu",
									"DELAY" => "N",
									"ALLOW_MULTI_SELECT" => "N"
								),
								false,
								array(
									"ACTIVE_COMPONENT" => "Y"
								)
							);?>
							</div>
						</div>
						<?elseif(CSite::InDir('/napravleniya-obucheniya/')):?>
						<div class="LeftBlock">
							<?$APPLICATION->ShowViewContent('category');?>
						</div>
						<?else:?>
						<div class="LeftBlock">
							<div class="LeftMenu">
							<?if(CSite::InDir('/tarify/')):?>
							<?$APPLICATION->IncludeComponent(
								"bitrix:menu", 
								"left-menu", 
								array(
									"ROOT_MENU_TYPE" => "left",
									"MAX_LEVEL" => "1",
									"CHILD_MENU_TYPE" => "",
									"USE_EXT" => "Y",
									"MENU_CACHE_TYPE" => "A",
									"MENU_CACHE_TIME" => "86400",
									"MENU_CACHE_USE_GROUPS" => "N",
									"MENU_CACHE_GET_VARS" => array(
									),
									"COMPONENT_TEMPLATE" => "left-menu",
									"DELAY" => "N",
									"ALLOW_MULTI_SELECT" => "N"
								),
								false,
								array(
									"ACTIVE_COMPONENT" => "Y"
								)
							);?>
							<?else:?>
							<?$APPLICATION->IncludeComponent(
								"bitrix:menu", 
								"left-menu", 
								array(
									"ROOT_MENU_TYPE" => "top",
									"MAX_LEVEL" => "2",
									"CHILD_MENU_TYPE" => "top-sub",
									"USE_EXT" => "Y",
									"MENU_CACHE_TYPE" => "A",
									"MENU_CACHE_TIME" => "86400",
									"MENU_CACHE_USE_GROUPS" => "N",
									"MENU_CACHE_GET_VARS" => array(
									),
									"COMPONENT_TEMPLATE" => "left-menu",
									"DELAY" => "N",
									"ALLOW_MULTI_SELECT" => "N"
								),
								false,
								array(
									"ACTIVE_COMPONENT" => "Y"
								)
							);?>
							<?endif;?>
							</div>
						</div>
						<?endif;?>
						<?endif;?>
						<?if(!CSite::InDir('/napravleniya-obucheniya/')):?>
						<div class="ContBlock Big">
							<div class="Content"> 
						<?else:?>
						
						<?endif;?>
				<?endif;?>