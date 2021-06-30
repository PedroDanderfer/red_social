<?php

namespace DaVinci\Controllers;

use DaVinci\Core\App;
use DaVinci\Core\View;

class HomeController
{
    public function index()
    {
        View::render('home');
    }
}