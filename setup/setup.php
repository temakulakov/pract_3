<?php
// Наполнение после установки: сайт s2, инфоблоки персонального сайта, задание 2 (тип test).
// Запуск внутри контейнера: php /var/www/html/setup/setup.php
// Повторный запуск ничего не дублирует.
$_SERVER['DOCUMENT_ROOT'] = '/var/www/html';
define('NO_KEEP_STATISTIC', true);
define('NOT_CHECK_PERMISSIONS', true);
define('BX_NO_ACCELERATOR_RESET', true);
require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php';
CModule::IncludeModule('iblock');

const SITE = 's2';
const SITE_DIR_PATH = '/kulakov/';
$FILES = __DIR__ . '/files/';

// --- учетная запись администратора ---
(new CUser)->Update(1, ['NAME' => 'Артем', 'LAST_NAME' => 'Кулаков', 'SECOND_NAME' => 'Андреевич']);

// --- новый сайт ---
if (!CSite::GetByID(SITE)->Fetch()) {
    $s1 = CSite::GetByID('s1')->Fetch();
    $site = new CSite;
    $ok = $site->Add([
        'LID' => SITE, 'ACTIVE' => 'Y', 'DEF' => 'N', 'SORT' => 200,
        'NAME' => 'Артем Кулаков', 'SITE_NAME' => 'Артем Кулаков',
        'DIR' => SITE_DIR_PATH, 'SERVER_NAME' => 'pract3.temakulakov.ru',
        'EMAIL' => $s1['EMAIL'], 'LANGUAGE_ID' => 'ru', 'CULTURE_ID' => $s1['CULTURE_ID'],
        'DOMAINS' => '', 'DOC_ROOT' => '',
        'TEMPLATE' => [['TEMPLATE' => 'kulakov_theme', 'SORT' => 1, 'CONDITION' => '']],
    ]);
    if (!$ok) die("site: {$site->LAST_ERROR}\n");
}

COption::SetOptionString('kulakov.main', 'HEADER_TITLE', 'Артем Кулаков');
COption::SetOptionString('kulakov.main', 'HEADER_SUBTITLE', 'Пи2у/23Б');
COption::SetOptionString('kulakov.main', 'SITE_NAME', 'Артем Кулаков');

function type($id, $name, $sections)
{
    if (CIBlockType::GetByID($id)->Fetch()) return;
    $t = new CIBlockType;
    $t->Add(['ID' => $id, 'SECTIONS' => $sections ? 'Y' : 'N', 'SORT' => 500,
        'LANG' => ['ru' => ['NAME' => $name, 'SECTION_NAME' => 'Разделы', 'ELEMENT_NAME' => 'Элементы'],
                   'en' => ['NAME' => $name, 'SECTION_NAME' => 'Sections', 'ELEMENT_NAME' => 'Elements']]])
        or die("type $id: {$t->LAST_ERROR}\n");
}

function ib($type, $code, $name, $props)
{
    if ($r = CIBlock::GetList([], ['CODE' => $code, 'CHECK_PERMISSIONS' => 'N'])->Fetch()) return (int)$r['ID'];
    $ib = new CIBlock;
    $id = $ib->Add(['IBLOCK_TYPE_ID' => $type, 'CODE' => $code, 'NAME' => $name, 'SITE_ID' => [SITE],
        'ACTIVE' => 'Y', 'SORT' => 500, 'GROUP_ID' => ['2' => 'R'], 'VERSION' => 1,
        'LIST_PAGE_URL' => '', 'DETAIL_PAGE_URL' => '', 'SECTION_PAGE_URL' => '']);
    if (!$id) die("iblock $code: {$ib->LAST_ERROR}\n");
    $sort = 100;
    foreach ($props as $pc => $p) {
        $fields = ['IBLOCK_ID' => $id, 'CODE' => $pc, 'NAME' => $p[0], 'PROPERTY_TYPE' => $p[1],
            'MULTIPLE' => !empty($p[2]) ? 'Y' : 'N', 'ACTIVE' => 'Y', 'SORT' => $sort += 10];
        if ($p[1] === 'F') $fields['FILE_TYPE'] = 'jpg, gif, bmp, png, jpeg, webp, svg';
        if (!empty($p[3])) $fields += $p[3];
        (new CIBlockProperty)->Add($fields) or die("property $pc\n");
    }
    return (int)$id;
}

function el($iblockId, $fields, $props = [])
{
    $ex = CIBlockElement::GetList([], ['IBLOCK_ID' => $iblockId, 'NAME' => $fields['NAME']], false, false, ['ID'])->Fetch();
    if ($ex) return (int)$ex['ID'];
    $e = new CIBlockElement;
    $id = $e->Add($fields + ['IBLOCK_ID' => $iblockId, 'ACTIVE' => 'Y', 'PROPERTY_VALUES' => $props]);
    if (!$id) die("element {$fields['NAME']}: {$e->LAST_ERROR}\n");
    return (int)$id;
}

function f($name)
{
    global $FILES;
    $a = CFile::MakeFileArray($FILES . $name);
    $a['MODULE_ID'] = 'iblock';
    return $a;
}

$ids = [];

// ---------- персональный сайт ----------
type('personal', 'Персональный сайт', false);

$ids['about'] = ib('personal', 'kulakov_about', 'Обо мне',
    ['SUBTITLE' => ['Подзаголовок', 'S'], 'INTERESTS' => ['Интересы', 'S', 1], 'AVATAR' => ['Аватар', 'F']]);
$ids['about_el'] = el($ids['about'], ['NAME' => 'Кулаков Артем', 'SORT' => 100, 'DETAIL_TEXT_TYPE' => 'html',
    'DETAIL_TEXT' => '<p>Учусь в РЭУ им. Г.В. Плеханова. Увлекаюсь веб-разработкой — верстаю, изучаю JavaScript и постепенно разбираюсь в backend.</p><p>В свободное время читаю техническую литературу и участвую в учебных хакатонах.</p>'],
    ['SUBTITLE' => 'Студент направления «Прикладная информатика»',
     'INTERESTS' => ['Веб-разработка и UI-дизайн', 'Алгоритмы и структуры данных', 'Open-source проекты', 'Командные хакатоны'],
     'AVATAR' => f('avatar.jpg')]);

$ids['skills'] = ib('personal', 'kulakov_skills', 'Навыки',
    ['COLOR' => ['Цвет (black / gray / light)', 'S'], 'TAGS' => ['Теги', 'S', 1]]);
el($ids['skills'], ['NAME' => 'Frontend', 'SORT' => 100], ['COLOR' => 'black', 'TAGS' => ['HTML5', 'CSS3', 'JavaScript', 'jQuery', 'Адаптивность']]);
el($ids['skills'], ['NAME' => 'Инструменты', 'SORT' => 200], ['COLOR' => 'gray', 'TAGS' => ['Git', 'GitHub', 'VS Code', 'DevTools']]);
el($ids['skills'], ['NAME' => 'Изучаю', 'SORT' => 300], ['COLOR' => 'light', 'TAGS' => ['PHP', 'SQL', '1С-Битрикс', 'React']]);

$ids['projects'] = ib('personal', 'kulakov_projects', 'Проекты',
    ['TECH' => ['Технологии', 'S'], 'STATUS' => ['Статус (В работе / Планируется / Готово)', 'S']]);
$p = [['Персональная страница', 'HTML, CSS, jQuery', 'Готово', 'Персональная страница с навигацией, анимациями и адаптивным дизайном.'],
      ['Калькулятор', 'PHP', 'Готово', 'Калькулятор на PHP: прием данных из формы, switch по оператору, проверка деления на ноль.'],
      ['Таблица умножения', 'PHP', 'Готово', 'Динамическая таблица умножения: размер и цвет задаются через форму.'],
      ['Сайт на 1С-Битрикс', '1С-Битрикс, PHP', 'В работе', 'Перенос персональной страницы на 1С-Битрикс: шаблон, компоненты, инфоблоки.']];
foreach ($p as $i => [$n, $t, $s, $d])
    el($ids['projects'], ['NAME' => $n, 'SORT' => 100 * ($i + 1), 'PREVIEW_TEXT' => $d], ['TECH' => $t, 'STATUS' => $s]);

$ids['gallery'] = ib('personal', 'kulakov_gallery', 'Галерея проектов', ['URL' => ['Ссылка', 'S']]);
el($ids['gallery'], ['NAME' => 'gagawa.ru', 'SORT' => 100, 'PREVIEW_PICTURE' => f('project1.jpg')], ['URL' => 'https://gagawa.ru']);
el($ids['gallery'], ['NAME' => 'gusevskoe-steklo.ru', 'SORT' => 200, 'PREVIEW_PICTURE' => f('project2.jpg')], ['URL' => 'https://gusevskoe-steklo.ru']);

$ids['socials'] = ib('personal', 'kulakov_socials', 'Социальные сети', ['URL' => ['Ссылка', 'S'], 'ICON' => ['Иконка (SVG)', 'F']]);
el($ids['socials'], ['NAME' => 'GitHub', 'SORT' => 100], ['URL' => 'https://github.com/temakulakov', 'ICON' => f('github.svg')]);

$ids['site'] = ib('personal', 'kulakov_site_about', 'О сайте',
    ['SUBTITLE' => ['Подзаголовок', 'S'], 'TECH' => ['Технологии', 'S', 1], 'AUTHOR' => ['Автор', 'S']]);
$ids['site_el'] = el($ids['site'], ['NAME' => 'О сайте', 'SORT' => 100, 'DETAIL_TEXT_TYPE' => 'html',
    'DETAIL_TEXT' => '<p>Персональная страница из практической работы №1, перенесенная на 1С-Битрикс: Управление сайтом. В корне установлен «Интернет-магазин» (одежда), персональный сайт — второй сайт s2 в папке /kulakov/.</p>'],
    ['SUBTITLE' => 'Практическая работа №3 — сайт на 1С-Битрикс',
     'TECH' => ['1С-Битрикс: Управление сайтом, редакция «Бизнес»', 'Два сайта: s1 — интернет-магазин одежды, s2 — персональный сайт',
                'Шаблон kulakov_theme и собственные компоненты kulakov:*', 'Инфоблоки типов «Персональный сайт» и «Тестовый»',
                'HTML5, CSS3, jQuery — из практической работы №1'],
     'AUTHOR' => 'Кулаков Артем Андреевич, группа Пи2у/23Б']);

// ---------- задание 2: тип «Тестовый» ----------
type('test', 'Тестовый', true);

$ids['authors'] = ib('test', 'test_authors', 'Авторы', [
    'BIRTHDATE' => ['Год рождения', 'S', 0, ['USER_TYPE' => 'DateTime']],
    'BROWSER_TITLE' => ['Заголовок окна браузера', 'S'],
]);
$ids['articles'] = ib('test', 'test_article', 'Статьи', [
    'YEAR' => ['Год выхода статьи', 'S'],
    'AUTHORS' => ['Автор(ы)', 'E', 1, ['LINK_IBLOCK_ID' => $ids['authors']]],
    'MORE_PHOTO' => ['Картинки', 'F', 1, ['FILE_TYPE' => 'jpg, gif, bmp, png, jpeg']],
    'BROWSER_TITLE' => ['Заголовок окна браузера', 'S'],
    'KEY_WORDS' => ['Ключевые слова', 'S'],
]);

$ids['ivanov'] = el($ids['authors'], ['NAME' => 'Иванов Иван Иванович', 'SORT' => 100, 'DETAIL_TEXT_TYPE' => 'html',
    'DETAIL_TEXT' => '<p>Иван Иванович Иванов родился в Твери. Окончил факультет прикладной информатики, десять лет занимается разработкой сайтов на 1С-Битрикс.</p><p>Автор статей об инфоблоках, компонентах и шаблонах сайта для отраслевых журналов.</p>'],
    ['BIRTHDATE' => '12.04.1985 00:00:00', 'BROWSER_TITLE' => 'Иванов Иван Иванович — автор статей о 1С-Битрикс']);

$sect = CIBlockSection::GetList([], ['IBLOCK_ID' => $ids['articles'], 'CODE' => 'bitrix-site-manager'])->Fetch();
if ($sect) {
    $ids['section'] = (int)$sect['ID'];
} else {
    $bs = new CIBlockSection;
    $ids['section'] = $bs->Add(['IBLOCK_ID' => $ids['articles'], 'NAME' => 'Статьи о 1С-Битрикс: Управление сайтом',
        'CODE' => 'bitrix-site-manager', 'ACTIVE' => 'Y', 'SORT' => 100]) or die("section: {$bs->LAST_ERROR}\n");
}

el($ids['articles'], ['NAME' => 'Инфоблоки: где хранится контент сайта', 'SORT' => 100, 'IBLOCK_SECTION_ID' => $ids['section'],
    'PREVIEW_TEXT' => 'Что такое информационные блоки, типы инфоблоков и свойства элементов.',
    'DETAIL_TEXT_TYPE' => 'html',
    'DETAIL_TEXT' => '<p>Информационные блоки — основной способ хранения однотипных данных в 1С-Битрикс: новостей, статей, товаров. Инфоблоки объединяются в типы, у каждого инфоблока есть свои свойства.</p><p>Свойства бывают строковыми, числовыми, файловыми, привязками к элементам и разделам. Свойство может быть множественным — например, несколько картинок у одной статьи.</p>',
    'PREVIEW_PICTURE' => f('article1.jpg')],
    ['YEAR' => '2025', 'AUTHORS' => [$ids['ivanov']], 'MORE_PHOTO' => [f('article1.jpg'), f('article2.jpg')],
     'BROWSER_TITLE' => 'Инфоблоки в 1С-Битрикс', 'KEY_WORDS' => 'инфоблоки, свойства, 1С-Битрикс']);

el($ids['articles'], ['NAME' => 'Компоненты и шаблоны: как выводится информация', 'SORT' => 200, 'IBLOCK_SECTION_ID' => $ids['section'],
    'PREVIEW_TEXT' => 'Как компоненты получают данные из инфоблоков и выводят их через шаблоны.',
    'DETAIL_TEXT_TYPE' => 'html',
    'DETAIL_TEXT' => '<p>Компонент отвечает за логику: получает данные из инфоблока и передает их в шаблон. Шаблон компонента отвечает только за внешний вид.</p><p>Шаблон сайта задает общий дизайн страниц: шапку, меню, подвал. Для одного сайта можно назначить несколько шаблонов по условиям.</p>',
    'PREVIEW_PICTURE' => f('article3.jpg')],
    ['YEAR' => '2026', 'AUTHORS' => [$ids['ivanov']], 'MORE_PHOTO' => [f('article3.jpg'), f('article4.jpg')],
     'BROWSER_TITLE' => 'Компоненты и шаблоны 1С-Битрикс', 'KEY_WORDS' => 'компоненты, шаблоны, 1С-Битрикс']);

$ib = new CIBlock;
$ib->Update($ids['authors'], ['LIST_PAGE_URL' => '#SITE_DIR#/authors/', 'SECTION_PAGE_URL' => '',
    'DETAIL_PAGE_URL' => '#SITE_DIR#/authors/?ELEMENT_ID=#ELEMENT_ID#']);
$ib->Update($ids['articles'], ['LIST_PAGE_URL' => '#SITE_DIR#/articles/',
    'SECTION_PAGE_URL' => '#SITE_DIR#/articles/?SECTION_ID=#SECTION_ID#',
    'DETAIL_PAGE_URL' => '#SITE_DIR#/articles/?ELEMENT_ID=#ELEMENT_ID#']);

BXClearCache(true);
echo json_encode($ids, JSON_UNESCAPED_UNICODE), "\n";
