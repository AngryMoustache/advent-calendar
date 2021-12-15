<?php

namespace App\Tools\Day15;

class Crawler
{
    // public $visited = [0 => 0];
    // public $map = [];

    // public function __construct($map)
    // {
    //     $this->map = collect($map);
    // }

    // public function crawl($x = 0, $y = 0, $value = 0)
    // {
    //     foreach ($this->neighbors($x, $y) as $node) {
    //         $newValue = $value + $node['value'];
    //         $this->visited[$node['key']] ??= $newValue;

    //         if ($this->visited[$node['key']] < $newValue) {
    //             $this->visited[$node['key']] = $newValue;
    //         }

    //         $this->crawl($node['x'], $node['y'], $value);
    //     }
    // }

    // public function neighbors($x, $y)
    // {
    //     return collect([$this->get($x + 1, $y), $this->get($x, $y + 1)])->filter();
    // }

    // public function get($x, $y)
    // {
    //     return $this->map->where('x', $x)->firstWhere('y', $y);
    // }
}
