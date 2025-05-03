<?php

namespace ScoobEco\Http\Controllers\Site;

use ScoobEcoCore\Http\BaseController;
use ScoobEcoCore\Http\Request;

class HomeController extends BaseController
{
    public function index(Request $request)
    {
        $title = 'Home';

        return view(
            $request->currentRoute["name"],
            compact(
                'request',
                'title'
            )
        );
    }
}