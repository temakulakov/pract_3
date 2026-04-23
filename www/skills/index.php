<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
// Заголовок устанавливается автоматически из пункта меню (.left.menu.php)

$APPLICATION->IncludeComponent(
	"kulakov:personal.skills", 
	".default", 
	[
		"TITLE" => "Навыки",
		"COMPONENT_TEMPLATE" => ".default",
		"IBLOCK_ID" => "16"
	],
	false
);

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");
?>
