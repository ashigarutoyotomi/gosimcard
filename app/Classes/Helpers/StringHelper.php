<?php

namespace App\Classes\Helpers;

class StringHelper
{
    /*
     * Экранировнаие спецсимволов для LIKE SQL условий
     */
    public static function escapeLike(string $text): string
    {
        $search = array('%', '_');
        $replace = array('\%', '\_');
        return str_replace($search, $replace, $text);
    }
}
