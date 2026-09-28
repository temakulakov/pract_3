<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");

$APPLICATION->IncludeComponent(
	"kulakov:personal.projects", 
	".default", 
	[
		"COMPONENT_TEMPLATE" => ".default",
		"IBLOCK_ID" => "5"
	],
	false
);

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
