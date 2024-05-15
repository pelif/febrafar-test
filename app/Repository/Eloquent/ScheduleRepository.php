<?php

namespace App\Repository\Eloquent;

use App\Models\Schedule;
use App\Repository\Contracts\ScheduleRepositoryInterface;
use App\Repository\Presenters\PaginationPresenter;
use App\Repository\Contracts\PaginationInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ScheduleRepository implements ScheduleRepositoryInterface
{
    protected $model;

    public function __construct(Schedule $schedule)
    {
        $this->model = $schedule;
    }

    public function paginate(int $page = 1): PaginationInterface
    {
        return new PaginationPresenter($this->model->paginate());
    }

    public function store(Request $request): Schedule
    {

    }

    public function update(Request $request, Schedule $schedule): object
    {

    }

    public function destroy(Schedule $schedule)
    {

    }

}
