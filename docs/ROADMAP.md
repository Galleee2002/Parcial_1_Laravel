# Roadmap de RestoCode

Este orden puede cambiar cuando el docente suba clases nuevas. Si una clase trae otra implementación, se reemplaza el paso de este archivo y la regla correspondiente en [RULES.md](RULES.md). Los pasos 17 a 20 ya siguen el login que el docente implementó en `AuthController`.

Acá está en qué orden se construye cada feature. Cómo se escribe el código está en [RULES.md](RULES.md). No se pasa al paso siguiente si el anterior no se puede abrir en el navegador.

El proyecto es la raíz de este repositorio, en Laravel 13. `proyecto-docente` no se modifica ni se entrega: es la referencia de cómo escribe el docente (está en `.gitignore`). El dominio sale de [PRD.md](PRD.md): servicios para locales gastronómicos y un blog. El admin solo administra entradas.

Lo que el docente muestra pero la consigna no pide queda afuera: la subida de archivos (`cover` en `movies`) no se copia. La consigna suma puntos por "tablas de relaciones extras"; el docente todavía lo tiene como TODO ("Relaciones de 1-n" en `MoviesController@destroy`). Cuando lo muestre, se evalúa sumar un paso.

Equivalencia con el ABM de películas del docente:

- La lectura de `movies` pasa a ser `services` (`/servicios` y `/servicios/{id}`). Sin ABM.
- El ABM de `movies` pasa al admin de `posts` (`/admin/posts`), con el layout `admin`.
- El listado público del blog no lleva editar ni eliminar. Esos botones quedan solo en el admin.

`services` tiene, sin contar `id` ni las fechas de Laravel: `title`, `short_description`, `full_description`, `price`, `delivery_days`, `is_active`.

## 1. Proyecto listo y home estática — hecho

Laravel 13 + MySQL, home estática con layout `main`, Tailwind vía `@vite` y nav (Inicio, Servicios, Blog). La base hoy se llama `dw3_kuringhian_garcia`; el prefijo `dw3_` no cumple la consigna y se corrige en el paso 21.

## 2. Migración y modelo Service — hecho

Tabla `services` y modelo con precio en centavos (`unsignedInteger` + `Attribute::make` con `get:` y `set:` en arrow functions, como `Movie::price()`). PK `id`.

## 3. ServiceSeeder — hecho

Tres servicios (menú QR, landing, web con reservas); uno con `is_active` falso. `DB::table()->insert()` + `now()`, registrado en `DatabaseSeeder`.

## 4. Listado de servicios — hecho

`/servicios` con `ServicesController@index` (`Service::all()`), ruta `services.index` y vista `services/index.blade.php`: título, descripción corta, precio en pesos, días de entrega y enlace al detalle. Sin botones de alta, edición ni baja.

## 5. Detalle de un servicio — hecho

`/servicios/{id}` con `ServicesController@show` (`Service::findOrFail`), ruta `services.show` con `whereNumber('id')` y vista `services/show.blade.php`: título, descripciones corta y completa, precio, días de entrega y enlace de vuelta al listado. El enlace del listado usa `route('services.show', ['id' => ...])`. Un id inexistente o no numérico responde 404.

## 6. Home con servicios activos — hecho

`HomeController@index` pasa `Service::all()` a `home.blade.php`, que suma debajo del hero la grilla de servicios: el mismo `@foreach` de `services/index.blade.php` con `@if ($service->is_active)` adentro, con `h2` para la sección y `h3` por tarjeta. El botón del hero usa `route('services.index')`. El controller tiene PHPDoc. El servicio inactivo del seeder no aparece en `/`.

## 7. Migración y modelo Post — hecho

Tabla `posts` con `title` (`string` de 100), `summary` (`string`), `content` (`text`), `image` (`string` nullable), `published_at` (`date`, como `release_date`) y `timestamps`. PK `id`. Modelo `Post` con `protected $fillable` de los cinco campos, sin accessors. `image` no lo pide la consigna y se quitó en el paso 14.

Probar: `php artisan migrate` crea `posts`.

## 8. PostSeeder — hecho

Tres entradas sobre digitalización gastronómica (menú QR, reservas online, web del local) con `published_at` distintas. `DB::table()->insert()` + `now()`, registrado en `DatabaseSeeder` después de `ServiceSeeder`. `php artisan migrate:fresh --seed` deja tres servicios y tres entradas.

## 9. Listado público del blog — hecho

`/blog` con `PostsController@index` (`Post::all()`), controller de lectura separado del futuro `AdminPostsController`, ruta `blog.index` y vista `blog/index.blade.php`: un `<article>` por entrada con título (`h2`), fecha de publicación en `<time datetime>`, resumen y enlace al detalle. Del patrón `movies/index.blade.php` se toman el `@foreach` y los enlaces; la tabla queda para el admin y el listado usa tarjetas como `services/index.blade.php`. Sin `@auth` ni botones de alta, edición o baja. El nav del layout `main` pasa a `route('blog.index')`. El enlace al detalle usa `url('/blog/' . $post->id)` hasta que exista `blog.show` en el paso 10, como pasó con servicios entre los pasos 4 y 5.

## 10. Detalle de una entrada — hecho

`/blog/{id}` con `PostsController@show` (`Post::findOrFail`, con PHPDoc), ruta `blog.show` con `whereNumber('id')` y vista `blog/show.blade.php`: enlace de vuelta al blog, título, resumen, fecha de publicación en `<dl>` con `<time datetime>` y contenido con `whitespace-pre-line` para respetar los saltos de línea sin `{!! !!}`. Sigue el patrón de `movies/show.blade.php` con las clases de `services/show.blade.php`, sin la portada. El enlace de `blog/index.blade.php` pasa a `route('blog.show', ['id' => $post->id])`. Un id inexistente o no numérico responde 404.

## 11. Home con las últimas tres entradas — hecho

`HomeController@index` suma `Post::orderBy('published_at', 'desc')->limit(3)->get()` y lo pasa a `home.blade.php` como `posts`, con el PHPDoc actualizado. Es la excepción a la regla de no ordenar ni limitar que está en [RULES.md](RULES.md): el parcial pide "las últimas 3 entradas" y con `Post::all()` + `@if` no se puede saber cuáles son las más recientes. Se ordena por `published_at` porque el seeder carga todas las entradas con el mismo `now()`. Debajo de los servicios, la home suma la sección "Novedades" (`h2`), con el mismo estilo que la grilla de servicios: un `<article>` por entrada con fecha en `<time datetime>`, título (`h3`), resumen y enlace a `route('blog.show', ['id' => $post->id])`, más el enlace "Ver todas las entradas" a `route('blog.index')`. Sin `@if` en la vista: el controller ya pasa solo tres entradas. Con el seeder se ven, en orden, las del 2026-09-20, 2026-09-02 y 2026-08-10.

## 12. Layout admin y tabla de entradas — hecho

`/admin/posts` con `AdminPostsController@index` (`Post::all()`, con PHPDoc), controller separado de `PostsController`, ruta `admin.posts.index` sin `->middleware('auth')` hasta el paso 20 y vista `admin/posts/index.blade.php`: tabla con título, fecha de publicación en `<time datetime>` y acciones Ver (`route('blog.show', ['id' => $post->id])`), Editar y Eliminar, más el botón "Publicar una nueva entrada". La tabla y los botones salen de `movies/index.blade.php`. El layout `components/layouts/admin.blade.php` sigue el del docente pasado a `route()` como el layout `main`, con el mismo `@vite`, nav lateral con `aria-current` y el aviso de `feedback.message` de [RULES.md](RULES.md). Los enlaces de crear, editar y eliminar usan `url()` hasta que existan `admin.posts.create`, `admin.posts.edit` y `admin.posts.delete` en los pasos 13, 15 y 16, como pasó con el blog entre los pasos 9 y 10; mientras tanto responden 404. Con el seeder, la tabla lista las tres entradas.

## 13. Alta de una entrada — hecho

`/admin/posts/crear` con `AdminPostsController@create` (muestra el formulario) y `AdminPostsController@store` (valida y guarda), ambos con PHPDoc, rutas GET y POST `admin.posts.create` y `admin.posts.store`, y vista `admin/posts/create.blade.php` con `<x-layouts.admin>`. Sigue el patrón de `MoviesController@store` y `movies/create.blade.php`: campos `title`, `summary`, `content`, `image` (texto; se quitó en el paso 14) y `published_at` (`type="date"`); aviso general con `$errors->any()`; cada input con `@class` para el borde de error, `old('campo')`, `@error` con `aria-invalid` y `aria-errormessage`, y el mensaje con `id="error-campo"`. El formulario lleva `@csrf`. `$data` es lo que devuelve `$request->validate()` con mensajes en español; el docente usa `$request->input()`, pero en `AuthController` ya toma el retorno de `validate()` en `$credentials`. Se guarda con `$post = Post::create($data)` y se redirige a `admin.posts.index` con `feedback.message` armado con `$post->title`, como el docente con `$movie->title`. El botón "Publicar una nueva entrada" del listado pasa a `route('admin.posts.create')`. Guardar una entrada válida vuelve al listado con el mensaje de éxito; un campo vacío vuelve al formulario con el error y los datos escritos.

## 14. Sacar `image` de las entradas — hecho

La consigna no pide imagen en las entradas, así que la columna y el campo del formulario se quitaron. Como el proyecto solo corre en local y todavía no se entregó, se borró la línea `$table->string('image')->nullable()` de `create_posts_table` en vez de sumar una migración con `Schema::table`, y se recreó la base con `php artisan migrate:fresh --seed`. También se quitó `image` del `$fillable` de `Post`, de las tres filas de `PostSeeder`, de las reglas y mensajes de `AdminPostsController@store` y del input de `admin/posts/create.blade.php`. `posts` queda con `id`, `title`, `summary`, `content`, `published_at` y fechas.

## 15. Edición

Formulario y actualización en `/admin/posts/{id}/editar`.

Archivos: `edit`, `update`, rutas GET y POST, `resources/views/admin/posts/edit.blade.php`.

Patrón: `MoviesController@update` y `movies/edit.blade.php`, sin la parte de la portada (`hasFile`, `store`, `Storage::delete` y la imagen actual). `Post::findOrFail($id)`, `$data` desde `$request->validate()` con las mismas reglas y mensajes que `store`, `$post->update($data)` y redirección a `admin.posts.index` con feedback. Los values usan `old('campo', $post->campo)`.

Probar: editar cambia la fila y muestra el feedback. Un dato inválido no pisa el registro.

## 16. Confirmación y baja

Pantalla de confirmación y borrado en `/admin/posts/{id}/eliminar`.

Archivos: `delete`, `destroy`, rutas GET y POST, `resources/views/admin/posts/delete.blade.php`.

Patrón: `movies/delete.blade.php` y `MoviesController@destroy`, sin el borrado de la portada con `Storage`. `delete` muestra los datos de la entrada en un `<dl>` y un `<form method="post">` con `@csrf`; `destroy` hace `Post::findOrFail($id)`, `$post->delete()` y redirige con el feedback armado con `$post->title`.

Probar: el GET solo muestra la confirmación. El POST borra y vuelve al listado con el feedback. No hay botón de borrado en `/blog`.

## 17. Usuario admin

Cargar un usuario para entrar al panel.

Archivos: `database/seeders/UserSeeder.php`, `DatabaseSeeder.php`.

Patrón: `UserSeeder` del docente. `DB::table('users')->insert()` con `id`, `name`, `email` y `password` con `Hash::make`. El docente no carga `created_at` ni `updated_at`; acá se suman con `now()`, como en `MovieSeeder`. La tabla `users` no se modifica. `UserSeeder` va primero en `$this->call([...])`.

Probar: `php artisan migrate:fresh --seed` crea el usuario. Anotar email y contraseña de prueba en un comentario del seeder para poder explicarlos.

## 18. Login

Pantalla `/admin/login` y acción que inicia la sesión.

Archivos: `AuthController` con `showForm` y `processForm`, rutas GET y POST `/admin/login` con los nombres `auth.login.form` y `auth.login.process`, `resources/views/auth/login.blade.php`. El docente usa la URL `/iniciar-sesion`; acá va bajo `/admin` con los mismos nombres de ruta.

Patrón: `AuthController@processForm` y `auth/login.blade.php` del docente. La vista usa `<x-layouts.main>`. `$credentials = $request->validate(...)` con mensajes en español (el docente no los personaliza; la consigna pide informar los errores) y `Auth::attempt($credentials)`, que es la versión activa del docente. Si falla, `redirect()->route('auth.login.form')` con `feedback.message`, `feedback.type` `danger` y `->withInput()`. Si entra, `$request->session()->regenerate()` y redirección a `admin.posts.index` con feedback. El formulario lleva `@csrf`, `old('email')` y, como el email usa `type="email"`, `novalidate`.

Probar: credenciales malas vuelven al login con el aviso de error y el email escrito. Campos vacíos muestran los errores de validación. Credenciales buenas llegan a `/admin/posts`.

## 19. Logout

Cerrar la sesión y volver al login.

Archivos: `processLogout` en `AuthController`, ruta POST `/admin/logout` (en el docente, `/cerrar-session`) con el nombre `auth.logout.process`, formulario en el layout admin.

Patrón: `AuthController@processLogout` del docente: `Auth::logout()`, `$request->session()->invalidate()`, `$request->session()->regenerateToken()` y `redirect()->route('auth.login.form')` con feedback. El botón es el `<form method="post">` del nav del docente, con `@csrf` y `auth()->user()->email` en el texto.

Probar: después de salir aparece el feedback en el login y `/admin/posts` no se abre (cuando el paso 20 esté).

## 20. Protección del admin

Cortar el ABM de entradas si no hay sesión. El login queda afuera.

Archivos: `routes/web.php` (`->middleware('auth')` en cada ruta de `admin.posts.*`) y el `withMiddleware` de `bootstrap/app.php`.

Patrón: las rutas de `movies` del docente, cada una con `->middleware('auth')`. En `bootstrap/app.php`, `$middleware->redirectGuestsTo(fn () => route('auth.login.form'))`, igual que el docente. Se usa el middleware `auth` de Laravel; no se escribe uno propio.

Probar: sin sesión, crear, editar, eliminar y el listado redirigen a `/admin/login`. Con sesión, el ABM sigue funcionando. `/`, `/servicios` y `/blog` siguen públicos.

## 21. Entrega

Archivo `datos.txt` en la raíz, con el texto que pide [PRD.md](PRD.md). Completar carrera, cuatrimestre, año, turno, comisión y apellido y nombre de todos los integrantes.

Renombrar la base en MySQL y en `DB_DATABASE` del `.env` a `apellido1_apellido2` (hoy es `dw3_kuringhian_garcia`) y correr `php artisan migrate:fresh --seed` contra la base nueva.

Checklist antes de comprimir:

- Home con hero, servicios activos y tres novedades.
- `/servicios` y `/servicios/{id}` leen la base.
- `/blog` y `/blog/{id}` leen la base.
- `/admin/login` es propio: `AuthController` con `Auth::attempt`, sin Breeze, Jetstream ni controllers de autenticación de Laravel.
- Todo formulario POST tiene `@csrf`.
- ABM de entradas con validación en PHP, errores en la vista y feedback de éxito.
- Tres tablas creadas y cargadas con migraciones y seeders. Base llamada `apellido1_apellido2`, sin prefijos.
- `services` tiene más de cinco campos sin contar `id` ni `created_at` / `updated_at`.
- `posts` no tiene `image` y ningún formulario sube archivos.
- HTML semántico, estilos con Tailwind cargados por Vite (`public/build/` incluido en el zip), PHPDoc en controllers y métodos clave.
- El zip se llama `apellido-nombre_apellido2-nombre2.zip` (o `apellido-nombre.zip` si es individual) y contiene el proyecto más `datos.txt`, sin `proyecto-docente`.
