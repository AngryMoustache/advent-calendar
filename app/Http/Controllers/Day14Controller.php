<?php

namespace App\Http\Controllers;

class Day14Controller extends Controller
{
    public $pairs = [];
    public $finalPair = null;
    public $insertions;

    public $example = true;

    public function data()
    {
        $this->insertions = $this->data['insertions'];

        for ($i = 0; $i < strlen($this->data['template']) - 1; $i++) {
            $pair = $this->data['template'][$i] . $this->data['template'][$i + 1];
            $this->pairs[$pair] ??= 0;
            $this->pairs[$pair]++;
        }

        $this->finalPair = $pair;
    }

    public function first()
    {
        return $this->insertions(4);
    }

    public function second()
    {
        return $this->insertions(40);
    }

    public function insertions($loop)
    {
        for ($i = 0; $i < $loop; $i++) {
            $pairs = [];
            $finalPair = null;

            foreach ($this->pairs as $pattern => $amount) {
                if (isset($this->insertions->{$pattern})) {
                    $element = $this->insertions->{$pattern};

                    $pair = $pattern[0] . $element;
                    $pairs[$pair] ??= 0;
                    $pairs[$pair] += $amount;

                    $pair = $element . $pattern[1];
                    $pairs[$pair] ??= 0;
                    $pairs[$pair] += $amount;

                    if (! $finalPair && $pattern === $this->finalPair) {
                        $finalPair = $pair;
                    }

                } else {
                    dd('F');
                    $pairs[$pattern] ??= 0;
                    $pairs[$pattern] += $amount;
                }
            }

            $this->pairs = $pairs;
            $this->finalPair = $finalPair;
        }


        // Count occurrences
        $counts = [];
        foreach ($this->pairs as $pair => $amount) {
            $counts[$pair[0]] ??= 0;
            $counts[$pair[0]] += $amount;

            if ($pair === $this->finalPair) {
                $counts[$pair[1]] ??= 0;
                $counts[$pair[1]] += $amount;
            }
        }

        dump($counts);
        dump(collect($counts)->sum());
        return max($counts) - min($counts);
    }
}
