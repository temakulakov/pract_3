<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

// --- Значения из настроек сайта (модуль kulakov.main) ---
$headerTitle    = COption::GetOptionString('kulakov.main', 'HEADER_TITLE',    'Артем Кулаков');
$headerSubtitle = COption::GetOptionString('kulakov.main', 'HEADER_SUBTITLE', 'Пи2у/23Б');
$siteName       = COption::GetOptionString('kulakov.main', 'SITE_NAME',      'Артем Кулаков');

// --- Синхронизация заголовка страницы с пунктом меню ---
// Читаем файл .left.menu.php в корне сайта и ищем текущий URL.
// Если нашли — принудительно устанавливаем <title> и h1 равным названию пункта меню.
$menuFile = $_SERVER['DOCUMENT_ROOT'] . '/.left.menu.php';
if (file_exists($menuFile)) {
    $aMenuLinks = [];
    include $menuFile;

    $curPage = $APPLICATION->GetCurPage();
    foreach ($aMenuLinks as $link) {
        $url = $link[1];
        $isMatch = ($url === '/')
            ? ($curPage === '/' || $curPage === '/index.php')
            : (strpos($curPage, $url) === 0);
        if ($isMatch) {
            $APPLICATION->SetTitle($link[0]);
            $APPLICATION->SetPageProperty('title', $link[0] . ' — ' . $siteName);
            break;
        }
    }
}

// Аватар-инициалы — из первых букв заголовка
$avatarInitials = '';
$parts = preg_split('/\s+/', trim($headerTitle));
foreach ($parts as $p) {
    if ($p !== '') $avatarInitials .= mb_substr($p, 0, 1);
    if (mb_strlen($avatarInitials) >= 2) break;
}
$avatarInitials = mb_strtoupper($avatarInitials ?: 'АК');
?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?php $APPLICATION->ShowTitle(false); ?> — <?= htmlspecialcharsbx($siteName) ?></title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css" />
  <?= $APPLICATION->ShowHead() ?>
</head>
<body>

<?= $APPLICATION->ShowPanel() ?>

<canvas id="bgCanvas"></canvas>

<div class="layout">

  <aside class="sidebar" id="sidebar">
    <div class="sidebar-top">
      <div class="sidebar-avatar"><?= htmlspecialcharsbx($avatarInitials) ?></div>
      <div class="sidebar-meta">
        <span class="sidebar-name"><?= htmlspecialcharsbx($headerTitle) ?></span>
        <span class="sidebar-sub"><?= htmlspecialcharsbx($headerSubtitle) ?></span>
      </div>
    </div>

    <div class="sidebar-divider"></div>

    <nav>
      <?php
      // Меню из .left.menu.php — редактируется в режиме правки
      $APPLICATION->IncludeComponent(
          "bitrix:menu",
          "kulakov_left",
          [
              "ROOT_MENU_TYPE"    => "left",
              "MENU_CACHE_TYPE"   => "A",
              "MENU_CACHE_TIME"   => "3600",
              "MENU_CACHE_USE_GROUPS" => "Y",
              "MAX_LEVEL"         => "1",
              "CHILD_MENU_TYPE"   => "left",
              "USE_EXT"           => "N",
              "DELAY"             => "N",
              "ALLOW_MULTI_SELECT" => "N",
          ],
          false
      );
      ?>
    </nav>

    <div class="sidebar-divider"></div>

    <div class="sidebar-bottom">
      <a href="/about/" class="sidebar-ext-link">О сайте &#8599;</a>
    </div>
  </aside>

  <main class="main-content">
    <header class="mobile-header">
      <button class="burger" id="burgerBtn">&#9776;</button>
      <span class="mobile-title"><?= $APPLICATION->GetTitle() ?></span>
    </header>
    <div class="overlay" id="overlay"></div>
    <div class="page active visible">
