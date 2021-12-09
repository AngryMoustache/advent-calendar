<?php

namespace App\Http\Controllers;

use App\Tools\Day9\HeightMap;

class Day9Controller extends Controller
{
    public function data()
    {
        $this->data = new HeightMap($this->data);

    }

    public function first()
    {
        return $this->data->scanLowPoints()->pluck('risk')->sum();
    }

    public function second()
    {
        return $this->data->scanBasins()
            ->map(fn ($basin) => $basin->count())
            ->sortDesc()
            ->take(3)
            ->reduce(fn ($carry, $nr) => ($carry ?? 1) * $nr);
    }
}
