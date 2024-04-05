<?php

namespace App\Services;

use App\Models\Schedule;
use App\Services\Contracts\ScheduleServiceInterface;
use App\Traits\ValidateSchedule;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ScheduleService implements ScheduleServiceInterface
{

    use ValidateSchedule;


    /**
     * List of Schedules
     *
     * @param  Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        if($request->getMethod() == 'POST') {
            $validator = $this->validateFilters($request);

            if($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            $schedules = Schedule::whereBetween('start', [
                $request->start_date,
                $request->end_date
            ])->get();

            return response()->json($schedules, 200);
        }

        $schedules = Schedule::orderBy('id', 'desc')->get();
        return response()->json($schedules, 200);
    }



    /**
     * Initial Persistence of a schedule
     *
     * @param  Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $validator = $this->validateStore($request);

        if($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $start = new \Carbon\Carbon($request->start);
        $strStart = $start->format('Y-m-d');
        $deadLine = new \Carbon\Carbon($request->deadline);

        if(!$this->validateData($strStart)) {
            return response()->json(['fail' => 'There is already activity for this date'], 401);
        }

        if(!$this->validateWeekend($start, $deadLine)) {
            return response()->json(['fail' => 'It is not possible to register activity for the weekend'], 401);
        }

        $schedule = new Schedule();
        $schedule->title = $request->title;
        $schedule->description = $request->description;
        $schedule->status = $request->status;
        $schedule->start = $request->start;
        $schedule->deadline = $request->deadline;
        $schedule->user_id = auth('sanctum')->user()->id;

        if($schedule->save()) {
            return response()->json($schedule, 200);
        }
        return response()->json(['fail' => 'Error of Persistence'], 400);
    }



    /**
     * Update Data of a Schedule
     *
     * @param  Request $request
     * @param  Schedule $schedule
     * @return JsonResponse
     */
    public function update(Request $request, Schedule $schedule): JsonResponse
    {
        $validator = $this->validateStore($request);

        if($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $start = new \Carbon\Carbon($request->start);
        $deadLine = new \Carbon\Carbon($request->deadline);

        if(!$this->validateWeekend($start, $deadLine)) {
            return response()->json(['fail' => 'It is not possible to register activity for the weekend'], 401);
        }

        $scheduleEntity = Schedule::find($schedule->id);
        $scheduleEntity->title = $request->title;
        $scheduleEntity->description = $request->description;
        $scheduleEntity->status = $request->status;
        $scheduleEntity->start = $request->start;
        $scheduleEntity->deadline = $request->deadline;
        $scheduleEntity->user_id = auth('sanctum')->user()->id;

        if($scheduleEntity->save()) {
            return response()->json($scheduleEntity, 200);
        }
        return response()->json(['fail' => 'Error of Persistence'], 400);
    }



    /**
     * Destroy a Schedule
     *
     * @param  Schedule $schedule
     * @return JsonResponse
     */
    public function destroy(Schedule $schedule): JsonResponse
    {
        if(!$this->validateEntityParam($schedule)) {
            return response()->json(['fail' => 'Invalid passed parameter!'], 400);
        }

        $scheduleEntity = Schedule::find($schedule->id);
        if($scheduleEntity->delete()) {
            return response()->json(['deleted' => 'Schedule deleted with success!'], 200);
        }

        return response()->json(['fail' => 'Schedule not deleted!'], 400);
    }


}
