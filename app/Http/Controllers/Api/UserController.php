<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Modules\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function store(Request $request)
    {
        try {
            $id = DB::table('users')->insertGetId(
                $request->toArray()
            );
            $data = User::where("id", $id)->get();
            return new Response([
                "is_error" => false,
                "message" => "Usuário criado com sucesso",
                "data" => $data
            ], 201);

        }catch (QueryException $exception) {
            return new Response([
                "is_error" => true,
                "message" => $exception->getMessage(),
                "data" => []
            ], 400);
        }
    }

    public function login(Request $request)
    {
        $data = $request->all();
        try {
            $data = User::where("email", $data['email'])->get();
            if ($data->isEmpty()) {
                return new Response([
                    "is_error" => true,
                    "message" => "Cadastro inválido",
                    "data" => $data
                ], 200);
            }
            return new Response([
                "is_error" => false,
                "message" => "Login efetuado com sucesso",
                "data" => $data
            ], 200);

        }catch (\ErrorException $exception) {
            return new Response([
                "is_error" => true,
                "message" => $exception->getMessage(),
                "data" => []
            ], 400);
        }
    }
}
