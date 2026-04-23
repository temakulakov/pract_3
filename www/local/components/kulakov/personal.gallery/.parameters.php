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
            'NAME'    => 'Инфоблок галереи',
            'TYPE'    => 'LIST',
            'VALUES'  => $arIBlocks,
            'DEFAULT' => '',
            'REFRESH' => 'Y',
        ],
        'TITLE' => [
            'PARENT'  => 'BASE',
            'NAME'    => 'Заголовок блока',
            'TYPE'    => 'STRING',
            'DEFAULT' => 'Галерея',
        ],
        'COLUMNS' => [
            'PARENT'  => 'BASE',
            'NAME'    => 'Колонок в ряду',
            'TYPE'    => 'LIST',
            'VALUES'  => ['2' => '2', '3' => '3', '4' => '4'],
            'DEFAULT' => '3',
        ],
    ],
];
