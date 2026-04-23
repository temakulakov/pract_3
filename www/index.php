<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
// Заголовок устанавливается автоматически из пункта меню (.left.menu.php)
$APPLICATION->IncludeComponent(
	"kulakov:personal.about", 
	".default", 
	[
		"COMPONENT_TEMPLATE" => ".default",
		"IBLOCK_ID" => "15",
		"ELEMENT_ID" => "102"
	],
	false
);
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");
?>
