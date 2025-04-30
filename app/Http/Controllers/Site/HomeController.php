<?php

namespace ScoobEco\Http\Controllers\Site;

use ScoobEcoCore\Http\Request;

class HomeController
{
    public function index(Request $request)
    {
        dd("index");
    }

    public function userSave(Request $request)
    {
        dd("userSave");
    }
}