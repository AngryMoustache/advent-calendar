<?php

namespace App\Http\Controllers;

class Day6Controller extends Controller
{
    public $fish;

    public function data()
    {
        $this->fish = collect()->pad(9, 0);
        $this->data->each(fn ($timer) => $this->fish[$timer] += 1);
    }

    public function first()
    {
        return $this->days(80);
    }

    public function second()
    {
        return $this->days(256);
    }

    public function days($amount)
    {
        for ($day = 1; $day <= $amount; $day++) {
            $birthing = $this->fish->shift();
            $this->fish[6] += $birthing;
            $this->fish = $this->fish->concat([$birthing]);
        }

        return $this->fish->sum();
    }
}
