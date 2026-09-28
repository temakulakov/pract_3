<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/urlrewrite.php');

CHTTP::SetStatus("404 Not Found");
@define("ERROR_404", "Y");

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");

$APPLICATION->SetTitle("Страница не найдена");
$APPLICATION->SetPageProperty("title", "Страница не найдена");

$aMenuLinks = [];
include $_SERVER["DOCUMENT_ROOT"] . "/.left.menu.php";
$aMenuLinks[] = ["О сайте", "/about/"];
?>

<div class="page-heading">
  <div class="page-icon">&#128269;</div>
  <div>
    <h1>Страница не найдена</h1>
    <p class="page-subtitle">Ошибка 404 — такой страницы на сайте нет</p>
  </div>
</div>

<div class="notion-divider"></div>

<p>Возможно, ссылка устарела или в адресе опечатка. Разделы сайта:</p>

<ul class="notion-list">
  <?php foreach ($aMenuLinks as $link): ?>
    <li><a href="<?= htmlspecialcharsbx($link[1]) ?>"><?= htmlspecialcharsbx($link[0]) ?></a></li>
  <?php endforeach; ?>
</ul>

<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
