<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

if (!CModule::IncludeModule('iblock')) return;

$arIBlocks = [];
$rsIBlocks = CIBlock::GetList(['SORT' => 'ASC'], ['ACTIVE' => 'Y']);
while ($arIB = $rsIBlocks->Fetch()) {
    $arIBlocks[$arIB['ID']] = '[' . $arIB['ID'] . '] ' . $arIB['NAME'];
}

$arElements = [];
$iblockId = (int)($arCurrentValues['IBLOCK_ID'] ?? 0);
if ($iblockId > 0) {
    $rsElements = CIBlockElement::GetList(
        ['NAME' => 'ASC'],
        ['IBLOCK_ID' => $iblockId, 'ACTIVE' => 'Y'],
        false,
        false,
        ['ID', 'NAME']
    );
    while ($arEl = $rsElements->Fetch()) {
        $arElements[$arEl['ID']] = '[' . $arEl['ID'] . '] ' . $arEl['NAME'];
    }
}

$arComponentParameters = [
    'GROUPS' => [
        'SOURCE' => ['NAME' => 'Источник данных', 'SORT' => 10],
    ],
    'PARAMETERS' => [
        'IBLOCK_ID' => [
            'PARENT'  => 'SOURCE',
            'NAME'    => 'Инфоблок',
            'TYPE'    => 'LIST',
            'VALUES'  => $arIBlocks,
            'DEFAULT' => '',
            'REFRESH' => 'Y',
        ],
        'ELEMENT_ID' => [
            'PARENT'  => 'SOURCE',
            'NAME'    => 'Элемент',
            'TYPE'    => 'LIST',
            'VALUES'  => $arElements,
            'DEFAULT' => '',
        ],
    ],
];
