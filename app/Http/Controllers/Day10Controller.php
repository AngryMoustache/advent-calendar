<?php

namespace App\Http\Controllers;

use App\Tools\Day10\Line;

class Day10Controller extends Controller
{
    public function data()
    {
        $this->data = $this->data->mapInto(Line::class);
    }

    public function first()
    {
        return $this->data->map(fn ($line) => $line->corrupt())
            ->sum();
    }

    public function second()
    {
        return $this->data
            ->reject(fn ($line) => $line->corrupt() > 0)
            ->map(fn ($line) => $line->incomplete())
            ->median();
    }
}
