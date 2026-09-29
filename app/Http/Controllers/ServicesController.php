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

    /**
     * Muestra el detalle de un servicio. Responde 404 si el id no existe.
     */
    public function show(int $id)
    {
        $service = Service::findOrFail($id);

        return view('services.show', [
            'service' => $service,
        ]);
    }
}
