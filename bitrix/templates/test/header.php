<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?IncludeTemplateLangFile(__FILE__);?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?$APPLICATION->ShowHead();?>  
	<link rel="icon" href="<?=SITE_TEMPLATE_PATH?>/favicon.png" type="image/x-icon">
	<link rel="shortcut icon" href="<?=SITE_TEMPLATE_PATH?>/favicon.png" type="image/x-icon">
	<title><?$APPLICATION->ShowTitle()?></title>
</head>
<body>
<div id="panel"><?$APPLICATION->ShowPanel();?></div>