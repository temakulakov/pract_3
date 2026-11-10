<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<?php if (empty($arResult["ITEMS"])): ?>
  <p>Пока ничего нет.</p>
<?php return; endif; ?>

<?php
$sections = [];
$rs = CIBlockSection::GetList(['SORT' => 'ASC'], ['IBLOCK_ID' => $arParams['IBLOCK_ID']], false, ['ID', 'NAME']);
while ($s = $rs->Fetch()) $sections[$s['ID']] = $s['NAME'];
$current = null;
?>

<div class="news-items">
<?php foreach ($arResult["ITEMS"] as $arItem):
    $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
    $sid = $arItem['IBLOCK_SECTION_ID'];
    if ($sid && $sid !== $current && isset($sections[$sid])):
        $current = $sid; ?>
    <h2 class="news-section"><?= htmlspecialcharsbx($sections[$sid]) ?></h2>
<?php endif; ?>
  <div class="news-card" id="<?= $this->GetEditAreaId($arItem['ID']) ?>">
    <?php if ($arParams["DISPLAY_PICTURE"] != "N" && is_array($arItem["PREVIEW_PICTURE"])): ?>
      <a href="<?= $arItem["DETAIL_PAGE_URL"] ?>" class="news-thumb">
        <img src="<?= $arItem["PREVIEW_PICTURE"]["SRC"] ?>" alt="<?= htmlspecialcharsbx($arItem["NAME"]) ?>" />
      </a>
    <?php endif; ?>
    <div class="news-body">
      <a href="<?= $arItem["DETAIL_PAGE_URL"] ?>" class="news-title"><?= $arItem["NAME"] ?></a>
      <?php if ($arParams["DISPLAY_PREVIEW_TEXT"] != "N" && $arItem["PREVIEW_TEXT"]): ?>
        <p><?= $arItem["PREVIEW_TEXT"] ?></p>
      <?php endif; ?>
      <?php foreach ($arItem["DISPLAY_PROPERTIES"] as $prop): ?>
        <div class="news-prop">
          <span><?= $prop["NAME"] ?>:</span>
          <?= is_array($prop["DISPLAY_VALUE"]) ? implode(', ', $prop["DISPLAY_VALUE"]) : $prop["DISPLAY_VALUE"] ?>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
<?php endforeach; ?>
</div>
