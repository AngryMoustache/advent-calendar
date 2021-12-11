<?php

namespace App\Http\Controllers;

use App\Tools\Day11\Octopus;

class Day11Controller extends Controller
{
    public function data()
    {
        $this->data = $this->data->map(function ($row, $y) {
            return collect($row)->map(fn ($energy, $x) => new Octopus($energy, $x, $y));
        })->flatten();
    }

    //
    // Part 1
    //
    public function first()
    {
        for ($i = 0; $i < 100; $i++) {
            $this->data->each(fn ($octopus) => $octopus->energy());
            $this->sweep();
            $this->data->each(fn ($octopus) => $octopus->rest());
        }

        return $this->data->pluck('flashes')->sum();
    }

    //
    // Part 2
    //
    public function second($step = 1)
    {
        $this->data->each(fn ($octopus) => $octopus->energy());
        $this->sweep();

        if ($this->data->where('flashed', false)->isNotEmpty()) {
            $this->data->each(fn ($octopus) => $octopus->rest());
            return $this->second($step + 1);
        }

        return $step;
    }

    //
    // Check every octopus for a flash
    //
    private function sweep()
    {
        $this->data->each(function (Octopus $octopus) {
            if (! $octopus->flashed && $octopus->flash()) {
                $this->surrounding($octopus)->each(fn ($octopus) => $octopus->energy());
            }
        });

        $check = $this->data->where('energy', '>', 9)->where('flashed', false);
        if ($check->isNotEmpty()) {
            $this->sweep();
        }
    }

    private function surrounding(Octopus $octopus)
    {
        return collect($octopus->surrounding())->map(function ($coords) {
            return $this->data->first(fn ($item) => (
                $coords['x'] === $item->x &&
                $coords['y'] === $item->y &&
                $item->flashed === false
            ));
        })->filter();
    }
}
