<?php

namespace App\Tools\Day9;

class Point
{
    public $x;
    public $y;
    public $depth;
    public $risk;

    public function __construct($x, $y, $depth)
    {
        $this->x = $x;
        $this->y = $y;
        $this->depth = $depth;
        $this->risk = $depth + 1;
    }
}
