<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
  IncludeTemplateLangFile(__FILE__);
  if(defined("ERROR_404") && ERROR_404 == "Y" && $APPLICATION->GetCurPage(true) !='/404.php')  LocalRedirect('/404.php'); 
?>	
			<?if ($GLOBALS["APPLICATION"]->GetCurPage() != "/"):?>
					<?if(!CSite::InDir('/napravleniya-obucheniya/')):?>
						</div>
					</div>
					<?endif;?>
					<?if(CSite::InDir('/kontakty/')):?>
					<?else:?>
						<?if(!CSite::InDir('/napravleniya-obucheniya/index.php')):?>
						<div class="RightBlock">
							<?$APPLICATION->ShowViewContent('icon');?>
							<?$APPLICATION->ShowViewContent('filter');?>
							<?$APPLICATION->ShowViewContent('cost');?>
						</div>
						<?endif;?>
					<?endif;?>
					<div class="Clear"></div>
				</div>
			</div>
			<?$APPLICATION->ShowViewContent('description');?>
			<?endif;?>
		</div>
    </div>
    <div class="Footer">
		<div class="Wrapper">
			<div class="Flex">
				<div class="CopyBlock">
					<div class="Copy">© 2012-<?echo date("Y")?>, Учебный центр дополнительного профессионального образования «Прогресс»</div>
					<div class="Social">
						<span>Мы в социальных сетях</span>
							<?$APPLICATION->IncludeComponent(
								"bitrix:menu", 
								"social", 
								array(
									"ROOT_MENU_TYPE" => "social",
									"MAX_LEVEL" => "1",
									"CHILD_MENU_TYPE" => "",
									"USE_EXT" => "Y",
									"MENU_CACHE_TYPE" => "A",
									"MENU_CACHE_TIME" => "84600",
									"MENU_CACHE_USE_GROUPS" => "N",
									"MENU_CACHE_GET_VARS" => array(
									),
									"COMPONENT_TEMPLATE" => "social",
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
				<div class="MenuBlock">
					<div class="Flex">
						<div class="Menu">
							<?$APPLICATION->IncludeComponent(
								"bitrix:menu", 
								"footer-menu", 
								array(
									"ROOT_MENU_TYPE" => "footer",
									"MAX_LEVEL" => "1",
									"CHILD_MENU_TYPE" => "",
									"USE_EXT" => "Y",
									"MENU_CACHE_TYPE" => "A",
									"MENU_CACHE_TIME" => "86400",
									"MENU_CACHE_USE_GROUPS" => "N",
									"MENU_CACHE_GET_VARS" => array(
									),
									"COMPONENT_TEMPLATE" => "footer-menu",
									"DELAY" => "N",
									"ALLOW_MULTI_SELECT" => "N"
								),
								false,
								array(
									"ACTIVE_COMPONENT" => "Y"
								)
							);?>
						</div>
						<div class="Menu">
							<?$APPLICATION->IncludeComponent(
								"bitrix:menu", 
								"footer-menu", 
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
									"COMPONENT_TEMPLATE" => "footer-menu",
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
				<div class="Contacts">
					<div class="Tel">
						<a href="tel:<?php include $_SERVER['DOCUMENT_ROOT']."/include/phone.php";?>">
						<?$APPLICATION->IncludeFile(
								SITE_DIR."include/phone.php",
									Array(),
									Array("MODE"=>"text")
								);
							?>
						</a>
					</div>
					<div class="Mail">
						<a href="mailto:<?php include $_SERVER['DOCUMENT_ROOT']."/include/mail.php";?>">
							<?$APPLICATION->IncludeFile(
								SITE_DIR."include/mail.php",
									Array(),
									Array("MODE"=>"text")
								);
							?>
						</a>
					</div>
				</div>
			</div>
		</div>
    </div>
</div>
</div>
						<div style="display: none;" id="hidden-content">
						<div class="Forms Popup">
							<div class="Title">Заявка на обучение</div>
								<div class="PopupBlock">
							<?$APPLICATION->IncludeComponent(
								"bitrix:iblock.element.add.form", 
								"popup-form", 
								array(
									"COMPONENT_TEMPLATE" => "popup-form",
									"CUSTOM_TITLE_DATE_ACTIVE_FROM" => "",
									"CUSTOM_TITLE_DATE_ACTIVE_TO" => "",
									"CUSTOM_TITLE_DETAIL_PICTURE" => "",
									"CUSTOM_TITLE_DETAIL_TEXT" => "",
									"CUSTOM_TITLE_IBLOCK_SECTION" => "",
									"CUSTOM_TITLE_NAME" => "Ваше имя",
									"CUSTOM_TITLE_PREVIEW_PICTURE" => "",
									"CUSTOM_TITLE_PREVIEW_TEXT" => "",
									"CUSTOM_TITLE_TAGS" => "",
									"DEFAULT_INPUT_SIZE" => "30",
									"DETAIL_TEXT_USE_HTML_EDITOR" => "N",
									"ELEMENT_ASSOC" => "CREATED_BY",
									"GROUPS" => array(
										0 => "1",
										1 => "2",
									),
									"IBLOCK_ID" => "19",
									"IBLOCK_TYPE" => "forms",
									"LEVEL_LAST" => "Y",
									"LIST_URL" => "",
									"AJAX_MODE" => "Y",  
									"AJAX_OPTION_SHADOW" => "N",
									"AJAX_OPTION_JUMP" => "N",
									"AJAX_OPTION_STYLE" => "Y",
									"AJAX_OPTION_HISTORY" => "N",
									"USER_CONSENT" => "Y",
									"USER_CONSENT_ID" => "1",
									"USER_CONSENT_IS_CHECKED" => "Y",
									"USER_CONSENT_IS_LOADED" => "N",
									"MAX_FILE_SIZE" => "0",
									"MAX_LEVELS" => "100000",
									"MAX_USER_ENTRIES" => "100000",
									"PREVIEW_TEXT_USE_HTML_EDITOR" => "N",
									"PROPERTY_CODES" => array(
										0 => "NAME",
										1 => "43",
										2 => "47",
									),
									"PROPERTY_CODES_REQUIRED" => array(
										0 => "NAME",
										1 => "43",
										2 => "47",
									),
									"RESIZE_IMAGES" => "N",
									"SEF_MODE" => "N",
									"STATUS" => "ANY",
									"STATUS_NEW" => "N",
									"USER_MESSAGE_EDIT" => "",
									"USER_MESSAGE_ADD" => "Спасибо, ваша заявка принята.",
									"USE_CAPTCHA" => "N"
								),
								false
							);?>
						</div>
					</div>
				</div>
				
				<?$APPLICATION->IncludeComponent(
					"bitrix:menu", 
					"panel-menu", 
					array(
						"ROOT_MENU_TYPE" => "mobile",
						"MAX_LEVEL" => "2",
						"CHILD_MENU_TYPE" => "sub",
						"USE_EXT" => "Y",
						"MENU_CACHE_TYPE" => "A",
						"MENU_CACHE_TIME" => "86400",
						"MENU_CACHE_USE_GROUPS" => "N",
						"MENU_CACHE_GET_VARS" => array(
						),
						"COMPONENT_TEMPLATE" => "panel-menu",
						"DELAY" => "N",
						"ALLOW_MULTI_SELECT" => "N"
					),
					false,
					array(
						"ACTIVE_COMPONENT" => "Y"
					)
				);?>
				<div class="PopupSearch CloseSearch" role="dialog" aria-modal="false" aria-label="Поиск" aria-hidden="true">
					<div class="Search">
								<?php
								require_once $_SERVER['DOCUMENT_ROOT'] . '/local/lib/CentrProgress/Search/PrefixQuery.php';
								\CentrProgress\Search\PrefixQuery::applyToRequest();
								$APPLICATION->IncludeComponent(
									"bitrix:search.title",
									"search",
									Array(
										"SHOW_INPUT" => "Y",
										"INPUT_ID" => "title-search-input",
										"CONTAINER_ID" => "title-search",
										"PRICE_CODE" => array(),
										"PRICE_VAT_INCLUDE" => "Y",
										"PREVIEW_TRUNCATE_LEN" => "",
										"SHOW_PREVIEW" => "Y",
										"PREVIEW_WIDTH" => "75",
										"PREVIEW_HEIGHT" => "75",
										"PAGE" => "#SITE_DIR#search/index.php",
										"NUM_CATEGORIES" => "1",
										// Fetch enough candidates for deterministic name ranking;
										// result_modifier.php limits the rendered suggestions to five.
										"TOP_COUNT" => "50",
										"ORDER" => "date",
										"USE_LANGUAGE_GUESS" => "Y",
										"CHECK_DATES" => "N",
										"SHOW_OTHERS" => "N",
										"CATEGORY_0_TITLE" => "",
										"CATEGORY_0" => array("iblock_infosection"),
										"CATEGORY_0_iblock_infosection" => array("7"),
										"COMPOSITE_FRAME_MODE" => "A",
										"COMPOSITE_FRAME_TYPE" => "AUTO"
									),
								false
								);?>
						<span class="SearchClose"><span></span></span>
					</div>
				</div>
				<!-- Yandex.Metrika counter -->
				<script type="text/javascript" >
					setTimeout(() => {
					   (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
					   m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
					   (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

					   ym(54496510, "init", {
							clickmap:true,
							trackLinks:true,
							accurateTrackBounce:true,
							webvisor:true
					   });
				   }, 3000)
				</script>
				<noscript><div><img src="https://mc.yandex.ru/watch/54496510" style="position:absolute; left:-9999px;" title="Yandex.Metrika" alt="Yandex.Metrika"></div></noscript>
				<!-- /Yandex.Metrika counter -->
<div data-marquiz-id="60bf33a35ffebe003e8a5c65"></div>
<script>(function(t, p) {window.Marquiz ? Marquiz.add([t, p]) : document.addEventListener('marquizLoaded', function() {Marquiz.add([t, p])})})('Button', {id: '60bf33a35ffebe003e8a5c65', buttonText: 'Получить скидку', bgColor: '#f9030f', textColor: '#fff', rounded: true, shadow: '', blicked: true})</script>
<!-- Marquiz script start -->
<script>
(function(w, d, s, o){
  var j = d.createElement(s); j.async = true; j.src = '//script.marquiz.ru/v2.js';j.onload = function() {
    if (document.readyState !== 'loading') Marquiz.init(o);
    else document.addEventListener("DOMContentLoaded", function() {
      Marquiz.init(o);
    });
  };
  d.head.insertBefore(j, d.head.firstElementChild);
})(window, document, 'script', {
    host: '//quiz.marquiz.ru',
    region: 'eu',
    id: '60bf33a35ffebe003e8a5c65',
    autoOpen: false,
    autoOpenFreq: 'once',
    openOnExit: false,
    disableOnMobile: false
  }
);
</script>
<!-- Marquiz script end -->
<script type="text/javascript">!function(){var t=document.createElement("script");t.type="text/javascript",t.async=!0,t.src='https://vk.com/js/api/openapi.js?169',t.onload=function(){VK.Retargeting.Init("VK-RTRG-1436230-1UEdl"),VK.Retargeting.Hit()},document.head.appendChild(t)}();</script><noscript><img src="https://vk.com/rtrg?p=VK-RTRG-1436230-1UEdl" style="position:fixed; left:-999px;" alt="vk.com" title="vk.com"></noscript>
<?$APPLICATION->IncludeComponent(
	"bitrix:main.include",
	"",
	Array(
		"AREA_FILE_SHOW" => "file",
		"PATH" => SITE_DIR."special_panel.php",
		"EDIT_TEMPLATE" => "",
		"HIDE_ICONS"=>"Y"
	)
);?> 
<script src="//code.jivo.ru/widget/p9xd3hjfMB" async></script>

<?
use \Bitrix\Main\Page\Asset;?>

<?Asset::getInstance()->addCss( SITE_TEMPLATE_PATH . '/js/swiper.min.css' );?>
<?Asset::getInstance()->addJs( SITE_TEMPLATE_PATH . '/js/swiper.min.js');?>
<?Asset::getInstance()->addJs( SITE_TEMPLATE_PATH . '/js/new.js');?>
<?Asset::getInstance()->addJs( SITE_TEMPLATE_PATH . '/js/jquery.fancybox.min.js');?>
<?Asset::getInstance()->addCss( SITE_TEMPLATE_PATH . '/js/jquery.fancybox.min.css' );?>
 <script>
jQuery(function($){
  $('.inp_tel').mask('+7 (999) 999-99-99');
 
});
</script>
</body>
</html>
