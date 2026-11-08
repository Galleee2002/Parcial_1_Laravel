<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            'image_description' => 'nullable|max:255',
        ], [
            'title.required' => 'El título es obligatorio.',
            'title.min' => 'El título tiene que tener al menos :min caracteres.',
            'title.max' => 'El título no puede superar los :max caracteres.',
            'summary.required' => 'El resumen es obligatorio.',
            'summary.max' => 'El resumen no puede superar los :max caracteres.',
            'content.required' => 'El contenido es obligatorio.',
            'image_description.max' => 'La descripción de la imagen no puede superar los :max caracteres.',
        ]);

        $data['published_at'] = now()->toDateString();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('posts', 'public');
        }

        $post = Post::create($data);

        return redirect()
            ->route('admin.posts.index')
            ->with('feedback.message', 'La entrada ' . $post->title . ' se publicó con éxito.');
    }

    /**
     * Muestra el formulario de edición con los datos actuales de la entrada.
     */
    public function edit(int $id)
    {
        return view('admin.posts.edit', [
            'post' => Post::findOrFail($id),
        ]);
    }

    /**
     * Valida los datos del formulario, actualiza la entrada y vuelve al listado.
     */
    public function update(int $id, Request $request)
    {
        $data = $request->validate([
            'title' => 'required|min:2|max:100',
            'summary' => 'required|max:255',
            'content' => 'required',
            'image_description' => 'nullable|max:255',
        ], [
            'title.required' => 'El título es obligatorio.',
            'title.min' => 'El título tiene que tener al menos :min caracteres.',
            'title.max' => 'El título no puede superar los :max caracteres.',
            'summary.required' => 'El resumen es obligatorio.',
            'summary.max' => 'El resumen no puede superar los :max caracteres.',
            'content.required' => 'El contenido es obligatorio.',
            'image_description.max' => 'La descripción de la imagen no puede superar los :max caracteres.',
        ]);

        $post = Post::findOrFail($id);
        $oldImage = $post->image;

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('posts', 'public');
        }

        $post->update($data);

        if (
            $request->hasFile('image') &&
            $oldImage != null &&
            Storage::disk('public')->exists($oldImage)
        ) {
            Storage::disk('public')->delete($oldImage);
        }

        return redirect()
            ->route('admin.posts.index')
            ->with('feedback.message', 'La entrada ' . $post->title . ' se actualizó con éxito.');
    }

    /**
     * Muestra la confirmación antes de eliminar la entrada.
     */
    public function delete(int $id)
    {
        return view('admin.posts.delete', [
            'post' => Post::findOrFail($id),
        ]);
    }

    /**
     * Elimina la entrada y vuelve al listado.
     */
    public function destroy(int $id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        if (
            $post->image != null &&
            Storage::disk('public')->exists($post->image)
        ) {
            Storage::disk('public')->delete($post->image);
        }

        return redirect()
            ->route('admin.posts.index')
            ->with('feedback.message', 'La entrada ' . $post->title . ' se eliminó con éxito.');
    }
}
