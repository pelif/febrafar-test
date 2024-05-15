<?php

namespace Tests\Feature\App\Repository\Eloquent;

use App\Models\Schedule;
use App\Repository\Contracts\ScheduleRepositoryInterface;
use App\Repository\Eloquent\ScheduleRepository;
use Tests\TestCase;

class ScheduleRepositoryTest extends TestCase
{
    protected $repository;

    protected function setUp(): void
    {
        $this->repository = new ScheduleRepository(new Schedule());
        parent::setUp();
    }

    public function testImplementsInterface(): void
    {
        $this->assertInstanceOf(
            ScheduleRepositoryInterface::class,
            new ScheduleRepository(new Schedule())
        );
    }

    public function testPaginate(): void
    {
        Schedule::factory()->count(15)->create();

        $response = $this->repository->paginate();

        $this->assertIsArray($response->items());
        $this->assertEquals(15, $response->total());
    }



}
