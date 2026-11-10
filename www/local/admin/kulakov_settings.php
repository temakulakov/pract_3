<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_admin_before.php");

$APPLICATION->SetTitle("Настройки сайта (Kulakov)");

if (!$USER->IsAdmin()) {
    $APPLICATION->AuthForm("Доступ запрещён");
}

$MODULE = 'kulakov.main';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && check_bitrix_sessid()) {
    $title    = trim((string)($_POST['HEADER_TITLE']    ?? ''));
    $subtitle = trim((string)($_POST['HEADER_SUBTITLE'] ?? ''));
    $siteName = trim((string)($_POST['SITE_NAME']       ?? ''));

    COption::SetOptionString($MODULE, 'HEADER_TITLE',    $title);
    COption::SetOptionString($MODULE, 'HEADER_SUBTITLE', $subtitle);
    COption::SetOptionString($MODULE, 'SITE_NAME',       $siteName);

    LocalRedirect($APPLICATION->GetCurPageParam('saved=Y', ['saved']));
}

$HEADER_TITLE    = COption::GetOptionString($MODULE, 'HEADER_TITLE',    'Артем Кулаков');
$HEADER_SUBTITLE = COption::GetOptionString($MODULE, 'HEADER_SUBTITLE', 'Пи2у/23Б');
$SITE_NAME       = COption::GetOptionString($MODULE, 'SITE_NAME',      'Артем Кулаков');

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_admin_after.php");
?>

<?php if (($_GET['saved'] ?? '') === 'Y'): ?>
    <?php CAdminMessage::ShowNote('Настройки сохранены'); ?>
<?php endif; ?>

<form method="POST" action="<?= $APPLICATION->GetCurPage() ?>">
    <?= bitrix_sessid_post() ?>

    <?php
    $tabControl = new CAdminTabControl('tabControl', [
        ['DIV' => 'edit1', 'TAB' => 'Заголовок сайта', 'TITLE' => 'Заголовок и подзаголовок в сайдбаре'],
    ]);
    $tabControl->Begin();
    $tabControl->BeginNextTab();
    ?>

    <tr>
        <td width="40%"><label for="HEADER_TITLE">Заголовок (ФИО):</label></td>
        <td width="60%">
            <input type="text" name="HEADER_TITLE" id="HEADER_TITLE" size="50"
                   value="<?= htmlspecialcharsbx($HEADER_TITLE) ?>" />
        </td>
    </tr>

    <tr>
        <td><label for="HEADER_SUBTITLE">Подзаголовок (группа):</label></td>
        <td>
            <input type="text" name="HEADER_SUBTITLE" id="HEADER_SUBTITLE" size="50"
                   value="<?= htmlspecialcharsbx($HEADER_SUBTITLE) ?>" />
        </td>
    </tr>

    <tr>
        <td><label for="SITE_NAME">Название сайта (в &lt;title&gt;):</label></td>
        <td>
            <input type="text" name="SITE_NAME" id="SITE_NAME" size="50"
                   value="<?= htmlspecialcharsbx($SITE_NAME) ?>" />
        </td>
    </tr>

    <?php
    $tabControl->Buttons();
    ?>
    <input type="submit" name="save" value="Сохранить"
           class="adm-btn-save" title="Сохранить изменения" />

    <?php
    $tabControl->End();
    ?>
</form>

<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_admin.php");
