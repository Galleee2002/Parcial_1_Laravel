<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/**
 * Inicio de sesión del panel y registro de usuarios comunes.
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

    /**
     * Muestra el formulario de registro.
     */
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    /**
     * Valida el alta, crea un usuario común, inicia la sesión y redirige a la home.
     * Si la validación falla, vuelve al formulario con los errores y lo escrito.
     */
    public function processRegister(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
        ], [
            'name.required' => 'El nombre es obligatorio.',
            'email.required' => 'El email es obligatorio.',
            'email.email' => 'El email no tiene un formato válido.',
            'email.unique' => 'Ese email ya está registrado.',
            'password.required' => 'La contraseña es obligatoria.',
        ]);

        $password = $data['password'];
        $data['password'] = Hash::make($password);
        $data['role'] = 'usuario';

        User::create($data);

        if (! Auth::attempt([
            'email' => $data['email'],
            'password' => $password,
        ])) {
            return redirect()
                ->route('auth.register.form')
                ->with('feedback.message', 'No se pudo iniciar la sesión con la cuenta recién creada.')
                ->with('feedback.type', 'danger')
                ->withInput();
        }

        $request->session()->regenerate();

        return redirect()
            ->route('home')
            ->with('feedback.message', 'Registro completado con éxito. ¡Bienvenido/a!');
    }
}
