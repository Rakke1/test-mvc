<?php

namespace Rakke1\TestMvc\Helpers;

class HtmlHelper
{
    public static function encode(string $html): string
    {
        return htmlspecialchars($html,  ENT_QUOTES, 'UTF-8');
    }
}