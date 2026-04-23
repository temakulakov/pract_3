# pract_3 — Персональный сайт на 1С-Битрикс

Практическая работа №3. Перенос персональной страницы на платформу 1С-Битрикс: Управление сайтом.

**Автор:** Кулаков Артем, группа Пи2у/23Б.

## Стек

- PHP 8.2 + Apache (Docker)
- MySQL 8.0
- Memcached
- 1С-Битрикс: Управление сайтом (демо)
- Кастомный шаблон `kulakov_theme`

## Структура репозитория

```
.
├── Dockerfile              # PHP 8.2 + Apache + расширения для Bitrix
├── docker-compose.yml      # web + db + memcached
├── apache/000-default.conf # VirtualHost на портах 80 и 8081
├── mysql/my.cnf            # настройки MySQL под Bitrix
└── www/
    ├── local/              # весь пользовательский код
    │   ├── components/kulakov/       # кастомные компоненты
    │   ├── templates/kulakov_theme/  # шаблон сайта
    │   └── php_interface/init.php    # регистрация админ-меню
    ├── bitrix/admin/kulakov_settings.php  # страница настроек
    ├── .left.menu.php      # пункты левого меню
    ├── index.php           # Обо мне
    ├── about/index.php     # О сайте
    ├── skills/index.php    # Навыки
    ├── projects/index.php  # Проекты
    └── contact/index.php   # Контакт
```

Ядро Bitrix (`/www/bitrix/*`), загрузки (`/www/upload/`), кэш и БД — **не коммитятся** (см. `.gitignore`).

## Развёртывание с нуля

```bash
git clone git@github.com:temakulakov/pract_3.git
cd pract_3
docker compose up -d --build
```

Открыть http://localhost:8081 — при первом запуске появится мастер установки Bitrix. Параметры БД:

- хост: `db`
- база: `bitrix`
- пользователь: `bitrix`
- пароль: `bitrix123`

После установки:

1. Применить шаблон `kulakov_theme` в «Настройки → Шаблоны».
2. Настройки → Настройки сайта (Kulakov) — ввести ФИО, группу, название сайта.
3. Создать инфоблоки (см. комментарии в компонентах `/www/local/components/kulakov/`).

## Кастомные компоненты

Все в namespace `kulakov:`:

- `personal.about`        — страница «Обо мне»
- `personal.skills`       — карточки навыков с фильтром
- `personal.projects`     — таблица проектов с фильтром и модалкой
- `personal.gallery`      — галерея с кликом на ссылку
- `personal.socials`      — соцсети (иконки SVG)
- `personal.contact`      — форма обратной связи (CEvent::Send)
- `site.about`            — страница «О сайте»

Все следуют единым канонам: `.parameters.php` с каскадными дропдаунами IBLOCK_ID → ELEMENT_ID, `GetProperties()` для множественных свойств, file-свойства для SVG-иконок.
