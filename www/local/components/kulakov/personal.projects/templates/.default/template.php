<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<div class="page-heading">
  <div class="page-icon">&#128193;</div>
  <div>
    <h1><?= htmlspecialchars($arResult['TITLE']) ?></h1>
    <p class="page-subtitle">Учебные и личные работы</p>
  </div>
</div>

<div class="notion-divider"></div>

<!-- Фильтр -->
<div class="filter-row" id="projectsFilterRow">
  <button class="chip active" data-filter="all">Все</button>
  <button class="chip" data-filter="В работе">В работе</button>
  <button class="chip" data-filter="Планируется">Планируется</button>
  <button class="chip" data-filter="Готово">Готово</button>
</div>

<!-- Таблица проектов -->
<table id="projectsTable">
  <thead>
    <tr>
      <th>Название</th>
      <th>Технологии</th>
      <th>Статус</th>
    </tr>
  </thead>
  <tbody id="projectsTbody">
    <?php foreach ($arResult['PROJECTS'] as $project):
      $statusClass = match($project['STATUS']) {
        'В работе'  => 'badge-wip',
        'Готово'    => 'badge-done',
        default     => 'badge-plan',
      };
    ?>
      <tr class="table-row"
          data-status="<?= htmlspecialchars($project['STATUS']) ?>"
          data-name="<?= htmlspecialchars($project['NAME']) ?>"
          data-desc="<?= htmlspecialchars($project['DESC']) ?>">
        <td><?= htmlspecialchars($project['NAME']) ?></td>
        <td><?= htmlspecialchars($project['TECH']) ?></td>
        <td><span class="badge <?= $statusClass ?>"><?= htmlspecialchars($project['STATUS']) ?></span></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<p class="table-hint">Нажмите на строку, чтобы узнать подробнее</p>

<!-- Модальное окно (без jQuery UI — ванильный JS) -->
<div id="projectModal" class="modal-overlay" style="display:none;">
  <div class="modal-box">
    <button class="modal-close" id="projectModalClose">&#10005;</button>
    <h3 id="modalTitle"></h3>
    <p id="modalDesc"></p>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

  /* ── Фильтр ── */
  var chips  = document.querySelectorAll('#projectsFilterRow .chip');
  var rows   = document.querySelectorAll('#projectsTbody .table-row');

  chips.forEach(function (chip) {
    chip.addEventListener('click', function () {
      var filter = this.dataset.filter;
      chips.forEach(function (c) { c.classList.remove('active'); });
      this.classList.add('active');

      rows.forEach(function (row) {
        var show = filter === 'all' || row.dataset.status === filter;
        row.style.display = show ? '' : 'none';
      });
    });
  });

  /* ── Модалка при клике на строку ── */
  var modal     = document.getElementById('projectModal');
  var modalTitle = document.getElementById('modalTitle');
  var modalDesc  = document.getElementById('modalDesc');
  var closeBtn   = document.getElementById('projectModalClose');

  rows.forEach(function (row) {
    row.style.cursor = 'pointer';
    row.addEventListener('click', function () {
      modalTitle.textContent = this.dataset.name;
      modalDesc.textContent  = this.dataset.desc;
      modal.style.display    = 'flex';
    });
  });

  closeBtn.addEventListener('click', function () {
    modal.style.display = 'none';
  });

  modal.addEventListener('click', function (e) {
    if (e.target === modal) modal.style.display = 'none';
  });

  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') modal.style.display = 'none';
  });
});
</script>
