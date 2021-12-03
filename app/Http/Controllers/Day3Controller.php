<?php

namespace App\Http\Controllers;

class Day3Controller extends Controller
{
    public $day = 3;

    public $binaries = [
        'gamma' => [],
        'epsilon' => [],
    ];

    public function parseData()
    {
        $bits = [];
        for ($i = 0; $i < strlen($this->data->first()); $i++) {
            $this->data->each(function ($string) use ($i, &$bits) {
                $bits[$i][] = (int) $string[$i];
            });
        }

        $this->bits = collect($bits);
    }

    public function first()
    {
        $this->bits->each(function ($bits) {
            $zero = collect($bits)->filter(fn ($bit) => $bit === 0)->count();
            $one = collect($bits)->filter(fn ($bit) => $bit === 1)->count();
            if ($zero < $one) {
                $this->binaries['gamma'][] = 1;
                $this->binaries['epsilon'][] = 0;
            } else {
                $this->binaries['gamma'][] = 0;
                $this->binaries['epsilon'][] = 1;
            }
        });

        $gamma = bindec(implode('', $this->binaries['gamma']));
        $epsilon = bindec(implode('', $this->binaries['epsilon']));

        return $gamma * $epsilon;
    }

    public function second()
    {
        $co2 = $this->data;
        $oxygen = $this->data;

        foreach (['co2', 'oxygen'] as $type) {
            for ($i = 0; $i < strlen($this->data->first()); $i++) {
                // Find the most common bit in position $i
                $common = ${$type}->map(fn ($string) => (int) $string[$i]);
                $zero = $common->filter(fn ($bit) => $bit === 0)->count();
                $one = $common->filter(fn ($bit) => $bit === 1)->count();

                if ($type === 'oxygen') {
                    $common = (int) ($zero <= $one);
                } else {
                    $common = (int) ($zero > $one);
                }

                // Filter the unneeded data
                ${$type} = ${$type}->filter(fn ($item) => (int) $item[$i] === $common);

                // Stop the loop if only one item remains
                if (${$type}->count() === 1) {
                    break;
                }
            }
        }

        $oxygen = bindec($oxygen->first());
        $co2 = bindec($co2->first());

        return $oxygen * $co2;
    }
}
