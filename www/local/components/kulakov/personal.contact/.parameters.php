<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

if (!CModule::IncludeModule('iblock')) return;

$arIBlocks = ['' => '(не сохранять в инфоблок)'];
$rsIBlocks = CIBlock::GetList(['SORT' => 'ASC'], ['ACTIVE' => 'Y']);
while ($arIB = $rsIBlocks->Fetch()) {
    $arIBlocks[$arIB['ID']] = '[' . $arIB['ID'] . '] ' . $arIB['NAME'];
}

// Список почтовых событий (типов)
$arEventTypes = ['' => '(не отправлять письмо)'];
$rsET = CEventType::GetList(['LID' => LANGUAGE_ID]);
while ($et = $rsET->Fetch()) {
    $arEventTypes[$et['EVENT_NAME']] = $et['EVENT_NAME'] . ' — ' . $et['NAME'];
}

$arComponentParameters = [
    'GROUPS' => [
        'FORM'    => ['NAME' => 'Настройки формы',        'SORT' => 10],
        'STORAGE' => ['NAME' => 'Сохранение сообщений',   'SORT' => 20],
        'MAIL'    => ['NAME' => 'Отправка на почту',      'SORT' => 30],
    ],
    'PARAMETERS' => [
        'TITLE' => [
            'PARENT'  => 'FORM',
            'NAME'    => 'Заголовок',
            'TYPE'    => 'STRING',
            'DEFAULT' => 'Контакт',
        ],
        'INTRO' => [
            'PARENT'  => 'FORM',
            'NAME'    => 'Подпись под заголовком',
            'TYPE'    => 'STRING',
            'DEFAULT' => 'Напишите мне — отвечу в ближайшее время',
        ],
        'SUBMIT_TEXT' => [
            'PARENT'  => 'FORM',
            'NAME'    => 'Текст кнопки',
            'TYPE'    => 'STRING',
            'DEFAULT' => 'Отправить',
        ],
        'SUCCESS_TEXT' => [
            'PARENT'  => 'FORM',
            'NAME'    => 'Сообщение при успехе',
            'TYPE'    => 'STRING',
            'DEFAULT' => 'Сообщение отправлено. Свяжусь с вами в ближайшее время.',
        ],

        'LOG_IBLOCK_ID' => [
            'PARENT'  => 'STORAGE',
            'NAME'    => 'Инфоблок для сохранения сообщений',
            'TYPE'    => 'LIST',
            'VALUES'  => $arIBlocks,
            'DEFAULT' => '',
        ],

        'EVENT_TYPE' => [
            'PARENT'  => 'MAIL',
            'NAME'    => 'Тип почтового события',
            'TYPE'    => 'LIST',
            'VALUES'  => $arEventTypes,
            'DEFAULT' => '',
        ],
        'EMAIL_TO' => [
            'PARENT'  => 'MAIL',
            'NAME'    => 'Email получателя (если не задан в шаблоне)',
            'TYPE'    => 'STRING',
            'DEFAULT' => '',
        ],
    ],
];
