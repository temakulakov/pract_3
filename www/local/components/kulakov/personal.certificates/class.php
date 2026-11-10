<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

class KulakovPersonalCertificates extends CBitrixComponent
{
    public function executeComponent(): void
    {
        $this->arResult = [
            'TITLE' => $this->arParams['TITLE'] ?? 'Сертификаты',
            'INTRO' => $this->arParams['INTRO'] ?? '',
            'ITEMS' => [],
        ];

        $iblockId = (int)($this->arParams['IBLOCK_ID'] ?? 0);

        if ($iblockId > 0 && CModule::IncludeModule('iblock')) {
            $res = CIBlockElement::GetList(
                ['SORT' => 'ASC', 'NAME' => 'ASC'],
                ['IBLOCK_ID' => $iblockId, 'ACTIVE' => 'Y'],
                false,
                false,
                ['ID', 'IBLOCK_ID', 'NAME', 'PREVIEW_PICTURE']
            );

            while ($item = $res->GetNextElement()) {
                $fields = $item->GetFields();
                $props  = $item->GetProperties();

                $file = (int)($props['FILE']['VALUE'] ?? 0);

                $this->arResult['ITEMS'][] = [
                    'ID'     => $fields['ID'],
                    'NAME'   => $fields['~NAME'],
                    'IMG'    => $fields['PREVIEW_PICTURE'] ? CFile::GetPath($fields['PREVIEW_PICTURE']) : '',
                    'FILE'   => $file ? CFile::GetPath($file) : '',
                    'NUMBER' => trim($props['NUMBER']['VALUE'] ?? ''),
                    'DATE'   => $props['DATE']['VALUE'] ? FormatDate('j F Y', MakeTimeStamp($props['DATE']['VALUE'])) : '',
                ];
            }
        }

        $this->IncludeComponentTemplate();
    }
}
