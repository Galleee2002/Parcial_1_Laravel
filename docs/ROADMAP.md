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

`/admin/posts` con `AdminPostsController@index` (`Post::all()`, con PHPDoc), controller separado de `PostsController`, ruta `admin.posts.index` sin `->middleware('auth')` hasta el paso 20 y vista `admin/posts/index.blade.php`: tabla con título, fecha de publicación en `<time datetime>` y acciones Ver (`route('blog.show', ['id' => $post->id])`), Editar y Eliminar, más el botón "Publicar una nueva entrada". La tabla y los botones salen de `movies/index.blade.php`. El layout `components/layouts/admin.blade.php` sigue el del docente pasado a `route()` como el layout `main`, con el mismo `@vite`, nav lateral con `aria-current` y el aviso de `feedback.message` de [RULES.md](RULES.md). Los enlaces de crear, editar y eliminar usaron `url()` hasta que existieron `admin.posts.create`, `admin.posts.edit` y `admin.posts.delete` en los pasos 13, 15 y 16, como pasó con el blog entre los pasos 9 y 10. Con el seeder, la tabla lista las tres entradas.

## 13. Alta de una entrada — hecho

`/admin/posts/crear` con `AdminPostsController@create` (muestra el formulario) y `AdminPostsController@store` (valida y guarda), ambos con PHPDoc, rutas GET y POST `admin.posts.create` y `admin.posts.store`, y vista `admin/posts/create.blade.php` con `<x-layouts.admin>`. Sigue el patrón de `MoviesController@store` y `movies/create.blade.php`: campos `title`, `summary`, `content`, `image` (texto; se quitó en el paso 14) y `published_at` (`type="date"`); aviso general con `$errors->any()`; cada input con `@class` para el borde de error, `old('campo')`, `@error` con `aria-invalid` y `aria-errormessage`, y el mensaje con `id="error-campo"`. El formulario lleva `@csrf`. `$data` es lo que devuelve `$request->validate()` con mensajes en español; el docente usa `$request->input()`, pero en `AuthController` ya toma el retorno de `validate()` en `$credentials`. Se guarda con `$post = Post::create($data)` y se redirige a `admin.posts.index` con `feedback.message` armado con `$post->title`, como el docente con `$movie->title`. El botón "Publicar una nueva entrada" del listado pasa a `route('admin.posts.create')`. Guardar una entrada válida vuelve al listado con el mensaje de éxito; un campo vacío vuelve al formulario con el error y los datos escritos.

## 14. Sacar `image` de las entradas — hecho

La consigna no pide imagen en las entradas, así que la columna y el campo del formulario se quitaron. Como el proyecto solo corre en local y todavía no se entregó, se borró la línea `$table->string('image')->nullable()` de `create_posts_table` en vez de sumar una migración con `Schema::table`, y se recreó la base con `php artisan migrate:fresh --seed`. También se quitó `image` del `$fillable` de `Post`, de las tres filas de `PostSeeder`, de las reglas y mensajes de `AdminPostsController@store` y del input de `admin/posts/create.blade.php`. `posts` queda con `id`, `title`, `summary`, `content`, `published_at` y fechas.

## 15. Edición — hecho

`/admin/posts/{id}/editar` con `AdminPostsController@edit` (`Post::findOrFail`, muestra el formulario) y `AdminPostsController@update` (valida y actualiza), ambos con PHPDoc, rutas GET y POST `admin.posts.edit` y `admin.posts.update` con `whereNumber('id')`, y vista `admin/posts/edit.blade.php` con `<x-layouts.admin>`. Sigue el patrón de `MoviesController@edit`/`update` y `movies/edit.blade.php`, sin la parte de la portada (`hasFile`, `store`, `Storage::delete` y la imagen actual). Como el docente, `update` repite las reglas de `store` y valida antes de buscar la entrada; después hace `$post->update($data)` y redirige a `admin.posts.index` con `feedback.message` armado con `$post->title`. El formulario es el de alta con `@csrf`, `action` a `route('admin.posts.update', ['id' => $post->id])` y cada value con `old('campo', $post->campo)`; `published_at` llega como string `Y-m-d`, que es lo que espera `type="date"`. El enlace "Editar" del listado pasa a `route('admin.posts.edit', ['id' => $post->id])`. Editar vuelve al listado con el mensaje de éxito; un título vacío vuelve al formulario con el error y lo escrito, sin tocar la fila; un id inexistente o no numérico responde 404.

## 16. Confirmación y baja — hecho

`/admin/posts/{id}/eliminar` con `AdminPostsController@delete` (`Post::findOrFail`, muestra la confirmación) y `AdminPostsController@destroy` (borra), ambos con PHPDoc, rutas GET y POST `admin.posts.delete` y `admin.posts.destroy` con `whereNumber('id')`, y vista `admin/posts/delete.blade.php` con `<x-layouts.admin>`. Sigue el patrón de `MoviesController@delete`/`destroy` y `movies/delete.blade.php`, sin el borrado de la portada con `Storage` ni el TODO de relaciones. La vista muestra "Confirmación necesaria", el título (`h2`), resumen y fecha de publicación en un `<dl>` con `<time datetime>`, el contenido con `whitespace-pre-line` y el aviso de que la acción es irreversible; el `<form method="post">` lleva `@csrf`, el botón "Eliminar" y un enlace "Cancelar" a `admin.posts.index`, como el formulario de edición. `destroy` hace `$post = Post::findOrFail($id)`, `$post->delete()` y redirige a `admin.posts.index` con `feedback.message` armado con `$post->title`, que sigue en memoria después de borrar la fila, como `$movie->title` en el docente. El enlace "Eliminar" del listado pasa a `route('admin.posts.delete', ['id' => $post->id])`. El GET solo muestra la confirmación y la entrada sigue en la tabla; el POST la borra y vuelve al listado con el mensaje de éxito; un id inexistente o no numérico responde 404; `/blog` no tiene botón de borrado.

## 17. Usuario admin — hecho

`database/seeders/UserSeeder.php` carga el usuario del panel con `DB::table('users')->insert()`: `id` 1, `name` "Admin RestoCode", `email` `admin@restocode.com` y `password` con `Hash::make('restocode')`. Sigue el `UserSeeder` del docente; como él no carga `created_at` ni `updated_at`, acá se suman con `now()`, como en `MovieSeeder` y en los otros seeders, para que ninguna fecha quede en `null`. El email y la contraseña de prueba quedan en un comentario del seeder para poder explicarlos. `email_verified_at` y `remember_token` quedan en `null`. La tabla `users` y el modelo `User` no se modifican. `UserSeeder` va primero en el `$this->call([...])` de `DatabaseSeeder`, antes de `ServiceSeeder` y `PostSeeder`. `php artisan migrate:fresh --seed` deja un usuario, tres servicios y tres entradas, y `Hash::check('restocode', $user->password)` da `true`. Entrar con ese usuario se prueba en el paso 18.

## 18. Login — hecho

`/admin/login` con `AuthController@showForm` (muestra el formulario) y `AuthController@processForm` (valida e inicia la sesión), ambos con PHPDoc, rutas GET y POST `auth.login.form` y `auth.login.process` sin middleware, y vista `auth/login.blade.php` con `<x-layouts.main>`. El docente usa la URL `/iniciar-sesion`; acá va bajo `/admin` con los mismos nombres de ruta. Sigue el patrón de `AuthController@processForm` y `auth/login.blade.php` del docente: `$credentials = $request->validate(...)` con `email` (`required|email`) y `password` (`required`), con mensajes en español porque la consigna pide informar los errores, y `Auth::attempt($credentials)`, que es la versión activa del docente. Si falla, vuelve a `auth.login.form` con `feedback.message`, `feedback.type` `danger` y `->withInput()`, que no reenvía la contraseña. Si entra, `$request->session()->regenerate()` (excepción al docente, ver [RULES.md](RULES.md)) y redirección a `admin.posts.index` con "Sesión iniciada con éxito. ¡Hola de nuevo!". El formulario sigue el patrón de `admin/posts/create.blade.php`: aviso general con `$errors->any()`, `@class`, `@error` con `aria-invalid` y `aria-errormessage`, `@csrf`, `old('email')` (la contraseña no se rellena) y `novalidate`, porque el email usa `type="email"`. El aviso de credenciales incorrectas lo muestra el bloque de `feedback.message` del layout `main`. Campos vacíos muestran "El email es obligatorio." y "La contraseña es obligatoria."; un email sin formato muestra su error; una contraseña incorrecta vuelve con el aviso rojo y el email escrito; `admin@restocode.com` / `restocode` llega a `/admin/posts` con el mensaje de bienvenida y la cookie de sesión cambia. El nav público no enlaza al login: se entra escribiendo `/admin/login`. Hasta el paso 20, `/admin/posts` sigue abriendo sin sesión.

## 19. Logout — hecho

`AuthController@processLogout` (con PHPDoc) y ruta POST `/admin/logout` con el nombre `auth.logout.process`, sin middleware. El docente usa la URL `/cerrar-session`; acá va bajo `/admin` con el mismo nombre de ruta. Sigue el patrón de `AuthController@processLogout` del docente: `Auth::logout()`, `$request->session()->invalidate()`, `$request->session()->regenerateToken()` y redirección a `auth.login.form` con "Sesión cerrada con éxito. ¡Te esperamos pronto!", que el bloque de `feedback.message` del layout `main` muestra en verde. El botón es un `<li>` nuevo en el nav del layout `admin`, debajo de "Ver sitio": un `<form method="post">` con `@csrf` y un `<button>` con `auth()->user()->email` en el texto. Va dentro de `@auth`, como el nav del docente, porque hasta el paso 20 `/admin/posts` abre sin sesión y `auth()->user()` sería `null`. Con sesión, el nav muestra "admin@restocode.com (Cerrar sesión)"; al hacer clic, el POST responde 302 a `/admin/login` con el aviso de salida; después, el panel ya no muestra el botón. Que `/admin/posts` no abra sin sesión se prueba en el paso 20.

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

## Extras para ver al final

No los pide la consigna. Se evalúan cuando los pasos 1 a 21 estén hechos.

### Enlace al login en el nav público

Hoy no hay forma de llegar a `/admin/login` desde `/`: el nav del layout `main` solo tiene Inicio, Servicios y Blog, y hay que escribir la URL a mano.

Archivos: `resources/views/components/layouts/main.blade.php`.

Patrón: el nav del layout `main` del docente, con `@auth` / `@else` / `@endauth`. Sin sesión, un enlace "Iniciar sesión" a `route('auth.login.form')`. Con sesión, un enlace "Panel" a `route('admin.posts.index')`; el botón de cerrar sesión sigue en el layout `admin`, como dice [RULES.md](RULES.md). Mismas clases que los otros `<li>` del nav.

```blade
@auth
    <li><a class="hover:text-blue-300" href="{{ route('admin.posts.index') }}">Panel</a></li>
@else
    <li><a class="hover:text-blue-300" href="{{ route('auth.login.form') }}">Iniciar sesión</a></li>
@endauth
```

Probar: sin sesión, el nav de `/` muestra "Iniciar sesión" y lleva a `/admin/login`. Con sesión, muestra "Panel" y lleva a `/admin/posts`. Después del logout del paso 19 vuelve a mostrar "Iniciar sesión".
