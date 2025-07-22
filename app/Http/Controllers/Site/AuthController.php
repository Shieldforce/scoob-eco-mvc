<?php

namespace ScoobEco\Http\Controllers\Site;

use Exception;
use ScoobEcoCore\Database\DB;
use ScoobEcoCore\Enum\ResponseType;
use ScoobEcoCore\Http\BaseController;
use ScoobEcoCore\Http\Request;
use ScoobEcoCore\Http\Response;

class AuthController extends BaseController
{
    public function login(Request $request)
    {
        $title = 'Login';

        return view(
            $request->currentRoute["name"],
            compact(
                'request',
                'title'
            )
        );
    }

    public function loginRun(Request $request)
    {
        try {

            //$db = new DB();
            //$userGet = $db->table("users")->get();
            //$userFirst = $db->table("users")->first();
            //$userFind = $db->table("users")->find(1);
            //dd($userGet);

            return Response::return(
                $request,
                ResponseType::success,
                "Login realizado com sucesso!",
                200
            );
        } catch (Exception $e) {
            return Response::return(
                $request,
                ResponseType::error,
                "Erro ao realizar login!",
                500
            );
        }
    }
}