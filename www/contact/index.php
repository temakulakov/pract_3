<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
// Заголовок устанавливается автоматически из пункта меню (.left.menu.php)

// 1. Блок соцсетей — настраивается через шестерёнку (выбрать IBLOCK_ID)
$APPLICATION->IncludeComponent(
	"kulakov:personal.socials", 
	".default", 
	[
		"COMPONENT_TEMPLATE" => ".default",
		"TITLE" => "Социальные сети",
		"IBLOCK_ID" => "19"
	],
	false
);

// 2. Форма обратной связи
$APPLICATION->IncludeComponent(
	"kulakov:personal.contact", 
	".default", 
	[
		"COMPONENT_TEMPLATE" => ".default",
		"TITLE" => "Контакт",
		"INTRO" => "Напишите мне — отвечу в ближайшее время",
		"SUBMIT_TEXT" => "Отправить",
		"SUCCESS_TEXT" => "Сообщение отправлено. Свяжусь с вами в ближайшее время.",
		"LOG_IBLOCK_ID" => "",
		"EVENT_TYPE" => "",
		"EMAIL_TO" => "bitrix@temakulakov.ru"
	],
	false
);

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");
?>
