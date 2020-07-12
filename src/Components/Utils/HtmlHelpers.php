<?php


namespace Fvy\Group404\Components\Utils;


class HtmlHelpers
{
    public static function rawHtml(string $str): string
    {
        return htmlspecialchars_decode(stripslashes($str));
    }

    public static function textOnly(string $str): string
    {
        return htmlspecialchars_decode(strip_tags($str));
    }

    public static function sanitizeField($field)
    {
        return filter_var($field, FILTER_SANITIZE_SPECIAL_CHARS);
    }
}