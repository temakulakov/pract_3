<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<?php if (!empty($arResult['ITEMS'])): ?>

<div class="notion-divider" style="margin: 32px 0 24px;"></div>

<h2 class="gallery-heading"><?= htmlspecialchars($arResult['TITLE']) ?></h2>

<div class="gallery-grid" style="--cols: <?= (int)$arResult['COLUMNS'] ?>;">
  <?php foreach ($arResult['ITEMS'] as $item): ?>
    <div class="gallery-item">
      <?php if ($item['URL']): ?>
        <a href="<?= htmlspecialchars($item['URL']) ?>" target="_blank" rel="noopener" class="gallery-link">
      <?php endif; ?>

      <?php if ($item['IMG']): ?>
        <img src="<?= htmlspecialchars($item['IMG']) ?>"
             alt="<?= htmlspecialchars($item['NAME']) ?>"
             class="gallery-img" />
      <?php else: ?>
        <div class="gallery-img gallery-placeholder">&#128247;</div>
      <?php endif; ?>

      <div class="gallery-caption">
        <span class="gallery-name"><?= htmlspecialchars($item['NAME']) ?></span>
        <?php if ($item['CAPTION']): ?>
          <span class="gallery-sub"><?= htmlspecialchars($item['CAPTION']) ?></span>
        <?php endif; ?>
      </div>

      <?php if ($item['URL']): ?>
        </a>
      <?php endif; ?>
    </div>
  <?php endforeach; ?>
</div>

<?php endif; ?>
