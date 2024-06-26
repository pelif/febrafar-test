<?php

namespace Tests\Unit\App\Models;

use Illuminate\Database\Eloquent\Model;
use PHPUnit\Framework\TestCase;

abstract class ModelTestCase extends TestCase
{
    abstract protected function model(): Model;
    abstract protected function expectedTraits(): array;
    abstract protected function expectedFillable(): array;
    abstract protected function expectedCasts(): array;

    public function testTraits(): void
    {
        $traits = array_keys(class_uses($this->model()));

        $this->assertEquals($this->expectedTraits(), $traits);
    }

    public function testFillable(): void
    {
        $fillable = $this->model()->getFillable();

        $this->assertEquals($this->expectedFillable(), $fillable);
    }

    public function testIncrementingIsfalse(): void
    {
        $incrementing = $this->model()->incrementing;

        $this->assertFalse($incrementing);
    }

    public function testHasCasts(): void
    {
        $casts = $this->model()->getCasts();

        $this->assertEquals($this->expectedCasts(), $casts);
    }

}
