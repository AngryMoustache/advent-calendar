<?php

namespace App\Http\Controllers;

class Day12Controller extends Controller
{
    public $paths;
    public $caves;

    public function data()
    {
        $this->paths = collect();
        $this->caves = $this->data->flatten()->unique()->mapWithKeys(function ($point) {
            return [$point => [
                'big' => ctype_upper($point),
                'mouth' => in_array($point, ['start', 'end']),
                'connections' => $this->data
                    ->filter(fn ($path) => in_array($point, $path))
                    ->flatten()
                    ->reject(fn ($p) => $p === $point),
            ]];
        });
    }

    public function first()
    {
        $this->explore('start');
        return $this->paths->count();
    }

    public function second()
    {
        $this->explore('start', true);
        return $this->paths->count();
    }

    private function explore($current, $doExtraVisit = false, $path = null)
    {
        $path ??= [$current];

        // This path has found the exit
        if ($current === 'end') {
            $this->paths->push($path);
            return;
        }

        // Explore further
        $this->caves[$current]['connections']->each(function ($connection) use ($path, $doExtraVisit) {
            if ($this->caves[$connection]['big'] || ! in_array($connection, $path)) {
                $path[] = $connection;
                $this->explore($connection, $doExtraVisit, $path);
            } elseif (
                ! $this->caves[$connection]['big'] &&
                ! $this->caves[$connection]['mouth'] &&
                $doExtraVisit
            ) {
                $path[] = $connection;
                $this->explore($connection, ! $doExtraVisit, $path);
            }
        });
    }
}
