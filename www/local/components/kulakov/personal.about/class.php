<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

class KulakovPersonalAbout extends CBitrixComponent
{
    // Данные по умолчанию — если инфоблок не выбран или пуст
    private array $defaults = [
        'TITLE'     => 'Кулаков Артем',
        'SUBTITLE'  => 'Студент направления «Программная инженерия»',
        'TEXT'      => '<p>Учусь в университете с 2023 года. Увлекаюсь веб-разработкой — верстаю, изучаю JavaScript и постепенно разбираюсь в backend.</p>
                        <p>В свободное время читаю техническую литературу и участвую в учебных хакатонах.</p>',
        'INTERESTS' => [
            'Веб-разработка и UI-дизайн',
            'Алгоритмы и структуры данных',
            'Open-source проекты',
            'Командные хакатоны',
        ],
        'AVATAR'    => '/local/templates/kulakov_theme/images/avatar.jpg',
    ];

    public function executeComponent(): void
    {
        $this->arResult = $this->defaults;
        $this->arResult['ELEMENT_ID']  = 0;
        $this->arResult['IBLOCK_ID']   = 0;
        $this->arResult['IBLOCK_TYPE'] = '';

        // Берём IBLOCK_ID и ELEMENT_ID из параметров компонента (настраивается в режиме правки)
        $iblockId  = (int)($this->arParams['IBLOCK_ID']  ?? 0);
        $elementId = (int)($this->arParams['ELEMENT_ID'] ?? 0);

        if ($iblockId > 0 && CModule::IncludeModule('iblock')) {

            $this->arResult['IBLOCK_ID'] = $iblockId;

            // Тип инфоблока — для URL кнопки редактирования
            $arIblock = CIBlock::GetArrayByID($iblockId);
            $this->arResult['IBLOCK_TYPE'] = $arIblock['IBLOCK_TYPE_ID'] ?? '';

            // Фильтр: конкретный элемент или первый активный
            $filter = ['IBLOCK_ID' => $iblockId, 'ACTIVE' => 'Y'];
            if ($elementId > 0) {
                $filter['ID'] = $elementId;
            }

            // ВАЖНО: не включаем множественные свойства (INTERESTS) в arSelect —
            // это приведёт к дублированию строк через JOIN. Читаем их через GetProperties().
            $el = CIBlockElement::GetList(
                ['SORT' => 'ASC'],
                $filter,
                false,
                ['nTopCount' => 1],
                ['ID', 'IBLOCK_ID', 'NAME', 'DETAIL_TEXT', 'DETAIL_TEXT_TYPE', 'DETAIL_PICTURE']
            );

            if ($item = $el->GetNextElement()) {
                $fields = $item->GetFields();
                $props  = $item->GetProperties();

                $this->arResult['ELEMENT_ID'] = (int)$fields['ID'];

                // ФИО — из поля «Название»
                if (!empty($fields['NAME']))
                    $this->arResult['TITLE'] = $fields['NAME'];

                // Подзаголовок — из свойства SUBTITLE
                if (!empty($props['SUBTITLE']['VALUE']))
                    $this->arResult['SUBTITLE'] = $props['SUBTITLE']['VALUE'];

                // Основной текст — из детального описания
                if (!empty($fields['DETAIL_TEXT'])) {
                    if (($fields['DETAIL_TEXT_TYPE'] ?? 'text') === 'html') {
                        $this->arResult['TEXT'] = $fields['DETAIL_TEXT'];
                    } else {
                        $paragraphs = preg_split('/\r?\n\r?\n/', trim($fields['DETAIL_TEXT']));
                        $html = '';
                        foreach ($paragraphs as $p) {
                            $p = trim($p);
                            if ($p !== '')
                                $html .= '<p>' . nl2br(htmlspecialchars($p)) . '</p>';
                        }
                        $this->arResult['TEXT'] = $html ?: '<p>' . htmlspecialchars($fields['DETAIL_TEXT']) . '</p>';
                    }
                }

                // Интересы — множественное свойство INTERESTS
                if (!empty($props['INTERESTS']['VALUE'])) {
                    $val = $props['INTERESTS']['VALUE'];
                    $interests = is_array($val) ? $val : [$val];
                    $this->arResult['INTERESTS'] = array_values(
                        array_filter($interests, fn($v) => trim($v) !== '')
                    );
                }

                // Аватарка:
                // 1) Приоритет — свойство AVATAR (тип «Файл»), принимает SVG
                // 2) Фоллбэк — стандартная DETAIL_PICTURE (только PNG/JPG/GIF)
                $avatarFileId = $props['AVATAR']['VALUE'] ?? null;
                if (!empty($avatarFileId)) {
                    $path = CFile::GetPath((int)$avatarFileId);
                    if ($path)
                        $this->arResult['AVATAR'] = $path;
                } elseif (!empty($fields['DETAIL_PICTURE'])) {
                    $path = CFile::GetPath($fields['DETAIL_PICTURE']);
                    if ($path)
                        $this->arResult['AVATAR'] = $path;
                }
            }
        }

        $this->IncludeComponentTemplate();
    }
}
