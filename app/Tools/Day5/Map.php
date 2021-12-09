<?php

namespace App\Tools\Day5;

class Map
{
    public $map;

    public $position = [
        'x' => 0,
        'y' => 0
    ];

    public function __construct($size)
    {
        for ($row = 1; $row <= $size; $row++) {
            $this->map[$row] = [];
            for ($column = 1; $column <= $size; $column++) {
                $this->map[$row][$column] = 0;
            }
        }
    }

    public function set($x = null, $y = null, $amount = 1)
    {
        $this->position['x'] = $x ?? $this->position['x'];
        $this->position['y'] = $y ?? $this->position['y'];
        $this->map[$this->position['x']][$this->position['y']] += $amount;
    }

    public function travel($direction, $steps)
    {
        if (is_array($steps)) {
            $directionY = ($steps['y'] > 0) ? 'down' : 'up';
            $directionX = ($steps['x'] > 0) ? 'right' : 'left';
            $amount = ($steps['x'] > 0) ? $steps['x'] : -$steps['x'];

            for ($i = 0; $i < $amount; $i++) {
                $this->{'walk' . ucfirst($directionX)}(0); // Move X
                $this->{'walk' . ucfirst($directionY)}(1); // Move Y and set amount
            }
        } else {
            for ($i = 0; $i < $steps; $i++) {
                $this->{'walk' . ucfirst($direction)}();
            }
        }
    }

    public function overlaps($min = 2)
    {
        return collect($this->map)
            ->flatten()
            ->filter(fn ($amount) => $amount >= $min)
            ->count();
    }

    //
    // Movement functions
    //

    public function walkUp($amount = 1)
    {
        $this->set(null, $this->position['y'] - 1, $amount);
    }

    public function walkRight($amount = 1)
    {
        $this->set($this->position['x'] + 1, null, $amount);
    }

    public function walkDown($amount = 1)
    {
        $this->set(null, $this->position['y'] + 1, $amount);
    }

    public function walkLeft($amount = 1)
    {
        $this->set($this->position['x'] - 1, null, $amount);
    }
}
