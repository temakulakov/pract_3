<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->IncludeComponent(
	"kulakov:personal.about", 
	".default", 
	[
		"COMPONENT_TEMPLATE" => ".default",
		"IBLOCK_ID" => "4",
		"ELEMENT_ID" => "317"
	],
	false
);
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");
?>
