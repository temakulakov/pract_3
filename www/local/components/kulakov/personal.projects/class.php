<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

class KulakovPersonalProjects extends CBitrixComponent
{
    private array $defaults = [
        'TITLE'    => 'Проекты',
        'PROJECTS' => [
            [
                'NAME'   => 'Персональная страница',
                'TECH'   => 'HTML, CSS, jQuery',
                'STATUS' => 'В работе',
                'DESC'   => 'Персональная страница с навигацией, анимациями и адаптивным дизайном.',
            ],
            [
                'NAME'   => 'Калькулятор',
                'TECH'   => 'HTML, CSS, JS',
                'STATUS' => 'Планируется',
                'DESC'   => 'Калькулятор с базовыми арифметическими операциями и историей вычислений.',
            ],
            [
                'NAME'   => 'To-Do List',
                'TECH'   => 'JavaScript',
                'STATUS' => 'Планируется',
                'DESC'   => 'Список задач с сохранением в localStorage и фильтрацией по статусу.',
            ],
            [
                'NAME'   => 'Таблица умножения',
                'TECH'   => 'HTML, CSS',
                'STATUS' => 'Готово',
                'DESC'   => 'Динамически генерируемая таблица умножения с подсветкой.',
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
                ['ID', 'IBLOCK_ID', 'NAME', 'PREVIEW_TEXT']
            );

            $projects = [];
            while ($item = $res->GetNextElement()) {
                $fields = $item->GetFields();
                $props  = $item->GetProperties();

                $projects[] = [
                    'NAME'   => $fields['NAME'],
                    'TECH'   => trim($props['TECH']['VALUE']   ?? ''),
                    'STATUS' => trim($props['STATUS']['VALUE'] ?? '') ?: 'Планируется',
                    'DESC'   => strip_tags($fields['PREVIEW_TEXT'] ?? ''),
                ];
            }

            if (!empty($projects)) {
                $this->arResult['PROJECTS'] = $projects;
            }
        }

        $this->IncludeComponentTemplate();
    }
}
