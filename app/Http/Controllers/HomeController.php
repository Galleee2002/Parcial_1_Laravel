<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Service;

/**
 * Página de inicio de RestoCode.
 */
class HomeController extends Controller
{
    /**
     * Muestra la home con el hero, los servicios activos y las tres entradas más recientes del blog.
     */
    public function index()
    {
        $services = Service::all();
        $posts = Post::orderBy('published_at', 'desc')->limit(3)->get();

        return view('home', [
            'services' => $services,
            'posts' => $posts,
        ]);
    }
}
