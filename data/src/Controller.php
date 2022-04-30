<?php

namespace Rakke1\TestMvc;

class Controller
{
    public function render($view, $params = []): string
    {
        return App::$app->view->renderView($view, $params);
    }
}