<?php

namespace App\Http\Controllers;

class Day2Controller extends Controller
{
    public $day = 2;

    public $position = [
        'horizontal' => 0,
        'depth' => 0,
        'aim' => 0,
    ];

    public function first()
    {
        $this->data->each(function ($item) {
            $item = explode(' ', $item);
            switch ($item[0]) {
                case 'forward':
                    $this->position['horizontal'] += $item[1];
                    break;
                case 'up':
                    $this->position['depth'] -= $item[1];
                    break;
                case 'down':
                    $this->position['depth'] += $item[1];
                    break;
            }
        });

        return $this->position['horizontal'] * $this->position['depth'];
    }

    public function second()
    {
        $this->data->each(function ($item, $key) {
            $item = explode(' ', $item);
            switch ($item[0]) {
                case 'forward':
                    $this->position['horizontal'] += $item[1];
                    $this->position['depth'] += $this->position['aim'] * $item[1];
                    break;
                case 'up':
                    $this->position['aim'] -= $item[1];
                    break;
                case 'down':
                    $this->position['aim'] += $item[1];
                    break;
            }
        });

        return $this->position['horizontal'] * $this->position['depth'];
    }
}
