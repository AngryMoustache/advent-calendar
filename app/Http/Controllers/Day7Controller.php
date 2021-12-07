<?php

namespace App\Http\Controllers;

class Day7Controller extends Controller
{
    public $fuel = 0;

    public function first()
    {
        $goto = $this->data->median();

        $this->data->each(function ($from) use ($goto) {
            $this->fuel += abs($from - $goto);
        });

        return collect($this->fuel)->sort()->first();
    }

    public function second()
    {
        $goto = $this->data->median();

        $this->data->each(function ($from) use ($goto) {
            $steps = abs($from - $goto);
            $this->fuel += ($steps / 2) * ($steps + 1);
        });

        return collect($this->fuel)->sort()->first();
    }
}
