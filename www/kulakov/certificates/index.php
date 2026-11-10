<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Сертификаты");

$APPLICATION->IncludeComponent(
	"kulakov:personal.certificates",
	".default",
	[
		"COMPONENT_TEMPLATE" => ".default",
		"IBLOCK_ID" => "12",
		"TITLE" => "Сертификаты",
		"INTRO" => "Курсы 1С-Битрикс, пройденные на dev.1c-bitrix.ru. Нажмите на сертификат, чтобы открыть его на весь экран"
	],
	false
);

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");
?>
