<?php

namespace controllers;

use src\View;

class Controller
{
    protected View $view;

    public function __construct()
    {
        $this->view = new View();
    }
}