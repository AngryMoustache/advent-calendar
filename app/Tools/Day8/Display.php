<?php

namespace App\Tools\Day8;

class Display
{
    public $mapper = [];

    public $patterns;

    public $output;

    public $value = '';

    public function __construct($input)
    {
        $this->output = collect($input['output']);
        $this->patterns = collect($input['patterns'])
            ->sortBy(fn ($string) => strlen($string))
            ->map(fn ($string) => collect(str_split($string))->sort()->values()->toArray())
            ->values();

        $this->mapInputs();
        $this->mapOutput();
    }

    private function mapInputs()
    {
        // 1, 4, 7 and 8
        $this->mapper[1] = collect($this->patterns[0]);
        $this->mapper[7] = collect($this->patterns[1]);
        $this->mapper[4] = collect($this->patterns[2]);
        $this->mapper[8] = collect($this->patterns[9]);
        unset($this->patterns[0]);
        unset($this->patterns[1]);
        unset($this->patterns[2]);
        unset($this->patterns[9]);

        // 3
        $three = collect($this->patterns)
            ->filter(fn ($a) => count($a) === 5)
            ->filter(fn ($a) => $this->mapper[1]->intersect($a)->count() === 2)
            ->keys()
            ->first();

        $this->mapper[3] = collect($this->patterns[$three]);
        unset($this->patterns[$three]);

        // 5
        $five = collect($this->patterns)
            ->filter(fn ($a) => count($a) === 5)
            ->filter(fn ($a) => $this->mapper[4]->intersect($a)->count() === 3)
            ->keys()
            ->first();

        $this->mapper[5] = collect($this->patterns[$five]);
        unset($this->patterns[$five]);

        // 2
        $two = collect($this->patterns)
            ->filter(fn ($a) => count($a) === 5)
            ->keys()
            ->first();

        $this->mapper[2] = collect($this->patterns[$two]);
        unset($this->patterns[$two]);

        // 6
        $six = collect($this->patterns)
            ->filter(fn ($a) => count($a) === 6)
            ->filter(fn ($a) => $this->mapper[1]->intersect($a)->count() === 1)
            ->keys()
            ->first();

        $this->mapper[6] = collect($this->patterns[$six]);
        unset($this->patterns[$six]);

        // 9
        $nine = collect($this->patterns)
            ->filter(fn ($a) => count($a) === 6)
            ->filter(fn ($a) => $this->mapper[3]->intersect($a)->count() === 5)
            ->keys()
            ->first();

        $this->mapper[9] = collect($this->patterns[$nine]);
        unset($this->patterns[$nine]);

        // 0
        $zero = collect($this->patterns)->keys()->first();
        $this->mapper[0] = collect($this->patterns[$zero]);
        unset($this->patterns[$zero]);

        // Flatten the mappers for easy comparison
        $this->mapper = collect($this->mapper)
            ->mapWithKeys(fn ($col, $nr) => [$nr => $col->join('')])
            ->flip();
    }

    private function mapOutput()
    {
        foreach ($this->output as $string) {
            $string = collect(str_split($string))->sort()->join('');
            $this->value .= $this->mapper[$string];
        }

        $this->value = (int) $this->value;
    }
}
