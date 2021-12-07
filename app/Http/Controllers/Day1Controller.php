<?php

namespace App\Http\Controllers;

class Day1Controller extends Controller
{
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

        for ($i = 0; $i < $this->data->count(); $i++) {
            $count = $this->data->skip($i)->take(3)->sum();

            if ($oldCount && $count > $oldCount) {
                $result++;
            }

            $oldCount = $count;
        }

        return $result;
    }
}
