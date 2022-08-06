<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Modules\Schedule;
use App\Modules\Service;
use App\Modules\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ScheduleController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->all();
        try {
            $service = Service::where("id", $data['service_id'])->get();
            if($service->isEmpty()) {
                return new Response([
                    "is_error" => true,
                    "message" => "O serviço selecionado não existe",
                    "data" => []
                ], 400);
            }
            $service = $service->first();

            unset($data['service_id']);
            $data['end'] = Carbon::create($data['init'])->addMinutes($service->duration);
            $scheduleId = DB::table('schedules')->insertGetId(
                $data
            );
            $schedule = Schedule::where("id", $scheduleId)->get();
            if($schedule->isEmpty()) {
                return new Response([
                    "is_error" => true,
                    "message" => "Algum campo não está válido",
                    "data" => []
                ], 400);
            }
            $schedule = $schedule->first();

            $dataNewService = $service->toArray();
            unset($dataNewService['created_at'], $dataNewService['updated_at'], $dataNewService['id']);
            $dataNewService['schedule_id'] = $schedule->id;
            $serviceId = DB::table('services')->insertGetId(
                $dataNewService
            );
            $newService = Service::where("id", $serviceId)->get();
            if ($newService->isEmpty()) {
                return new Response([
                    "is_error" => true,
                    "message" => "Algum campo não está válido",
                    "data" => []
                ], 400);
            }
            $newService = $newService->first();
            return new Response([
                "is_error" => false,
                "message" => "Agendamento criado com sucesso",
                "data" => [
                    'schedule' => $schedule->toArray(),
                    'service' => $newService->toArray(),
                ]
            ], 201);

        }catch (QueryException $exception) {
            return new Response([
                "is_error" => true,
                "message" => $exception->getMessage(),
                "data" => []
            ], 400);
        }
    }

    public function index(Request $request)
    {
        try {
            $data = $request->all();
            if (empty($data['user_id'])) {
                $schedules = DB::table('schedules')
                    ->join('services', 'schedules.id', '=', 'services.schedule_id')
                    ->join('users', 'users.id', '=', 'schedules.user_id')
                    ->select('schedules.*',
                        'services.name as service_name', 'services.value as service_value', 'services.image as service_image', 'services.duration as service_duration',
                        'users.name as user_name', 'users.email as user_email'
                    )
                    ->get();
                return new Response([
                    "is_error" => false,
                    "message" => "Lista de agendamentos encontrada",
                    "data" => $schedules
                ], 200);
            }
            $schedules = DB::table('schedules')
                ->join('services', 'schedules.id', '=', 'services.schedule_id')
                ->join('users', 'users.id', '=', 'schedules.user_id')
                ->where('user_id', $data['user_id'])
                ->select('schedules.*',
                    'services.name as service_name', 'services.value as service_value', 'services.image as service_image', 'services.duration as service_duration',
                    'users.name as user_name', 'users.email as user_email'
                )
                ->get();
            return new Response([
                "is_error" => false,
                "message" => "Lista de agendamentos encontrada",
                "data" => $schedules
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
