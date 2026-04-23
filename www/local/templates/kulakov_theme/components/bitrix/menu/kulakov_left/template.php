<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<?php if (empty($arResult)) return; ?>

<ul id="navList">
    <?php foreach ($arResult as $arItem): ?>
        <li>
            <a href="<?= $arItem['LINK'] ?>"
               class="nav-link <?= $arItem['SELECTED'] ? 'active' : '' ?>">
                <span class="nav-icon"></span> <?= $arItem['TEXT'] ?>
            </a>
        </li>
    <?php endforeach; ?>
</ul>
