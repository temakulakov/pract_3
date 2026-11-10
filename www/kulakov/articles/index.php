<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Статьи");
?>
<div class="page-heading">
  <div class="page-icon">&#128240;</div>
  <div>
    <h1>Статьи</h1>
    <p class="page-subtitle">Каталог статей о 1С-Битрикс: Управление сайтом</p>
  </div>
</div>

<div class="notion-divider"></div>

<p>
  Этот абзац — статическая информация: он записан прямо в файле страницы и редактируется
  в визуальном редакторе. Список статей ниже выводится динамически — компонентом
  «Новости» (bitrix:news) из инфоблока «Статьи» типа «Тестовый».
</p>

<hr class="notion-hr" />

<?php
$APPLICATION->IncludeComponent(
	"bitrix:news",
	"kulakov",
	[
		"IBLOCK_TYPE" => "test",
		"IBLOCK_ID" => "11",
		"NEWS_COUNT" => "10",
		"SORT_BY1" => "SORT",
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
		"SET_META_KEYWORDS" => "Y",
		"META_KEYWORDS" => "KEY_WORDS",
		"SET_META_DESCRIPTION" => "N",
		"SET_LAST_MODIFIED" => "N",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"ADD_SECTIONS_CHAIN" => "N",
		"ADD_ELEMENT_CHAIN" => "N",
		"USE_PERMISSIONS" => "N",
		"DISPLAY_DATE" => "N",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"USE_SEARCH" => "N",
		"USE_RSS" => "N",
		"USE_RATING" => "N",
		"USE_CATEGORIES" => "N",
		"USE_REVIEW" => "N",
		"USE_FILTER" => "N",
		"PREVIEW_TRUNCATE_LEN" => "",
		"LIST_ACTIVE_DATE_FORMAT" => "d.m.Y",
		"LIST_FIELD_CODE" => ["", ""],
		"LIST_PROPERTY_CODE" => ["YEAR", "AUTHORS", ""],
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"DISPLAY_NAME" => "Y",
		"META_DESCRIPTION" => "-",
		"DETAIL_ACTIVE_DATE_FORMAT" => "d.m.Y",
		"DETAIL_FIELD_CODE" => ["", ""],
		"DETAIL_PROPERTY_CODE" => ["YEAR", "AUTHORS", "MORE_PHOTO", "KEY_WORDS", ""],
		"DETAIL_DISPLAY_TOP_PAGER" => "N",
		"DETAIL_DISPLAY_BOTTOM_PAGER" => "N",
		"DETAIL_PAGER_TITLE" => "Страница",
		"DETAIL_PAGER_TEMPLATE" => "",
		"DETAIL_PAGER_SHOW_ALL" => "N",
		"PAGER_TEMPLATE" => ".default",
		"DISPLAY_TOP_PAGER" => "N",
		"DISPLAY_BOTTOM_PAGER" => "N",
		"PAGER_TITLE" => "Статьи",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_SHOW_ALL" => "N",
		"CHECK_DATES" => "Y",
		"SET_STATUS_404" => "Y",
		"SHOW_404" => "N",
	],
	false
);

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");
?>
