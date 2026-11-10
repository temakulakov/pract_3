<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");

$APPLICATION->IncludeComponent(
	"kulakov:personal.skills", 
	".default", 
	[
		"TITLE" => "Навыки",
		"COMPONENT_TEMPLATE" => ".default",
		"IBLOCK_ID" => "5"
	],
	false
);

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");
?>
