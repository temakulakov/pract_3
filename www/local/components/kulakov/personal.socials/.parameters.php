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
            'NAME'    => 'Инфоблок с соцсетями',
            'TYPE'    => 'LIST',
            'VALUES'  => $arIBlocks,
            'DEFAULT' => '',
            'REFRESH' => 'Y',
        ],
        'TITLE' => [
            'PARENT'  => 'BASE',
            'NAME'    => 'Заголовок блока',
            'TYPE'    => 'STRING',
            'DEFAULT' => 'Социальные сети',
        ],
    ],
];
