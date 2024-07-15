<?php

namespace App\Modules\Consommations\Http\Controllers;

use Illuminate\Http\Request;

class ConsommationsController
{

    /**
     * Display the module welcome screen
     *
     * @return \Illuminate\Http\Response
     */
    public function welcome()
    {
        return view("Consommations::welcome");
    }
}
