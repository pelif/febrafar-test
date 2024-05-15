<?php

namespace Tests\Unit\App\Models;

use App\Models\Schedule;
use Illuminate\Database\Eloquent\Model;
use PHPUnit\Framework\TestCase;
use Tests\Unit\App\Models\ModelTestCase;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ScheduleTest extends ModelTestCase
{

    protected function model(): Model
    {
        return new Schedule();
    }

    protected function expectedTraits(): array
    {
        return [
            HasFactory::class
        ];
    }

    protected function expectedFillable(): array
    {
        return [
            'title',
            'description',
            'status',
            'start',
            'deadline',
            'completion',
            'user_id'
        ];
    }

    protected function expectedCasts(): array
    {
        return [
            'id' => 'int',
            'user_id' => 'string'
        ];
    }

    public function testIncrementingIsFalse(): void
    {
        $increment = $this->model()->incrementing;
        $this->assertTrue($increment);
    }

}
