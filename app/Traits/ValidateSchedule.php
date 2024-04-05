<?php

namespace App\Traits;

use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Validator as ValidationValidator;

trait ValidateSchedule
{
    /**
     * validateStore of a Schedule
     *
     * @param  mixed $request
     * @return ValidationValidator
     */
    public function validateStore(Request $request): ValidationValidator
    {
        $inputs = $request->all();

        $rules = [
            'title' => 'required|max:255',
            'description' => 'required|max:1024',
            'status' => 'required|max:1',
            'start' => 'required|date',
            'deadline' => 'required|date ',
            'user_id' => 'required'
        ];

        $msg = ['required' => ':attribute is mandatory'];

        return Validator::make($inputs, $rules, $msg);

    }

    /**
     * Validate if start date already exists on database for
     * current user
     *
     * @param  string $start
     * @return bool
     */
    public function validateData(string $start): bool
    {
        $schedules = Schedule::where('start', $start)
                            ->where('user_id', auth('sanctum')->user()->id)
                            ->count();

        if($schedules > 0) {
            return false;
        }
        return true;
    }


    /**
     * Validate if start date or deadline will be on weekend
     *
     * @param \Carbon\Carbon $start
     * @param \Carbon\Carbon $deadline
     * @return bool
     */
    public function validateWeekend(\Carbon\Carbon $start, \Carbon\Carbon $deadline): bool
    {
        if ($start->isWeekend() || $deadline->isWeekend()) {
            return false;
        }
        return true;
    }


    /**
     * validateEntityParam Schedule on certain methods
     *
     * @param  Schedule $schedule
     * @return bool
     */
    public function validateEntityParam(Schedule $schedule): bool
    {
        if($schedule !== null && isset($schedule->id)) {
            return true;
        }
        return false;
    }

}
