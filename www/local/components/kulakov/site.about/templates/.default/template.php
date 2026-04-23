<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<div class="page-heading">
  <div class="page-icon">&#128196;</div>
  <div>
    <h1><?= htmlspecialchars($arResult['TITLE']) ?></h1>
    <p class="page-subtitle"><?= htmlspecialchars($arResult['SUBTITLE']) ?></p>
  </div>
</div>

<div class="notion-divider"></div>

<h2>Цель работы</h2>
<?= $arResult['GOAL'] ?>

<?php if (!empty($arResult['TECH'])): ?>
  <h2 style="margin-top:24px;">Технологии</h2>
  <ul class="notion-list">
    <?php foreach ($arResult['TECH'] as $tech): ?>
      <li><?= htmlspecialchars($tech) ?></li>
    <?php endforeach; ?>
  </ul>
<?php endif; ?>

<?php if (!empty($arResult['AUTHOR'])): ?>
  <h2 style="margin-top:24px;">Автор</h2>
  <p><?= htmlspecialchars($arResult['AUTHOR']) ?>, <?= date('Y') ?></p>
<?php endif; ?>
