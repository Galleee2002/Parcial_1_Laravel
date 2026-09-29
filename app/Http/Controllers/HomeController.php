<?php

namespace App\Http\Controllers;

use App\Models\Service;

/**
 * Página de inicio de RestoCode.
 */
class HomeController extends Controller
{
    /**
     * Muestra la home con el hero y los servicios activos.
     */
    public function index()
    {
        $services = Service::all();

        return view('home', [
            'services' => $services,
        ]);
    }
}
