<?php

namespace App\Http\Controllers;

use App\Models\Service;

/**
 * Páginas públicas de los servicios de RestoCode.
 */
class ServicesController extends Controller
{
    /**
     * Muestra el listado de servicios.
     */
    public function index()
    {
        $services = Service::all();

        return view('services.index', [
            'services' => $services,
        ]);
    }
}
