<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

if (!CModule::IncludeModule('iblock')) return;

$arIBlocks = [];
$rsIBlocks = CIBlock::GetList(['SORT' => 'ASC'], ['ACTIVE' => 'Y']);
while ($arIB = $rsIBlocks->Fetch()) {
    $arIBlocks[$arIB['ID']] = '[' . $arIB['ID'] . '] ' . $arIB['NAME'];
}

$arComponentParameters = [
    'GROUPS' => [
        'SOURCE' => ['NAME' => 'Источник данных', 'SORT' => 10],
    ],
    'PARAMETERS' => [
        'IBLOCK_ID' => [
            'PARENT'  => 'SOURCE',
            'NAME'    => 'Инфоблок сертификатов',
            'TYPE'    => 'LIST',
            'VALUES'  => $arIBlocks,
            'DEFAULT' => '',
        ],
        'TITLE' => [
            'PARENT'  => 'BASE',
            'NAME'    => 'Заголовок',
            'TYPE'    => 'STRING',
            'DEFAULT' => 'Сертификаты',
        ],
        'INTRO' => [
            'PARENT'  => 'BASE',
            'NAME'    => 'Подзаголовок',
            'TYPE'    => 'STRING',
            'DEFAULT' => '',
        ],
    ],
];
