<?php

namespace App\Tools\Day11;

class Octopus
{
    public $energy;

    public $flashed = false;
    public $flashes = 0;

    public $x;
    public $y;

    public function __construct($energy, $x, $y)
    {
        $this->energy = $energy;
        $this->x = $x;
        $this->y = $y;
    }

    public function energy()
    {
        if (! $this->flashed) {
            $this->energy++;
        }
    }

    public function flash()
    {
        if (! $this->flashed && $this->energy > 9) {
            $this->flashed = true;
            $this->flashes++;
        }

        return $this->flashed;
    }

    public function rest()
    {
        if ($this->flashed) {
            $this->flashed = false;
            $this->energy = 0;
        }
    }

    public function surrounding()
    {
        return [
            ['x' => $this->x + 1, 'y' => $this->y],
            ['x' => $this->x, 'y' => $this->y + 1],
            ['x' => $this->x - 1, 'y' => $this->y],
            ['x' => $this->x, 'y' => $this->y - 1],
            ['x' => $this->x + 1, 'y' => $this->y - 1],
            ['x' => $this->x - 1, 'y' => $this->y + 1],
            ['x' => $this->x + 1, 'y' => $this->y + 1],
            ['x' => $this->x - 1, 'y' => $this->y - 1],
        ];
    }
}
