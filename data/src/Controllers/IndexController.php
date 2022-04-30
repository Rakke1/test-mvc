<?php

namespace Rakke1\TestMvc\Controllers;

use Rakke1\TestMvc\Controller;

class IndexController extends Controller
{
    public function home(): string
    {
        return $this->render('test');
    }
}
