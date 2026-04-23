<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<div class="page-heading">
  <div class="page-icon">&#9993;</div>
  <div>
    <h1><?= htmlspecialchars($arResult['TITLE']) ?></h1>
    <p class="page-subtitle"><?= htmlspecialchars($arResult['INTRO']) ?></p>
  </div>
</div>

<div class="notion-divider"></div>

<?php if ($arResult['SENT']): ?>

  <div class="result-box result-success">
    &#10003; <?= htmlspecialchars($arResult['SUCCESS_TEXT']) ?>
  </div>

<?php else: ?>

  <?php foreach ($arResult['ERRORS'] as $error): ?>
    <div class="result-box result-error">
      &#9888; <?= htmlspecialchars($error) ?>
    </div>
  <?php endforeach; ?>

  <form method="POST" action="" class="contact-form" novalidate>
    <?= bitrix_sessid_post() ?>

    <div class="form-group">
      <label for="cnt_name">Имя</label>
      <input type="text" id="cnt_name" name="name"
             value="<?= htmlspecialchars($arResult['FORM']['name']) ?>"
             placeholder="Артем" required />
    </div>

    <div class="form-group">
      <label for="cnt_email">Email</label>
      <input type="email" id="cnt_email" name="email"
             value="<?= htmlspecialchars($arResult['FORM']['email']) ?>"
             placeholder="example@mail.ru" required />
    </div>

    <div class="form-group">
      <label for="cnt_message">Сообщение</label>
      <textarea id="cnt_message" name="message" rows="5"
                placeholder="Напишите что-нибудь..." required><?= htmlspecialchars($arResult['FORM']['message']) ?></textarea>
    </div>

    <button type="submit" class="contact-submit"><?= htmlspecialchars($arResult['SUBMIT_TEXT']) ?></button>
  </form>

<?php endif; ?>
