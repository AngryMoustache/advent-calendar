<?php

namespace App\Tools\Day9;

class HeightMap
{
    public $coords;

    public function __construct($coords)
    {
        $this->coords =  $coords->map(function ($row, $y) {
            return collect($row)->map(function ($depth, $x) use ($y) {
                return new Point($x, $y, $depth);
            });
        });
    }

    public function scanLowPoints()
    {
        $this->points = collect();
        $this->coords->each(function ($row) {
            collect($row)->each(function ($point) {
                $lowPoints = $this->surrounding($point)->reject(fn ($l) => $l->depth > $point->depth);
                if ($lowPoints->isEmpty()) {
                    $this->points->push($point);
                }
            });
        });

        return $this->points;
    }

    public function scanBasins()
    {
        return $this->scanLowPoints()
            ->map(fn ($point) => $this->sweepSurrounding($point))
            ->map(fn ($basin) => $basin->flatten()->unique());
    }

    // Returns the surrounding points
    private function surrounding($point)
    {
        return collect([
            ($this->coords[$point->y - 1][$point->x] ?? null),
            ($this->coords[$point->y + 1][$point->x] ?? null),
            ($this->coords[$point->y][$point->x - 1] ?? null),
            ($this->coords[$point->y][$point->x + 1] ?? null),
        ])->filter();
    }

    // Returns the surrounding points and those surrounding it and ...
    private function sweepSurrounding($point, &$sweeped = null)
    {
        $sweeped ??= collect();
        if (! $sweeped->contains($point) && $point->depth < 9) {
            $sweeped->push($point);

            return $this->surrounding($point)->map(function ($p) use (&$sweeped) {
                return $this->sweepSurrounding($p, $sweeped);
            })->filter();
        }

        return $sweeped;
    }
}
