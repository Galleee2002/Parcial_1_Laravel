<?php

namespace App\Http\Controllers;

use App\Models\User;

/**
 * Listado y detalle de usuarios en el panel de administración.
 */
class AdminUsersController extends Controller
{
    /**
     * Muestra la tabla de usuarios.
     */
    public function index()
    {
        $users = User::all();

        return view('admin.users.index', [
            'users' => $users,
        ]);
    }

    /**
     * Muestra el detalle de un usuario y sus servicios contratados. Responde 404 si el id no existe.
     */
    public function show(int $id)
    {
        $user = User::findOrFail($id);

        return view('admin.users.show', [
            'user' => $user,
        ]);
    }
}
