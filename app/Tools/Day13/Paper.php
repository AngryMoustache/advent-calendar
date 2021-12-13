<?php

namespace App\Tools\Day13;

class Paper
{
    public $dots = [];
    public $map = [];

    public function __construct($dots)
    {
        $this->dots = collect($dots);
        $maxX = $this->dots->pluck(0)->max() + 1;
        $maxY = $this->dots->pluck(1)->max() + 1;

        $this->map = collect()->pad($maxY, null)->map(fn () => collect()->pad($maxX, 0));
        $this->dots->each(fn ($coords) => $this->map[$coords[1]][$coords[0]] = 1);
    }

    public function fold($axis)
    {
        if ($axis === 'y') {

            $scraps = $this->map->split(2);
            if ($scraps[0]->count() > $scraps[1]->count()) {
                $scraps[0]->pop();
            }

            $scraps[1] = $scraps[1]->reverse()->values();

        } elseif ($axis === 'x') {

            $scraps = collect([collect(), collect()]);
            $this->map->map(function ($row) use (&$scraps) {
                $parts = $row->split(2);
                if ($parts[0]->count() > $parts[1]->count()) {
                    $parts[0]->pop();
                }

                $scraps[0]->push($parts[0]);
                $scraps[1]->push($parts[1]);
            });

            $scraps[1] = $scraps[1]->map(fn ($col) => $col->reverse()->values());
        }

        $this->map = $this->merge($scraps, $axis);
    }

    public function merge($scraps)
    {
        return $scraps[0]->map(function ($row, $y) use ($scraps) {
            return $row->map(fn ($col, $x) => $scraps[1][$y][$x] + $col);
        });
    }

    public function count()
    {
        return $this->map->flatten()->filter()->count();
    }

    public function render()
    {
        return $this->map->map(function ($row) {
            return $row->map(fn ($col) => ($col !== 0 ? '■' : '□'))->join('');
        })->join('<br>');
    }
}
