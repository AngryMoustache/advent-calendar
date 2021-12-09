<?php

namespace App\Tools\Day4;

class Board
{
    public $board;

    protected $checks = [
        // Horizontal
        [0, 1, 2, 3, 4],
        [5, 6, 7, 8, 9],
        [10, 11, 12, 13, 14],
        [15, 16, 17, 18, 19],
        [20, 21, 22, 23, 24],

        // Vertical
        [0, 5, 10, 15, 20],
        [1, 6, 11, 16, 21],
        [2, 7, 12, 17, 22],
        [3, 8, 13, 18, 23],
        [4, 9, 14, 19, 24],

        // Diagonal
        // [0, 6, 15, 18, 24],
        // [4, 8, 12, 16, 20],
    ];

    public function __construct($board)
    {
        $this->board = collect($board)->map(function ($row) {
            return collect($row)->flip()->map(fn () => false);
        });
    }

    public function mark($number)
    {
        $this->board = $this->board->map(function ($row) use ($number) {
            return $row->map(function ($value, $key) use ($number) {
                return ($key == $number) ? true : $value;
            });
        });
    }

    public function check()
    {
        $board = $this->board->flatten()->filter()->keys()->toArray();
        foreach ($this->checks as $check) {
            if (count(array_intersect($board, $check)) === 5) {
                return true;
            }
        }

        return false;
    }

    public function sum()
    {
        return $this->board->flatMap(function ($row) {
            return $row->reject()->keys();
        })->sum();
    }
}
