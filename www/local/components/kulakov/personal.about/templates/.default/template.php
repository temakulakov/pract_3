<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<div class="page-heading">
  <div class="page-icon">&#128100;</div>
  <div>
    <h1><?= htmlspecialchars($arResult['TITLE']) ?></h1>
    <p class="page-subtitle"><?= htmlspecialchars($arResult['SUBTITLE']) ?></p>
  </div>
</div>

<div class="notion-divider"></div>

<div class="about-grid">
  <img src="<?= htmlspecialchars($arResult['AVATAR']) ?>"
       alt="Фото" class="avatar" />

  <div class="about-text">
    <?= $arResult['TEXT'] ?>

    <?php if (!empty($arResult['INTERESTS'])): ?>
      <ul class="notion-list">
        <?php foreach ($arResult['INTERESTS'] as $interest): ?>
          <li><?= htmlspecialchars($interest) ?></li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>
  </div>
</div>
