<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<div class="page-heading">
  <div class="page-icon">&#9889;</div>
  <div>
    <h1><?= htmlspecialchars($arResult['TITLE']) ?></h1>
    <p class="page-subtitle">Технологии и инструменты, с которыми я работаю</p>
  </div>
</div>

<div class="notion-divider"></div>

<div class="skill-cards" id="skillCards">
  <?php foreach ($arResult['GROUPS'] as $group):
    $slug = CUtil::translit($group['NAME'], 'ru', [
        'max_len'               => 100,
        'change_case'           => 'L',
        'replace_space'         => '-',
        'replace_other'         => '-',
        'delete_repeat_replace' => true,
    ]);
    $dotClass  = 'dot-' . htmlspecialchars($group['COLOR']);
    $isOutline = ($group['COLOR'] === 'light');
  ?>
    <div class="skill-card" data-category="<?= htmlspecialchars($slug) ?>">
      <div class="skill-card-header">
        <span class="skill-card-dot <?= $dotClass ?>"></span>
        <?= htmlspecialchars($group['NAME']) ?>
      </div>
      <div class="skill-tags">
        <?php foreach ($group['TAGS'] as $tag): ?>
          <span class="tag <?= $isOutline ? 'tag-outline' : '' ?>">
            <?= htmlspecialchars($tag) ?>
          </span>
        <?php endforeach; ?>
      </div>
    </div>
  <?php endforeach; ?>
</div>

<div class="filter-row" style="margin-top:28px;">
  <button class="chip active" data-filter="all">Все</button>
  <?php foreach ($arResult['GROUPS'] as $group):
    $slug = CUtil::translit($group['NAME'], 'ru', [
        'max_len'               => 100,
        'change_case'           => 'L',
        'replace_space'         => '-',
        'replace_other'         => '-',
        'delete_repeat_replace' => true,
    ]);
  ?>
    <button class="chip" data-filter="<?= htmlspecialchars($slug) ?>">
      <?= htmlspecialchars($group['NAME']) ?>
    </button>
  <?php endforeach; ?>
</div>

<script>
// Ванильный JS — не зависит от момента загрузки jQuery
document.addEventListener('DOMContentLoaded', function () {
  var chips = document.querySelectorAll('.filter-row .chip');
  var cards = document.querySelectorAll('#skillCards .skill-card');

  chips.forEach(function (chip) {
    chip.addEventListener('click', function () {
      var cat = this.dataset.filter;

      chips.forEach(function (c) { c.classList.remove('active'); });
      this.classList.add('active');

      cards.forEach(function (card) {
        if (cat === 'all' || card.dataset.category === cat) {
          card.style.display = '';
        } else {
          card.style.display = 'none';
        }
      });
    });
  });
});
</script>
