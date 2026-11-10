<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<div class="news-detail">
  <h2><?= $arResult["NAME"] ?></h2>

  <?php foreach ($arResult["DISPLAY_PROPERTIES"] as $code => $prop):
      if ($prop["PROPERTY_TYPE"] === "F") continue; ?>
    <div class="news-prop">
      <span><?= $prop["NAME"] ?>:</span>
      <?= is_array($prop["DISPLAY_VALUE"]) ? implode(', ', $prop["DISPLAY_VALUE"]) : $prop["DISPLAY_VALUE"] ?>
    </div>
  <?php endforeach; ?>

  <div class="news-text">
    <?= $arResult["DETAIL_TEXT"] ?: $arResult["PREVIEW_TEXT"] ?>
  </div>

  <?php
  $photos = $arResult["DISPLAY_PROPERTIES"]["MORE_PHOTO"]["FILE_VALUE"] ?? [];
  if (isset($photos["SRC"])) $photos = [$photos];
  if ($photos): ?>
    <div class="news-photos">
      <?php foreach ($photos as $ph): ?>
        <img src="<?= $ph["SRC"] ?>" alt="" />
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</div>
