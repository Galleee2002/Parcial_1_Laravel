<?php

namespace App\Http\Controllers;

use App\Models\Post;

/**
 * Páginas públicas del blog de RestoCode.
 */
class PostsController extends Controller
{
    /**
     * Muestra el listado de entradas del blog.
     */
    public function index()
    {
        $posts = Post::all();

        return view('blog.index', [
            'posts' => $posts,
        ]);
    }

    /**
     * Muestra el detalle de una entrada. Responde 404 si el id no existe.
     */
    public function show(int $id)
    {
        $post = Post::findOrFail($id);

        return view('blog.show', [
            'post' => $post,
        ]);
    }
}
