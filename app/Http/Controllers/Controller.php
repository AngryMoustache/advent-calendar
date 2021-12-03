<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $day;
    public $data;

    public function __construct()
    {
        $this->data = collect(
            json_decode(
                file_get_contents(
                    public_path("inputs/{$this->day}.json")
                )
            )
        );

        $this->parseData();
    }

    public function parseData()
    {
        //
    }
}
