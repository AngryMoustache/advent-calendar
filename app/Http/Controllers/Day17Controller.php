<?php

namespace App\Http\Controllers;

use App\Tools\Day17\Probe;

class Day17Controller extends Controller
{
    public $probes;

    public $checkX = 300;
    public $checkY = 200;

    public function data()
    {
        $this->probes = collect();
        for ($x = 0; $x < $this->checkX; $x++) {
            for ($y = -$this->checkY; $y < $this->checkY; $y++) {
                $this->probe($x, $y);
            }
        }
    }

    public function first()
    {
        return $this->probes->pluck('maxY')->max();
    }

    public function second()
    {
        return $this->probes->count();
    }

    public function probe($x, $y)
    {
        $probe = new Probe($x, $y);
        while(! $probe->area(...$this->data)) {
            $probe->step();
        }

        if ($probe->landedInArea) {
            $this->probes->push($probe);
        }
    }
}
