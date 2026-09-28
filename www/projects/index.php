<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
// Заголовок устанавливается автоматически из пункта меню (.left.menu.php)

// Список проектов — инфоблок 5
$APPLICATION->IncludeComponent(
	"kulakov:personal.projects", 
	".default", 
	[
		"COMPONENT_TEMPLATE" => ".default",
		"IBLOCK_ID" => "5"
	],
	false
);

// Галерея — инфоблок 6
$APPLICATION->IncludeComponent(
    "kulakov:personal.gallery",
    ".default",
    [
        "COMPONENT_TEMPLATE" => ".default",
        "IBLOCK_ID" => "6",
        "TITLE"     => "Галерея проектов",
        "COLUMNS"   => "3",
    ],
    false
);

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");
?>
