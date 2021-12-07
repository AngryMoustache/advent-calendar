<?php

namespace App\Http\Controllers;

use App\Tools\Bingo\Board;

class Day4Controller extends Controller
{
    public $drawings;

    public $boards;

    public $winners;

    public function data()
    {
        $this->winners = collect();
        $this->drawings = collect($this->data['drawings']);
        $this->boards = collect($this->data['boards'])
            ->map(fn ($board) => new Board($board));
    }

    public function first()
    {
        // Draw a new number
        $number = $this->drawings->shift();

        // Mark it on each of the boards
        $this->boards->each(fn ($board) => $board->mark($number));

        // Check for bingo
        $bingo = $this->boards->skipUntil(fn ($board) => $board->check());

        // Continue if no bingo was found
        if ($bingo->isEmpty() && $this->drawings->isNotEmpty()) {
            return $this->first();
        }

        // Get final result
        return $bingo->first()->sum() * $number;
    }

    public function second()
    {
        // Draw a new number
        $number = $this->drawings->shift();

        // Mark it on each of the boards
        $this->boards->each(fn ($board) => $board->mark($number));

        // Check for bingo & add to the winners
        $this->boards = $this->boards->reject(function ($board) {
            if ($board->check()) {
                $this->winners->prepend($board);
                return true;
            }

            return false;
        });

        // Continue until the end
        if ($this->drawings->isNotEmpty() && $this->boards->isNotEmpty()) {
            return $this->second();
        }

        // Get final result
        return $this->winners->first()->sum() * $number;
    }
}
