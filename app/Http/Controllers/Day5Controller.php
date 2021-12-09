<?php

namespace App\Http\Controllers;

use App\Tools\Day5\Map;

class Day5Controller extends Controller
{
    public function data()
    {
        $mapSize = $this->data->flatten()->sortDesc()->first();
        $this->map = new Map($mapSize);

        $this->data = $this->data->map(function ($coords) {
            if ($coords[0][0] === $coords[1][0]) {
                // Vertical
                $amount = $coords[1][1] - $coords[0][1];
                $direction = ($amount > 0) ? 'down' : 'up';
            } elseif ($coords[0][1] === $coords[1][1]) {
                // Horizontal
                $amount = $coords[1][0] - $coords[0][0];
                $direction = ($amount > 0) ? 'right' : 'left';
            } else {
                // Diagonal
                $direction = 'diagonal';
                $amount = [
                    'x' => $coords[1][0] - $coords[0][0],
                    'y' => $coords[1][1] - $coords[0][1],
                ];
            }

            if (! is_array($amount) && $amount < 0) {
                $amount = -$amount;
            }

            return [
                'direction' => $direction,
                'amount' => $amount,
                'coords' => [
                    'x' => $coords[0][0],
                    'y' => $coords[0][1],
                ]
            ];
        });
    }

    public function first()
    {
        $this->data->where('direction', '!=', 'diagonal')->each(function ($step) {
            $this->map->set($step['coords']['x'], $step['coords']['y']);
            $this->map->travel($step['direction'], $step['amount']);
        });

        return $this->map->overlaps();
    }

    public function second()
    {
        $this->data->each(function ($step) {
            $this->map->set($step['coords']['x'], $step['coords']['y']);
            $this->map->travel($step['direction'], $step['amount']);
        });

        return $this->map->overlaps();
    }
}
