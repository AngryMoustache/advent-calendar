<?php

namespace App\Tools\Day17;

class Probe
{
    public $x = 0;
    public $y = 0;

    public $velocityXStart;
    public $velocityYStart;

    public $velocityX;
    public $velocityY;

    public $maxY;

    public $landedInArea = false;

    public function __construct($velocityX, $velocityY)
    {
        $this->velocityXStart = $velocityX;
        $this->velocityYStart = $velocityY;
        $this->velocityX = $velocityX;
        $this->velocityY = $velocityY;
    }

    public function step()
    {
        $this->x += $this->velocityX;
        $this->y += $this->velocityY;

        if ($this->y > $this->maxY) {
            $this->maxY = $this->y;
        }

        if ($this->velocityX > 0) {
            $this->velocityX--;
        }

        if ($this->velocityX < 0) {
            $this->velocityX++;
        }

        $this->velocityY--;
    }

    public function area($start, $end)
    {
        if (
            ($this->x >= $start->x && $this->x <= $end->x) &&
            ($this->y >= $start->y && $this->y <= $end->y)
        ) {
            $this->landedInArea = true;
            return true;
        }

        if ($this->x > $end->x || $this->y < -1000) {
            return true;
        }

        return false;
    }
}
