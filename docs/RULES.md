# Reglas de RestoCode

Estas reglas pueden cambiar cuando el docente suba clases nuevas. Si una clase contradice una regla de acá, gana la clase: se actualiza este archivo y el paso que corresponda en [ROADMAP.md](ROADMAP.md).

Acá está cómo se escribe el código. El orden de las features está en [ROADMAP.md](ROADMAP.md).

La carpeta `proyecto-docente` en disco es el corte de octubre, extraído de `proyecto.rar`. Ahí están el login, `Schema::table` de `cover`, el middleware de edad y `belongsToMany`. El inventario está en [SEGUNDO_PARCIAL.md](SEGUNDO_PARCIAL.md). No se agrega una técnica que esa carpeta no muestre y que el parcial no pida. Cuando el docente deja una alternativa comentada y otra activa, se copia la activa. El dominio (qué páginas y qué tablas) sale de [PRD.md](PRD.md) y de la consigna del parcial ([Portales y Comercio Electrónico - Segundo Parcial.pdf](Portales%20y%20Comercio%20Electrónico%20-%20Segundo%20Parcial.pdf)).

Una feature que la consigna no pide no se agrega aunque el docente la muestre: verificación de edad (`EnsureIsOver18YearsOld`, sesión `is_over_18`), mails de reserva (`MovieReserved`, `MoviesReservationController`) y Bootstrap.

Cuando el parcial obliga a apartarse del docente, la regla lo dice y explica por qué. Esas excepciones son pocas y se tienen que poder justificar en el coloquio.

## Qué no se usa

- Breeze, Jetstream, Fortify y los controllers de autenticación que trae Laravel. La consigna prohíbe "la interfaz de autenticación y controllers que Laravel provee". El controller de login es nuestro; `Auth::attempt` y el middleware `auth` sí se usan porque el docente los muestra.
- Form Requests. La validación es `$request->validate()` en el controller.
- Verbos PUT y DELETE. El formulario se muestra con GET y se procesa con POST.
- Validación del navegador. No se usan atributos como `required`, `min` o `max`. Los inputs pueden usar `type` (`text`, `email`, `date`, `password`); como `type="email"` activa la validación del navegador, el formulario que lo tenga lleva `novalidate`.
- Filtrar, ordenar o limitar consultas **hasta que un paso del ROADMAP lo pida**. El docente ahora sí lo muestra: `Movie::with(['rating', 'genres'])->paginate(2)` y `Genre::orderBy('name')`. En RestoCode, hoy, la única excepción hecha es la home: `Post::orderBy('published_at', 'desc')->limit(3)->get()`, porque el 1er parcial pide las últimas 3 entradas. El resto del sitio sigue con `all()` y, si hace falta un subconjunto, `@if` en la vista.
- Bootstrap y hojas en `public/css`. El docente las carga en sus layouts (su proyecto trae Tailwind y Vite instalados, pero no los usa). La consigna permite Bootstrap o Tailwind; RestoCode usa Tailwind cargado por Vite.
- Verificación de edad, mails y reservas de películas. El docente los muestra; la consigna del 2do no los pide.
- Confirmación de contraseña, ABM de usuarios, proceso de compra y `attach` / `sync` / `detach` en un controller. El registro, el rol, el middleware de administrador, la contratación y el listado de usuarios sí los pide el parcial: se arman en los pasos 24 a 28 de [ROADMAP.md](ROADMAP.md), cuando se pida cada paso. Ver [SEGUNDO_PARCIAL.md](SEGUNDO_PARCIAL.md).

## Rutas

Referencia: `proyecto-docente/routes/web.php`.

- Una ruta por llamado a `Route`, con el array `[Controller::class, 'metodo']` y `->name()`.
- El parámetro dinámico se escribe `{id}` y lleva `->whereNumber('id')`.
- Las rutas con un segmento fijo (`crear`, `listado`) se declaran de forma que `{id}` no las capture. Con `whereNumber('id')` alcanza.
- Enlaces con `route('nombre', ['id' => $modelo->id])`, no con URLs armadas a mano.
- Cada ruta del ABM lleva `->middleware('auth')`, una por una, como las de `movies` en el docente. Las rutas públicas, las del login y las del registro no lo llevan.
- El docente pone el login en `/iniciar-sesion` y el logout en `/cerrar-session`. En RestoCode van en `/admin/login` y `/admin/logout` para que todo el panel quede bajo `/admin`; los nombres de ruta son los mismos que los del docente.
- Nombres: `home`, `services.index`, `services.show`, `blog.index`, `blog.show`, `admin.posts.index`, `admin.posts.create`, `admin.posts.store`, `admin.posts.edit`, `admin.posts.update`, `admin.posts.delete`, `admin.posts.destroy`, `admin.users.index`, `admin.users.show`, `auth.login.form`, `auth.login.process`, `auth.logout.process`, `auth.register.form`, `auth.register.process`.

## Controllers

Referencia: `proyecto-docente/app/Http/Controllers/MoviesController.php`, `HomeController.php` y `AuthController.php`.

- La clase extiende `Controller` y el nombre termina en `Controller`.
- Un controller por responsabilidad. La home no lista el ABM. El ABM de entradas no renderiza el sitio público. El login vive en `AuthController`.
- Lectura: `Model::all()`, `find` o `findOrFail` (salvo las novedades de la home, ver "Qué no se usa"). `with`, `orderBy` y `paginate` existen en el docente; no se usan en RestoCode hasta que el ROADMAP lo pida. Pasar datos con el segundo argumento de `view('carpeta.vista', ['clave' => $valor])`.
- Escritura: `Model::create($data)`, `$modelo->update($data)`, `$modelo->delete()`.
- `$data` es lo que devuelve `$request->validate()`, como `$credentials` en `AuthController`. No se usa `$_POST` ni `$request->input()` para guardar. El docente guarda con `$request->input()` en `MoviesController`, pero en `AuthController` ya usa el retorno de `validate()`; así solo se guardan campos validados.
- Después de crear, editar o borrar: `redirect()->route('...')->with('feedback.message', '...')`.
- PHPDoc en la clase y en los métodos públicos. El docente no los escribe porque comenta para la cursada; el parcial los evalúa.

## Modelos

Referencia: `proyecto-docente/app/Models/Movie.php`.

- Heredan de `Model`.
- La tabla es el plural en inglés y snake_case (`services`, `posts`). Si se cumple eso, no se declara `$table`.
- La PK es `id`. No se copia `movie_id` ni `$primaryKey`.
- `$fillable` lista solo los campos que el formulario puede asignar en masa.
- El precio de un servicio se guarda en centavos (`unsignedInteger`) y se lee en pesos con `Attribute::make`. Se escribe como la versión activa de `Movie::price()`: argumentos por nombre y arrow functions (`get: fn ($value) => $value / 100`, `set: fn ($value) => $value * 100`).
- No se usa el atributo `#[Fillable]` de Laravel 13 en los modelos nuestros. El docente escribe `protected $fillable` en `Movie`. `User.php` queda como viene (él sí usa `#[Fillable]` ahí).
- Relaciones: el docente define un método por relación. 1:n referenciante = `belongsTo(Modelo::class, 'fk', 'pk')`. n:n = `belongsToMany(...)` con tabla pivot y nombres de FKs. **No se copian** `Rating` / `Genre`. La contratación del paso 27 es n:n usuario–servicio (`users_have_services`, FKs `user_fk` y `service_fk` a `id`). `User::services()` y `Service::users()`. La fila se carga en el seeder. No hay `attach` / `sync` / `detach` en un controller: el parcial no pide un formulario de contratación.

## Migraciones y seeders

Referencia: `proyecto-docente/database/migrations/2026_08_25_231756_create_movies_table.php`, `2026_09_29_223250_add_cover_columns_to_movies_table.php`, `2026_10_06_222104_add_rating_fk_column_to_movies_table.php`, `2026_10_13_220802_create_movies_have_genres_table.php`, `MovieSeeder.php`, `UserSeeder.php`, `GenreSeeder.php`, `MovieHasGenreSeeder.php` y `DatabaseSeeder.php`.

- Migración anónima con `Schema::create` y `down()` que hace `Schema::dropIfExists`.
- Para cambiar una tabla que ya existe en una base con datos que hay que conservar, no se edita su migración: se crea una nueva con `Schema::table`, como `add_cover_columns_to_movies_table` o `add_rating_fk_column_to_movies_table`. El `down()` deshace el cambio (si el `up()` agrega columnas, el `down()` las quita con `dropColumn`, y al revés). Mientras RestoCode solo corra en local y no se haya entregado el 2do, se puede editar la migración original y recrear todo con `php artisan migrate:fresh --seed` (así se quitó `posts.image` en el 1er; para volver a poner imagen en el 2do, si la base no tiene datos que conservar, se puede sumar la columna en `create_posts_table` o con una migración `Schema::table`, copiando al docente).
- FKs: el docente usa `$table->foreign('rating_fk')->references('rating_id')->on('ratings')` y, en la pivot, `$table->foreignId('movie_fk')->constrained(table: 'movies', column: 'movie_id')` más `foreign()` para `genre_fk`. PK de pivot = combinación de las dos FKs. En RestoCode las PK siguen siendo `id`; no se copia `movie_id`. En `users_have_services`, `service_fk` es `unsignedBigInteger` y no `unsignedSmallInteger`: `services.id` es bigint, y el docente usa el entero chico solo porque `genre_id` es `smallIncrements`.
- Toda tabla de negocio cierra con `$table->timestamps()`.
- La tabla `users` se deja como viene (`0001_01_01_000000_create_users_table.php`) y no se edita esa migración. La consigna permite usarla. Tiene `id`, `name`, `email`, `password`, `remember_token` y fechas; `name` es obligatorio, así que el seeder lo completa. El paso 24 agrega `role` (`string`) con una migración `Schema::table`. Valores: `administrador` y `usuario`. Es la excepción del parcial: el docente nunca agregó la columna. No se crea una tabla de roles.
- Los seeders insertan con `DB::table('...')->insert([...])` y completan `created_at` y `updated_at` con `now()`, como `MovieSeeder`. El `UserSeeder` del docente no las completa; en RestoCode se completan en todos para que ninguna fecha quede en `null`.
- Las contraseñas se guardan con `Hash::make`, como en `UserSeeder`.
- `DatabaseSeeder` los llama con `$this->call([...])`, con `UserSeeder` primero.
- La carga inicial tiene que poder repetirse con `php artisan migrate:fresh --seed`.

## Base de datos

- Motor MySQL. El docente usa MariaDB (`DB_CONNECTION=mariadb` y `DB_ENGINE=InnoDB` en su `.env`); su `.env.example` sigue con SQLite. Los dos motores funcionan igual con estas migraciones.
- `DB_DATABASE` se llama `apellido_nombre` (o `apellido1_apellido2` si el trabajo es en grupo), sin prefijos. Un nombre como `dw3_apellido1_apellido2` no cumple la consigna y puede restar un punto.
- `users`: la tabla de Laravel (`id`, `name`, `email`, `password`, ...) más `role` (`string`: `administrador` o `usuario`), agregada en el paso 24.
- `services`: `id`, `title`, `short_description`, `full_description`, `price`, `delivery_days`, `is_active`, `created_at`, `updated_at`. Es la tabla que cumple los cinco campos que pide la consigna.
- `posts`: `id`, `title`, `summary`, `content`, `image` (string nullable), `image_description` (string nullable), `published_at`, `created_at`, `updated_at`. `image` es el path en el disk `public` (`posts/...`), copiando el patrón de `cover`, no el nombre `cover`. `image_description` copia `cover_description` con el nombre del dominio. Las cards de "Novedades" de la home no usan `posts.image`. La foto de `public/img` va arriba con proporción 4/3 (`object-cover`): la entrada del menú QR usa `card-2.webp`, la de reservas `card-3.webp` y la de la web `card-1.webp`. Debajo, el texto queda en un bloque con fondo liso `bg-zinc-900`, texto blanco y padding propio, para que no quede apretado contra la foto. `hero.webp` sigue en disco y la vista no lo carga.

## Vistas

Referencia: `proyecto-docente/resources/views/components/layouts/main.blade.php`, `welcome.blade.php`, `auth/login.blade.php` y `resources/views/movies/`.

- Toda página usa un componente de layout: `<x-layouts.main>` en el sitio y en el login, `<x-layouts.admin>` en el panel.
- El título va en `<x-slot:title>`.
- Imprimir con `{{ }}`. No usar `{!! !!}` para datos que vienen de la base.
- Listados con `@foreach`.
- Para mostrar solo algunos registros (por ejemplo, los servicios activos), el controller pasa `Model::all()` y la vista los separa con `@if` dentro del `@foreach`. Son las dos directivas que usa el docente (`@foreach` en `movies/index.blade.php`, `@if` en el layout `main`).
- El sitio público no muestra acciones de alta, edición ni baja. Esas acciones viven en el admin. En el docente están en el listado de películas, envueltas en `@auth`, porque ese listado hace de panel.
- `@auth` / `@else` / `@endauth` para mostrar algo según haya sesión, y `auth()->user()->email` para mostrar quién entró, como en el nav del docente.
- El botón de cerrar sesión es un `<form method="post">` con un `<button>`, no un enlace. Va en el layout admin.
- Borrar es una vista de confirmación, como `movies/delete.blade.php`. El GET no borra.
- HTML semántico: `header`, `nav`, `main`, `section`, `article`, `footer`. Datos de detalle con `<dl>`, como `movies/show.blade.php`.
- El layout admin del docente todavía mezcla `url()` y PHP pelado. En RestoCode se escribe con `route()` y `{{ }}`, como el layout `main`.

## Formularios, validación y feedback

Referencia: `movies/create.blade.php`, `movies/edit.blade.php`, `auth/login.blade.php`, `MoviesController@store` y `AuthController@processForm`.

- Todo POST lleva `@csrf`. Es una excepción al docente, que no lo escribe: en Laravel 13 el middleware `PreventRequestForgery` acepta el POST sin token cuando el navegador manda `Sec-Fetch-Site: same-origin`, y eso pasa en `localhost` o con HTTPS. Si el proyecto se sirve por HTTP con otro dominio (por ejemplo `http://restocode.test`), el navegador no manda ese header y, sin `@csrf`, Laravel responde 419.
- Reglas en el controller, como string `'required|min:2'` o como array. El segundo argumento de `validate()` son los mensajes en español, con la clave `campo.regla`.
- Si hay errores, un aviso general cuando `$errors->any()`, con utilidades de Tailwind (fondo y texto de error).
- Cada input: `@class` que suma borde y texto de error si `$errors->has('campo')`, `old('campo')` en el value, y `@error('campo')` para el mensaje.
- Accesibilidad, como el docente: dentro de `@error('campo')` el input suma `aria-invalid="true"` y `aria-errormessage="error-campo"`, y el mensaje de error lleva `id="error-campo"`.
- En edición, `old('campo', $modelo->campo)`.
- El feedback viaja en sesión con la clave `feedback.message` y se muestra una sola vez, con el aviso del layout, igual que en `main.blade.php`. Si no es un éxito, se suma `feedback.type` (`danger`); el layout elige los colores según el tipo y usa éxito por defecto.
- Credenciales incorrectas no son un error de validación: se vuelve al login con `feedback.message`, `feedback.type` `danger` y `->withInput()`, como `AuthController@processForm`.

## CSS

Referencia: `resources/css/app.css`, `vite.config.js` y el `@vite` de `main.blade.php`.

- Tailwind 4 entra con `@import 'tailwindcss'` en `resources/css/app.css`.
- Cada layout lo carga con `@vite(['resources/css/app.css', 'resources/js/app.js'])`. El admin usa el mismo llamado.
- Las clases de las vistas son utilidades de Tailwind. Lo que no sea una utilidad suelta se escribe en `resources/css/app.css`.
- Íconos con Lucide (paquete `lucide` de npm). En `resources/js/app.js` se importa `createIcons` junto con cada ícono que se usa, y en la vista se escribe `<i data-lucide="nombre-del-icono"></i>`. Solo se registran los íconos que aparecen en las vistas. Un enlace que solo tiene un ícono lleva `aria-label`.
- En desarrollo, `pnpm dev`. Para el zip, `pnpm build` e incluir `public/build/`: `.gitignore` lo excluye, y sin esa carpeta el sitio queda sin estilos.

## Autenticación

Referencia: `proyecto-docente/app/Http/Controllers/AuthController.php`, `database/seeders/UserSeeder.php`, `resources/views/auth/login.blade.php`, `bootstrap/app.php` y las rutas con `->middleware('auth')`.

- `UserSeeder` crea el usuario admin con `DB::table('users')->insert()` y `Hash::make`.
- `AuthController` tiene cinco métodos: `showForm` (muestra el login), `processForm` (valida y entra), `processLogout` (sale), `showRegisterForm` (muestra el registro) y `processRegister` (valida, crea el usuario e inicia la sesión).
- `processForm` guarda en `$credentials` lo que devuelve `$request->validate()` (`email` y `password`) y llama a `Auth::attempt($credentials)`, que es la versión activa del docente (las variantes con el array armado a mano quedan comentadas). Si falla, vuelve al login con el feedback de error. Si entra, redirige a `admin.posts.index` con el feedback de bienvenida.
- `processRegister` (paso 25) valida `name` (`required`), `email` (`required|email|unique:users,email`) y `password` (`required`), sin confirmación de contraseña. `$data` sale de `validate()`; después se hashea la contraseña con `Hash::make` y se asigna `role` `usuario`. Se guarda con `User::create($data)`. `Auth::attempt` recibe la contraseña en claro (el cast `hashed` de `User` no vuelve a hashear un valor que ya es un hash) y `$request->session()->regenerate()` deja la sesión abierta. El éxito redirige a `home`. `unique:users,email` es la única regla que no está en la cursada ni en `proyecto-docente`. Las rutas `/registro` no llevan middleware.
- Al entrar se llama a `$request->session()->regenerate()`. Es una excepción al docente, que no lo hace: la documentación de Laravel lo pide para evitar la fijación de sesión, igual que el docente sigue esa documentación en el logout.
- `processLogout` hace `Auth::logout()`, `$request->session()->invalidate()` y `$request->session()->regenerateToken()`, y vuelve al login con feedback.
- Las rutas del ABM llevan el middleware `auth` de Laravel, una por una, como crear, editar y eliminar de `movies` (paso 20). El listado del docente queda público porque es el catálogo; en RestoCode `admin.posts.index` también lleva `auth` porque el catálogo es `/blog`.
- En el `withMiddleware` de `bootstrap/app.php` se configura `$middleware->redirectGuestsTo(fn () => route('auth.login.form'))`, para que un visitante sin sesión vaya a `/admin/login`.
- Middleware **propio** (paso 26): el docente registra un alias en el mismo `withMiddleware` (`'over18' => EnsureIsOver18YearsOld::class`) y lo aplica con `->middleware('over18')`. La clase tiene `handle(Request $request, Closure $next)` y, si deja seguir, `return $next($request)`. RestoCode copia esa estructura en `EnsureIsAdministrator` con alias `administrator`. La condición mira `Auth::user()->role`: si es `administrador`, sigue; si no, redirige a `home` con `feedback.message` «No tenés permisos de administrador para acceder al panel.» y `feedback.type` `danger`. No se copia `is_over_18` ni `AgeVerificationController`. Las rutas del panel conservan `auth` y suman el alias.

## Subida de archivos

Referencia: `MoviesController@store` / `update` / `destroy` y `2026_09_29_223250_add_cover_columns_to_movies_table.php`.

El 1er parcial no lo pedía y se sacó `posts.image`. El 2do sí (paso 23): columna `image` string nullable, migración `Schema::table` `add_image_column_to_posts_table`.

- `if ($request->hasFile('image')) { $data['image'] = $request->file('image')->store('posts', 'public'); }` — disk `public` también en `update`.
- Al editar o borrar, si había archivo viejo: `Storage::disk('public')->exists` + `Storage::disk('public')->delete`. El disk default de Laravel 13 es `local`; sin `'public'` no se encuentra el archivo.
- En las vistas, `asset('storage/' . $post->image)`. `Storage::url()` arma la URL con `APP_URL`; en local eso queda en `http://localhost` y no coincide con `php artisan serve` (`:8000`). `exists` / `delete` siguen en `Storage::disk('public')`.
- El zip de entrega **no** incluye el link `public/storage`. `storage:link` es local.
- Junto al archivo va `image_description` (`nullable|max:255`), el texto opcional del docente para `cover_description`. El `alt` de la foto usa ese texto. `published_at` no está en el formulario: no hay filtro de fechas futuras, así que `store` la asigna con `now()->toDateString()` y `update` no la cambia.

## Nombres y responsabilidad

- Clases, métodos y variables con nombres que digan qué son. Español o inglés, el mismo criterio en todo el archivo.
- Una clase, una razón para cambiar. El controller no arma el schema. El modelo no redirige. La vista no valida.
- Comentarios de clase solo donde el parcial los pide (PHPDoc) o donde una línea no se entiende sola. No se copian al proyecto los comentarios largos de cursada que explican Laravel dentro de `proyecto-docente`.
