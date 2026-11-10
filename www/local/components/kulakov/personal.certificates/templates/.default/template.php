<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<div class="page-heading">
  <div class="page-icon">&#127891;</div>
  <div>
    <h1><?= htmlspecialcharsbx($arResult['TITLE']) ?></h1>
    <?php if ($arResult['INTRO']): ?>
      <p class="page-subtitle"><?= htmlspecialcharsbx($arResult['INTRO']) ?></p>
    <?php endif; ?>
  </div>
</div>

<div class="notion-divider"></div>

<?php if (empty($arResult['ITEMS'])): ?>
  <p>Сертификатов пока нет.</p>
<?php return; endif; ?>

<div class="cert-grid">
  <?php foreach ($arResult['ITEMS'] as $i => $item): ?>
    <div class="cert-card">
      <button type="button" class="cert-thumb" data-index="<?= $i ?>"
              data-img="<?= htmlspecialcharsbx($item['IMG']) ?>"
              data-file="<?= htmlspecialcharsbx($item['FILE']) ?>"
              data-name="<?= htmlspecialcharsbx($item['NAME']) ?>">
        <img src="<?= htmlspecialcharsbx($item['IMG']) ?>" alt="<?= htmlspecialcharsbx($item['NAME']) ?>" loading="lazy" />
      </button>
      <div class="cert-info">
        <span class="cert-name"><?= htmlspecialcharsbx($item['NAME']) ?></span>
        <?php if ($item['DATE']): ?>
          <span class="cert-meta"><?= htmlspecialcharsbx($item['DATE']) ?></span>
        <?php endif; ?>
        <?php if ($item['NUMBER']): ?>
          <span class="cert-meta"><?= htmlspecialcharsbx($item['NUMBER']) ?></span>
        <?php endif; ?>
        <?php if ($item['FILE']): ?>
          <a class="cert-download" href="<?= htmlspecialcharsbx($item['FILE']) ?>"
             download="<?= htmlspecialcharsbx($item['NAME']) ?>.pdf">Скачать PDF</a>
        <?php endif; ?>
      </div>
    </div>
  <?php endforeach; ?>
</div>

<div class="cert-viewer" id="certViewer" aria-hidden="true">
  <div class="cert-viewer-bar">
    <span class="cert-viewer-name" id="certViewerName"></span>
    <a class="cert-viewer-btn" id="certViewerPdf" href="#" download>Скачать PDF</a>
    <a class="cert-viewer-btn" id="certViewerImg" href="#" download>Скачать изображение</a>
    <button type="button" class="cert-viewer-btn" id="certViewerClose">Закрыть &times;</button>
  </div>
  <button type="button" class="cert-viewer-nav prev" id="certPrev">&#8249;</button>
  <img class="cert-viewer-img" id="certViewerImgTag" src="" alt="" />
  <button type="button" class="cert-viewer-nav next" id="certNext">&#8250;</button>
</div>
