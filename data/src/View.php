<?php

namespace Rakke1\TestMvc;

class View
{
    protected static string $VIEW_PATH = __DIR__ . '/Views/';

    public function renderView($view, array $params = []): bool|string
    {
        include_once self::$VIEW_PATH . 'layout.php';

        foreach ($params as $key => $value) {
            $$key = $value;
        }
        ob_start();
        include_once self::$VIEW_PATH . "$view.php";

        include_once self::$VIEW_PATH . 'footer.php';

        return ob_get_clean();
    }
}
