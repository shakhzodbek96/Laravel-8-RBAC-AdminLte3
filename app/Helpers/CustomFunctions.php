<?php

if (!function_exists('abort_if_forbidden')) {
    function abort_if_forbidden(string $permission,$message = "You have not permission to this page!"):void
    {
        abort_if(!auth()->user()->can($permission),403,$message);
    }
}

if (!function_exists('setUserTheme')) {
    function setUserTheme($theme)
    {
        $classes = [
          'default' => [
              'body' => '',
              'nav' => ' navbar-light ',
              'sidebar' => 'sidebar-dark-primary ',
          ],
          'light' => [
              'body' => '',
              'nav' => ' navbar-white ',
              'sidebar' => ' sidebar-light-lightblue '
          ],
          'dark' => [
              'body' => ' dark-mode ',
              'nav' => ' navbar-dark ',
              'sidebar' => ' sidebar-dark-secondary '
          ]
        ];
        return $classes[$theme] ?? [
                'body' => '',
                'nav' => ' navbar-light ',
                'sidebar' => 'sidebar-dark-primary ',
            ];
    }
}

if (!function_exists('price_format')) {
    function price_format($price)
    {
        return number_format($price, 2, ".", " ");
    }
}
if (!function_exists('nf')) {
    function nf($number)
    {
        return number_format($number, 0, "", " ");
    }
}

if (!function_exists('convert_text_latin')) {
    function convert_text_latin($text)
    {
        $cyr = [
            'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п',
            'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я',
            'А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П',
            'Р', 'С', 'Т', 'У', 'Ў', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я'
        ];
        $lat = [
            'a', 'b', 'v', 'g', 'd', 'e', 'yo', 'j', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p',
            'r', 's', 't', 'u', 'f', 'h', 'ts', 'ch', 'sh', 'sh', 'a', 'i', 'y', 'e', 'yu', 'ya',
            'A', 'B', 'V', 'G', 'D', 'E', 'Yo', 'J', 'Z', 'I', 'Y', 'K', 'L', 'M', 'N', 'O', 'P',
            'R', 'S', 'T', 'U', 'O', 'F', 'H', 'Ts', 'Ch', 'Sh', 'Sh', 'A', 'I', 'Y', 'e', 'Yu', 'Ya'
        ];
        $textlat = mb_strtoupper(removeChars(str_replace($cyr, $lat, $text)));
        return $textlat;
    }
}

if (!function_exists('removeChars')) {
    function removeChars($value)
    {
        $title = str_replace(array('\'', '"', ',', ';', '.', '’','-','‘','/'), ' ', $value);
        return $title;
    }
}

if (!function_exists('removeMarks')) {
    function removeMarks($value)
    {
        $title = str_replace(array('\'', '’','‘','`','?'), '', $value);
        return $title;
    }
}

if (!function_exists('phoneFormat')) {
    function phoneFormat($value)
    {
        if (strlen($value) == 9)
            return '+998'.$value;
        else
            return $value;
    }
}
if (!function_exists('message_set'))
{
    function message_set($message,$type,$timer = 15)
    {
        session()->put('_message',$message);
        session()->put('_type',$type);
        session()->put('_timer',$timer*1000);
    }
}

if (!function_exists('message_clear'))
{
    function message_clear()
    {
        session()->pull('_message');
        session()->pull('_type');
        session()->pull('_timer');
    }
}

if (!function_exists('sendByTelegram'))
{
    function sendByTelegram($message,$chatID,$token)
    {
        $url = "https://api.telegram.org/bot" . $token . "/sendMessage?parse_mode=HTML&chat_id=" . $chatID;
        $url = $url . "&text=" . urlencode($message);

        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch,CURLOPT_HTTPHEADER,['Content-type:application/json']);

        //ssl settings
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        $result = curl_exec($ch);

        curl_close($ch);

        return $result;
    }
}

if (!function_exists('logObj'))
{
    function logObj($object)
    {
        $unset_list = [
            'updated_at',
            'created_at',
            'email_verified_at',
            'roles'
        ];

        foreach ($unset_list as $item) {
            unset($object->{$item});
            unset($object[$item]);
        }

        return json_encode($object);
    }
}

