<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<ul id="navList">
  <?php foreach ($aMenuLinks as $item):
    $isActive = ($item["SELECTED"] === true || $item["SELECTED"] === "Y");
  ?>
    <li>
      <a href="<?= htmlspecialchars($item["LINK"]) ?>"
         class="nav-link <?= $isActive ? 'active' : '' ?>">
        <span class="nav-icon"></span>
        <?= htmlspecialchars($item["TEXT"]) ?>
      </a>
    </li>
  <?php endforeach; ?>
</ul>
