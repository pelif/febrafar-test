<?php

namespace App\Services\Contracts;

use App\Models\Schedule;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

interface ScheduleServiceInterface
{

    /**
     * index
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse;


    /**
     * store
     *
     * @param  Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse;



    /**
     * update
     *
     * @param  Request $request
     * @param  Schedule $schedule
     * @return JsonResponse
     */
    public function update(Request $request, Schedule $schedule): JsonResponse;



    /**
     * destroy
     *
     * @param  Schedule $schedule
     * @return JsonResponse
     */
    public function destroy(Schedule $schedule): JsonResponse;

}
