<?php

namespace App\Http\Controllers;

use App\Tools\SevenSegment\Display;

class Day8Controller extends Controller
{
    public function data()
    {
        $this->data = $this->data->map(function ($string) {
            $string = explode(' | ', $string);
            return [
                'patterns' => explode(' ', $string[0]),
                'output' => explode(' ', $string[1]),
            ];
        });
    }

    public function first()
    {
        return $this->data->map(function ($data) {
            $count = 0;
            foreach ($data['output'] as $str) {
                if (in_array(strlen($str), [2, 3, 4, 7])) {
                    $count++;
                }
            }

            return $count;
        })->sum();
    }

    public function second()
    {
        return $this->data->map(fn ($item) => new Display($item))
            ->map(fn ($display) => $display->value)
            ->sum();
    }
}
