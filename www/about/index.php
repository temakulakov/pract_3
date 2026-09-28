<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("О сайте");

$APPLICATION->IncludeComponent(
	"kulakov:site.about", 
	".default", 
	[
		"COMPONENT_TEMPLATE" => ".default",
		"IBLOCK_ID" => "8",
		"ELEMENT_ID" => "18"
	],
	false
);

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");
?>
