<?php

namespace App\Http\Controllers;

use App\Models\Post;

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
}
