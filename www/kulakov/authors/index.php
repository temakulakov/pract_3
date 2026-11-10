<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Авторы");
?>
<div class="page-heading">
  <div class="page-icon">&#9997;</div>
  <div>
    <h1>Авторы</h1>
    <p class="page-subtitle">Справочник авторов статей</p>
  </div>
</div>

<div class="notion-divider"></div>

<?php
$APPLICATION->IncludeComponent(
	"bitrix:news",
	"kulakov",
	[
		"IBLOCK_TYPE" => "test",
		"IBLOCK_ID" => "10",
		"NEWS_COUNT" => "20",
		"SORT_BY1" => "NAME",
		"SORT_ORDER1" => "ASC",
		"SORT_BY2" => "ID",
		"SORT_ORDER2" => "ASC",
		"SEF_MODE" => "N",
		"VARIABLE_ALIASES" => ["SECTION_ID" => "SECTION_ID", "ELEMENT_ID" => "ELEMENT_ID"],
		"AJAX_MODE" => "N",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "3600",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"SET_TITLE" => "Y",
		"SET_BROWSER_TITLE" => "Y",
		"BROWSER_TITLE" => "BROWSER_TITLE",
		"SET_META_KEYWORDS" => "N",
		"SET_META_DESCRIPTION" => "N",
		"SET_LAST_MODIFIED" => "N",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"ADD_SECTIONS_CHAIN" => "N",
		"ADD_ELEMENT_CHAIN" => "N",
		"USE_PERMISSIONS" => "N",
		"DISPLAY_DATE" => "N",
		"DISPLAY_PICTURE" => "N",
		"DISPLAY_PREVIEW_TEXT" => "N",
		"USE_SEARCH" => "N",
		"USE_RSS" => "N",
		"USE_RATING" => "N",
		"USE_CATEGORIES" => "N",
		"USE_REVIEW" => "N",
		"USE_FILTER" => "N",
		"LIST_FIELD_CODE" => ["", ""],
		"LIST_PROPERTY_CODE" => ["BIRTHDATE", ""],
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"DISPLAY_NAME" => "Y",
		"META_KEYWORDS" => "-",
		"META_DESCRIPTION" => "-",
		"DETAIL_FIELD_CODE" => ["", ""],
		"DETAIL_PROPERTY_CODE" => ["BIRTHDATE", ""],
		"DETAIL_DISPLAY_TOP_PAGER" => "N",
		"DETAIL_DISPLAY_BOTTOM_PAGER" => "N",
		"PAGER_TEMPLATE" => ".default",
		"DISPLAY_TOP_PAGER" => "N",
		"DISPLAY_BOTTOM_PAGER" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"CHECK_DATES" => "Y",
		"SET_STATUS_404" => "Y",
		"SHOW_404" => "N",
	],
	false
);

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");
?>
