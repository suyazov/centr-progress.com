<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$eventManager = \Bitrix\Main\EventManager::getInstance();

// удяляем скрипты ядра при отдаче сайта пользователям
$eventManager->addEventHandler("main", "OnEndBufferContent", "deleteKernelJs");

// удяляем css ядра при отдаче сайта пользователям
$eventManager->addEventHandler("main", "OnEndBufferContent", "deleteKernelCss");
