<?php

namespace App\Modules\Consommateurs\Http\Controllers;

use Illuminate\Http\Request;

class ConsommateursController
{

    /**
     * Display the module welcome screen
     *
     * @return \Illuminate\Http\Response
     */
    public function welcome()
    {
        return view("Consommateurs::welcome");
    }
}
