<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

class KulakovSiteAbout extends CBitrixComponent
{
    // Данные по умолчанию — если инфоблок не выбран или пуст
    private array $defaults = [
        'TITLE'    => 'О сайте',
        'SUBTITLE' => 'Практическая работа №3 — интеграция в 1С-Битрикс',
        'GOAL'     => '<p>Перенос персональной страницы (pract_1) на платформу 1С-Битрикс: Управление сайтом.</p>',
        'TECH'     => [
            '1С-Битрикс: Управление сайтом (демо-версия)',
            'PHP 8.2 + Apache в Docker',
            'Кастомный шаблон kulakov_theme',
            'HTML5, CSS3, jQuery — из pract_1',
        ],
        'AUTHOR'   => 'Кулаков Артем, группа Пи2у/23Б',
    ];

    public function executeComponent(): void
    {
        $this->arResult = $this->defaults;
        $this->arResult['ELEMENT_ID'] = 0;
        $this->arResult['IBLOCK_ID']  = 0;

        $iblockId  = (int)($this->arParams['IBLOCK_ID']  ?? 0);
        $elementId = (int)($this->arParams['ELEMENT_ID'] ?? 0);

        if ($iblockId > 0 && CModule::IncludeModule('iblock')) {

            $this->arResult['IBLOCK_ID'] = $iblockId;

            $filter = ['IBLOCK_ID' => $iblockId, 'ACTIVE' => 'Y'];
            if ($elementId > 0) {
                $filter['ID'] = $elementId;
            }

            // Множественные свойства (TECH) не в arSelect — читаем через GetProperties
            $el = CIBlockElement::GetList(
                ['SORT' => 'ASC'],
                $filter,
                false,
                ['nTopCount' => 1],
                ['ID', 'IBLOCK_ID', 'NAME', 'DETAIL_TEXT', 'DETAIL_TEXT_TYPE']
            );

            if ($item = $el->GetNextElement()) {
                $fields = $item->GetFields();
                $props  = $item->GetProperties();

                $this->arResult['ELEMENT_ID'] = (int)$fields['ID'];

                // Заголовок — из поля «Название»
                if (!empty($fields['NAME']))
                    $this->arResult['TITLE'] = $fields['NAME'];

                // Подзаголовок — из свойства SUBTITLE
                if (!empty($props['SUBTITLE']['VALUE']))
                    $this->arResult['SUBTITLE'] = $props['SUBTITLE']['VALUE'];

                // Цель работы — из детального описания
                if (!empty($fields['DETAIL_TEXT'])) {
                    if (($fields['DETAIL_TEXT_TYPE'] ?? 'text') === 'html') {
                        $this->arResult['GOAL'] = $fields['DETAIL_TEXT'];
                    } else {
                        $paragraphs = preg_split('/\r?\n\r?\n/', trim($fields['DETAIL_TEXT']));
                        $html = '';
                        foreach ($paragraphs as $p) {
                            $p = trim($p);
                            if ($p !== '')
                                $html .= '<p>' . nl2br(htmlspecialchars($p)) . '</p>';
                        }
                        $this->arResult['GOAL'] = $html ?: '<p>' . htmlspecialchars($fields['DETAIL_TEXT']) . '</p>';
                    }
                }

                // Список технологий — множественное свойство TECH
                if (!empty($props['TECH']['VALUE'])) {
                    $val = $props['TECH']['VALUE'];
                    $tech = is_array($val) ? $val : [$val];
                    $this->arResult['TECH'] = array_values(
                        array_filter($tech, fn($v) => trim($v) !== '')
                    );
                }

                // Автор — свойство AUTHOR
                if (!empty($props['AUTHOR']['VALUE']))
                    $this->arResult['AUTHOR'] = $props['AUTHOR']['VALUE'];
            }
        }

        $this->IncludeComponentTemplate();
    }
}
