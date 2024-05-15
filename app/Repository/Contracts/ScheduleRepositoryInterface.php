<?php

namespace App\Repository\Contracts;

use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Repository\Contracts\PaginationInterface;

interface ScheduleRepositoryInterface
{
    public function paginate(int $page = 1): PaginationInterface;
    public function store(Request $request): Schedule;
    public function update(Request $request, Schedule $schedule): object;
    public function destroy(Schedule $schedule);
}
