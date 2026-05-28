<? include_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/urlrewrite.php');

CHTTP::SetStatus("404 Not Found");
@define("ERROR_404","Y");

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$APPLICATION->SetTitle("404 ошибка - Страница не найдена"); ?>
				<div class="Wrapper">
					<div class="ErrorText">
						<h1>Ошибка 404</h1>
						<div class="Text">К сожалению, такой страницы не существует, либо она была удалена.</div>
						<?$APPLICATION->IncludeComponent(
							"bitrix:menu", 
							"main-menu", 
							array(
								"ROOT_MENU_TYPE" => "top",
								"MAX_LEVEL" => "1",
								"CHILD_MENU_TYPE" => "left",
								"USE_EXT" => "Y",
								"MENU_CACHE_TYPE" => "A",
								"MENU_CACHE_TIME" => "36000000",
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
						<div class="HomeLink">
							<a href="<?=SITE_DIR?>"><span>Главная страница</span></a>
						</div>
					</div>
				</div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?> 