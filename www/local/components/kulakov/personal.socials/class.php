<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

class KulakovPersonalSocials extends CBitrixComponent
{
    public function executeComponent(): void
    {
        $this->arResult = [
            'TITLE' => $this->arParams['TITLE'] ?? 'Социальные сети',
            'ITEMS' => [],
        ];

        $iblockId = (int)($this->arParams['IBLOCK_ID'] ?? 0);

        if ($iblockId > 0 && CModule::IncludeModule('iblock')) {
            $res = CIBlockElement::GetList(
                ['SORT' => 'ASC'],
                ['IBLOCK_ID' => $iblockId, 'ACTIVE' => 'Y'],
                false,
                false,
                ['ID', 'IBLOCK_ID', 'NAME', 'PREVIEW_PICTURE']
            );

            while ($item = $res->GetNextElement()) {
                $fields = $item->GetFields();
                $props  = $item->GetProperties();

                $iconPath = '';
                $iconFileId = $props['ICON']['VALUE'] ?? null;
                if (!empty($iconFileId)) {
                    $iconPath = CFile::GetPath((int)$iconFileId);
                } elseif (!empty($fields['PREVIEW_PICTURE'])) {
                    $iconPath = CFile::GetPath($fields['PREVIEW_PICTURE']);
                }

                $this->arResult['ITEMS'][] = [
                    'NAME' => $fields['NAME'],
                    'ICON' => $iconPath,
                    'URL'  => trim($props['URL']['VALUE'] ?? ''),
                ];
            }
        }

        $this->IncludeComponentTemplate();
    }
}
