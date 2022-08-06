<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Modules\Service;
use App\Modules\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class ServiceController extends Controller
{
    public function store(Request $request)
    {
        try {
            $id = DB::table('services')->insertGetId(
                $request->toArray()
            );
            $data = Service::where("id", $id)->get();
            return new Response([
                "is_error" => false,
                "message" => "Serviço criado com sucesso",
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

    public function index()
    {
        try {
            $data = Service::where("schedule_id", null)->get();
            return new Response([
                "is_error" => false,
                "message" => "Lista de serviços encontrada",
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
