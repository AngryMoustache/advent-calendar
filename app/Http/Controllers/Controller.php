<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Str;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $data;

    public $example = false;

    public function __construct()
    {
        $this->day = (int) Str::before(Str::after(get_class($this), 'Day'), 'Controller');

        $folder = ($this->example) ? 'inputs/examples' : 'inputs';
        $this->data = collect(
            json_decode(
                file_get_contents(
                    public_path("${folder}/{$this->day}.json")
                )
            )
        );

        $this->data();
    }

    public function data()
    {
        //
    }
}
