<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

class KulakovPersonalGallery extends CBitrixComponent
{
    public function executeComponent(): void
    {
        $this->arResult = [
            'TITLE'   => $this->arParams['TITLE']   ?? 'Галерея',
            'COLUMNS' => (int)($this->arParams['COLUMNS'] ?? 3),
            'ITEMS'   => [],
        ];

        $iblockId = (int)($this->arParams['IBLOCK_ID'] ?? 0);

        if ($iblockId > 0 && CModule::IncludeModule('iblock')) {
            $res = CIBlockElement::GetList(
                ['SORT' => 'ASC'],
                ['IBLOCK_ID' => $iblockId, 'ACTIVE' => 'Y'],
                false,
                false,
                ['ID', 'IBLOCK_ID', 'NAME', 'PREVIEW_PICTURE', 'PREVIEW_TEXT', 'PROPERTY_URL']
            );

            while ($item = $res->GetNextElement()) {
                $fields = $item->GetFields();
                $props  = $item->GetProperties();

                // Получаем путь к картинке
                $imgPath = '';
                if (!empty($fields['PREVIEW_PICTURE'])) {
                    $imgPath = CFile::GetPath($fields['PREVIEW_PICTURE']);
                }

                $this->arResult['ITEMS'][] = [
                    'NAME'    => $fields['NAME'],
                    'IMG'     => $imgPath,
                    'URL'     => trim($props['URL']['VALUE'] ?? ''),
                    'CAPTION' => strip_tags($fields['PREVIEW_TEXT'] ?? ''),
                ];
            }
        }

        $this->IncludeComponentTemplate();
    }
}
