<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Inicio de sesión del panel de administración.
 */
class AuthController extends Controller
{
    /**
     * Muestra el formulario de login.
     */
    public function showForm()
    {
        return view('auth.login');
    }

    /**
     * Valida las credenciales, inicia la sesión y redirige al panel.
     * Si no coinciden, vuelve al login con el aviso de error y el email escrito.
     */
    public function processForm(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'El email es obligatorio.',
            'email.email' => 'El email no tiene un formato válido.',
            'password.required' => 'La contraseña es obligatoria.',
        ]);

        if (! Auth::attempt($credentials)) {
            return redirect()
                ->route('auth.login.form')
                ->with('feedback.message', 'Las credenciales utilizadas no coinciden con nuestros registros.')
                ->with('feedback.type', 'danger')
                ->withInput();
        }

        $request->session()->regenerate();

        return redirect()
            ->route('admin.posts.index')
            ->with('feedback.message', 'Sesión iniciada con éxito. ¡Hola de nuevo!');
    }

    /**
     * Cierra la sesión, invalida los datos de sesión y el token CSRF,
     * y vuelve al login con el aviso de salida.
     */
    public function processLogout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('auth.login.form')
            ->with('feedback.message', 'Sesión cerrada con éxito. ¡Te esperamos pronto!');
    }
}
