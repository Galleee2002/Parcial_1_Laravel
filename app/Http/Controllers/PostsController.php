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
}
