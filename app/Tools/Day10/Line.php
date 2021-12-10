<?php

namespace App\Tools\Day10;

use Illuminate\Support\Str;

class Line
{
    public $string;
    public $chunks = [];

    public $corrupt = false;

    public $openers = ['(', '[', '{', '<'];
    public $closers = [')', ']', '}', '>'];
    public $patterns = ['()', '[]', '{}', '<>'];

    public $corruptScores = [
        ')' => 3,
        ']' => 57,
        '}' => 1197,
        '>' => 25137,
    ];

    public $incompleteScores = [
        '(' => 1,
        '[' => 2,
        '{' => 3,
        '<' => 4,
    ];

    public function __construct($string)
    {
        $this->string = $string;
    }

    public function corrupt()
    {
        $string = $this->replacePatterns();

        foreach ($this->openers as $character) {
            $string = Str::replace($character, '', $string);
        }

        $this->corrupt = strlen($string) === 0 ? 0 : $this->corruptScores[$string[0]];
        return $this->corrupt;
    }

    public function incomplete()
    {
        $score = 0;
        $pattern = array_reverse(str_split($this->replacePatterns()));
        foreach ($pattern as $char) {
            $score *= 5;
            $score += $this->incompleteScores[$char];
        }

        $this->incomplete = $score;
        return $this->incomplete;
    }

    private function replacePatterns()
    {
        $string = $this->string;
        while (Str::contains($string, $this->patterns)) {
            foreach ($this->patterns as $pattern) {
                $string = Str::replace($pattern, '', $string);
            }
        }

        return $string;
    }
}
