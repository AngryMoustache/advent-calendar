<?php

namespace App\Http\Controllers;

use App\Tools\Day13\Paper;

class Day13Controller extends Controller
{
    public $paper;
    public $instructions;

    public function data()
    {
        $this->paper = new Paper($this->data['dots']);
        $this->instructions = collect($this->data['instructions']);
    }

    public function first()
    {
        $this->paper->fold(...$this->instructions->first());
        return $this->paper->count();
    }

    public function second()
    {
        $this->instructions->each(function ($instruction) {
            $this->paper->fold(...$instruction);
        });

        echo '<style>body { line-height: .5 }</style>';
        return $this->paper->render();
    }
}
