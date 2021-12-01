<?php

namespace App\Http\Controllers;

class Day1Controller extends Controller
{
    public $day = 1;

    public function first()
    {
        $result = 0;
        for ($i = 1; $i < $this->data->count(); $i++) {
            if ($this->data[$i] > $this->data[$i - 1]) {
                $result++;
            }
        }

        return $result;
    }

    public function second()
    {
        $result = 0;
        $oldCount = null;

        for ($i = 2; $i < $this->data->count(); $i++) {
            $count = $this->data->skip($i - 2)->take(3)->sum();

            if ($oldCount && $count > $oldCount) {
                $result++;
            }

            $oldCount = $count;
        }

        return $result;
    }
}
