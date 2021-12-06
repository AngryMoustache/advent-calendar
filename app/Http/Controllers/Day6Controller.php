<?php

namespace App\Http\Controllers;

class Day6Controller extends Controller
{
    public $day = 6;

    public $fish;

    public function parseData()
    {
        $this->fish = collect([0, 0, 0, 0, 0, 0, 0, 0, 0]);
        $this->data->each(function ($timer) {
            $this->fish[$timer] += 1;
        });
    }

    public function first()
    {
        for ($day = 1; $day <= 80; $day++) {
            $this->day();
        }

        return $this->fish->sum();
    }

    public function second()
    {
        for ($day = 1; $day <= 256; $day++) {
            $this->day();
        }

        return $this->fish->sum();
    }

    public function day()
    {
        $birthing = $this->fish->shift();
        $this->fish[6] += $birthing;
        $this->fish = $this->fish->concat([$birthing]);
    }
}
