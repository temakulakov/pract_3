<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<?php if (!empty($arResult['ITEMS'])): ?>

<div class="socials-block">
  <?php if ($arResult['TITLE']): ?>
    <h2 class="socials-heading"><?= htmlspecialchars($arResult['TITLE']) ?></h2>
  <?php endif; ?>

  <div class="socials-list">
    <?php foreach ($arResult['ITEMS'] as $item): ?>
      <a href="<?= htmlspecialchars($item['URL'] ?: '#') ?>"
         class="social-card"
         target="_blank"
         rel="noopener"
         title="<?= htmlspecialchars($item['NAME']) ?>">

        <?php if ($item['ICON']): ?>
          <img src="<?= htmlspecialchars($item['ICON']) ?>"
               alt="<?= htmlspecialchars($item['NAME']) ?>"
               class="social-icon" />
        <?php else: ?>
          <span class="social-icon social-icon-fallback">&#128279;</span>
        <?php endif; ?>

        <span class="social-name"><?= htmlspecialchars($item['NAME']) ?></span>
      </a>
    <?php endforeach; ?>
  </div>
</div>

<?php endif; ?>
