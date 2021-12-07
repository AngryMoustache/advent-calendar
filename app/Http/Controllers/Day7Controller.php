<?php

namespace App\Http\Controllers;

class Day7Controller extends Controller
{
    public $day = 7;

    public $fuel = 7;

    public function first()
    {
        $this->fuel = [];
        $max = $this->data->sortDesc()->first();
        for ($goto = 0; $goto < $max; $goto++) {
            $this->data->each(function ($number) use ($goto) {
                $n = $number - $goto;
                $this->fuel[$goto][] = ($n < 0) ? -$n : $n;
            });

            $this->fuel[$goto] = collect($this->fuel[$goto])->sum();
        }

        return collect($this->fuel)->sort()->first();
    }

    public function second()
    {
        $this->fuel = [];
        $max = $this->data->sortDesc()->first();
        for ($to = 0; $to < $max; $to++) {
            $this->data->each(function ($from) use ($to) {
                $steps = ($from - $to);
                $steps = ($steps < 0) ? -$steps : $steps;

                $this->fuel[$to][] = ($steps / 2) * ($steps + 1);
            });

            $this->fuel[$to] = collect($this->fuel[$to])->sum();
        }

        return collect($this->fuel)->sort()->first();
    }
}
