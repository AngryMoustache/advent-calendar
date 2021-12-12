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
        //
    }

    private function explore($current, $path = null)
    {
        $path ??= collect($current);

        // This path has found the exit
        if ($current === 'end') {
            $this->paths->push(clone $path);
            return;
        }

        // Don't explore small caves multiple times
        $connections = $this->caves[$current]['connections']
            ->reject(function ($connection) use ($path) {
                return ! $this->caves[$connection]['big'] && $path->contains($connection);
            });

        // Explore further
        $connections->each(function ($connection) use ($path) {
            $path = clone $path;
            $path->push($connection);
            $this->explore($connection, $path);
        });
    }
}
