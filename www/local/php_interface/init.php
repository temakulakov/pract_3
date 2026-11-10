<?php
AddEventHandler('main', 'OnBuildGlobalMenu', 'KulakovAddAdminMenu');
function KulakovAddAdminMenu(&$aGlobalMenu, &$aModuleMenu)
{
    $aModuleMenu[] = [
        'parent_menu' => 'global_menu_settings',
        'sort'        => 50,
        'url'         => '/local/admin/kulakov_settings.php?lang=' . LANGUAGE_ID,
        'text'        => 'Настройки сайта (Kulakov)',
        'title'       => 'Заголовок и подзаголовок сайдбара',
        'icon'        => 'default_menu_icon',
        'page_icon'   => 'default_page_icon',
        'items_id'    => 'kulakov_settings',
        'items'       => [],
    ];
}
