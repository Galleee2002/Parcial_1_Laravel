<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

/**
 * ABM de entradas del blog en el panel de administración.
 */
class AdminPostsController extends Controller
{
    /**
     * Muestra la tabla de entradas con las acciones de alta, edición y baja.
     */
    public function index()
    {
        $posts = Post::all();

        return view('admin.posts.index', [
            'posts' => $posts,
        ]);
    }

    /**
     * Muestra el formulario para publicar una entrada.
     */
    public function create()
    {
        return view('admin.posts.create');
    }

    /**
     * Valida los datos del formulario, guarda la entrada y vuelve al listado.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|min:2|max:100',
            'summary' => 'required|max:255',
            'content' => 'required',
            'published_at' => 'required|date',
        ], [
            'title.required' => 'El título es obligatorio.',
            'title.min' => 'El título tiene que tener al menos :min caracteres.',
            'title.max' => 'El título no puede superar los :max caracteres.',
            'summary.required' => 'El resumen es obligatorio.',
            'summary.max' => 'El resumen no puede superar los :max caracteres.',
            'content.required' => 'El contenido es obligatorio.',
            'published_at.required' => 'La fecha de publicación es obligatoria.',
            'published_at.date' => 'La fecha de publicación no es válida.',
        ]);

        $post = Post::create($data);

        return redirect()
            ->route('admin.posts.index')
            ->with('feedback.message', 'La entrada ' . $post->title . ' se publicó con éxito.');
    }
}
