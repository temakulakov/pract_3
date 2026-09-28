<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

class KulakovPersonalSkills extends CBitrixComponent
{
    private array $defaults = [
        'TITLE'  => 'Навыки',
        'GROUPS' => [
            [
                'NAME'  => 'Frontend',
                'COLOR' => 'black',
                'TAGS'  => ['HTML5', 'CSS3', 'JavaScript', 'jQuery', 'Адаптивность'],
            ],
            [
                'NAME'  => 'Инструменты',
                'COLOR' => 'gray',
                'TAGS'  => ['Git', 'GitHub', 'VS Code', 'DevTools'],
            ],
            [
                'NAME'  => 'Изучаю',
                'COLOR' => 'light',
                'TAGS'  => ['PHP', 'SQL', 'React', 'Node.js'],
            ],
        ],
    ];

    public function executeComponent(): void
    {
        $this->arResult = $this->defaults;

        $iblockId = (int)($this->arParams['IBLOCK_ID'] ?? 0);

        if ($iblockId > 0 && CModule::IncludeModule('iblock')) {
            $res = CIBlockElement::GetList(
                ['SORT' => 'ASC'],
                ['IBLOCK_ID' => $iblockId, 'ACTIVE' => 'Y'],
                false,
                false,
                ['ID', 'IBLOCK_ID', 'NAME', 'PROPERTY_COLOR']
            );

            $groups = [];
            while ($item = $res->GetNextElement()) {
                $fields = $item->GetFields();
                $props  = $item->GetProperties();

                $tags = $props['TAGS']['VALUE'] ?? [];
                if (!is_array($tags)) {
                    $tags = array_filter([$tags]);
                } else {
                    $tags = array_values(array_filter($tags, fn($v) => trim($v) !== ''));
                }

                $groups[] = [
                    'NAME'  => $fields['NAME'],
                    'COLOR' => $props['COLOR']['VALUE'] ?: 'black',
                    'TAGS'  => $tags,
                ];
            }

            if (!empty($groups)) {
                $this->arResult['GROUPS'] = $groups;
            }
        }

        $this->IncludeComponentTemplate();
    }
}
