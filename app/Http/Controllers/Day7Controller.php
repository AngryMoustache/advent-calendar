<?php

namespace App\Http\Controllers;

class Day7Controller extends Controller
{
    public $fuel = [];

    public function first()
    {
        $goto = $this->data->median();
        return $this->data->map(fn ($from) => abs($from - $goto))->sum();
    }

    public function second()
    {
        for ($to = 0; $to < $this->data->max(); $to++) {
            $this->fuel[$to] = 0;
            $this->data->each(function ($from) use ($to) {
                $steps = abs($from - $to);
                $this->fuel[$to] += ($steps / 2) * ($steps + 1);
            });
        }

        return min($this->fuel);
    }
}
