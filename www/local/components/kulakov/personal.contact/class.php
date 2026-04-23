<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

class KulakovPersonalContact extends CBitrixComponent
{
    public function executeComponent(): void
    {
        $this->arResult = [
            'TITLE'        => $this->arParams['TITLE']        ?? 'Контакт',
            'INTRO'        => $this->arParams['INTRO']        ?? 'Напишите мне — отвечу в ближайшее время',
            'SUBMIT_TEXT'  => $this->arParams['SUBMIT_TEXT']  ?? 'Отправить',
            'SUCCESS_TEXT' => $this->arParams['SUCCESS_TEXT'] ?? 'Сообщение отправлено. Свяжусь с вами в ближайшее время.',
            'SENT'         => false,
            'ERRORS'       => [],
            'FORM'         => ['name' => '', 'email' => '', 'message' => ''],
        ];

        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !check_bitrix_sessid()) {
            $this->IncludeComponentTemplate();
            return;
        }

        // Сбор и санитизация данных
        $name    = trim((string)($_POST['name']    ?? ''));
        $email   = trim((string)($_POST['email']   ?? ''));
        $message = trim((string)($_POST['message'] ?? ''));

        $this->arResult['FORM'] = compact('name', 'email', 'message');

        // Валидация
        if ($name === '')
            $this->arResult['ERRORS'][] = 'Введите имя';
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
            $this->arResult['ERRORS'][] = 'Некорректный email';
        if ($message === '')
            $this->arResult['ERRORS'][] = 'Введите сообщение';

        if (!empty($this->arResult['ERRORS'])) {
            $this->IncludeComponentTemplate();
            return;
        }

        // 1. Сохранение в инфоблок-лог (если настроено)
        $logIblockId = (int)($this->arParams['LOG_IBLOCK_ID'] ?? 0);
        if ($logIblockId > 0 && CModule::IncludeModule('iblock')) {
            $el = new CIBlockElement();
            $el->Add([
                'IBLOCK_ID'    => $logIblockId,
                'NAME'         => $name . ' <' . $email . '>',
                'ACTIVE'       => 'Y',
                'PREVIEW_TEXT' => $message,
                'PROPERTY_VALUES' => [
                    'EMAIL' => $email,
                    'NAME'  => $name,
                ],
            ]);
        }

        // 2. Отправка письма через стандартный механизм Bitrix CEvent
        $eventType = (string)($this->arParams['EVENT_TYPE'] ?? '');
        if ($eventType !== '') {
            $fields = [
                'AUTHOR'       => $name,
                'AUTHOR_EMAIL' => $email,
                'TEXT'         => $message,
                'DATE'         => FormatDate('FULL'),
            ];
            $emailTo = trim((string)($this->arParams['EMAIL_TO'] ?? ''));
            if ($emailTo !== '') {
                $fields['EMAIL_TO'] = $emailTo;
            }
            CEvent::Send($eventType, SITE_ID, $fields);
        }

        $this->arResult['SENT'] = true;
        $this->arResult['FORM'] = ['name' => '', 'email' => '', 'message' => ''];

        $this->IncludeComponentTemplate();
    }
}
