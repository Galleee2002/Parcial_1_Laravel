# Reglas de RestoCode

Estas reglas pueden cambiar cuando el docente suba clases nuevas. Si una clase contradice una regla de acá, gana la clase: se actualiza este archivo y el paso que corresponda en [ROADMAP.md](ROADMAP.md).

Acá está cómo se escribe el código. El orden de las features está en [ROADMAP.md](ROADMAP.md).

La fuente de verdad es `proyecto-docente`. No se agrega una técnica que esa carpeta no muestre y que el parcial no pida. Cuando el docente deja una alternativa comentada y otra activa, se copia la activa. El dominio (qué páginas y qué tablas) sale de [PRD.md](PRD.md) y de la consigna del parcial.

Cuando el parcial obliga a apartarse del docente, la regla lo dice y explica por qué. Esas excepciones son pocas y se tienen que poder justificar en el coloquio.

## Qué no se usa

- Breeze, Jetstream, Fortify y los controllers de autenticación que trae Laravel. La consigna prohíbe "la interfaz de autenticación y controllers que Laravel provee". El controller de login es nuestro; `Auth::attempt` y el middleware `auth` sí se usan porque el docente los muestra.
- Form Requests. La validación es `$request->validate()` en el controller.
- Verbos PUT y DELETE. El formulario se muestra con GET y se procesa con POST.
- Validación del navegador. No se usan atributos como `required`, `min` o `max`. Los inputs pueden usar `type` (`text`, `email`, `date`, `password`); como `type="email"` activa la validación del navegador, el formulario que lo tenga lleva `novalidate`.
- Filtrar, ordenar o limitar consultas, ni con el Query Builder (`Model::where()`, `orderBy()`, `limit()`) ni con métodos de la `Collection` (`where`, `sortByDesc`, `take`). El docente no lo muestra. Ver "Vistas" para cómo se muestra solo una parte de un listado.
- Bootstrap y hojas en `public/css`. El docente todavía las usa, pero el parcial pide Tailwind cargado por Vite.
- Subida de archivos. En el docente la portada está marcada como "coming soon" y el `AuthController` la deja como TODO. `posts.image` es un string nullable.

## Rutas

Referencia: `proyecto-docente/routes/web.php`.

- Una ruta por llamado a `Route`, con el array `[Controller::class, 'metodo']` y `->name()`.
- El parámetro dinámico se escribe `{id}` y lleva `->whereNumber('id')`.
- Las rutas con un segmento fijo (`crear`, `listado`) se declaran de forma que `{id}` no las capture. Con `whereNumber('id')` alcanza.
- Enlaces con `route('nombre', ['id' => $modelo->id])`, no con URLs armadas a mano.
- Cada ruta del ABM lleva `->middleware('auth')`, una por una, como las de `movies` en el docente. Las rutas públicas y las del login no lo llevan.
- Nombres: `home`, `services.index`, `services.show`, `blog.index`, `blog.show`, `admin.posts.index`, `admin.posts.create`, `admin.posts.store`, `admin.posts.edit`, `admin.posts.update`, `admin.posts.delete`, `admin.posts.destroy`, `auth.login.form`, `auth.login.process`, `auth.logout.process`.

## Controllers

Referencia: `proyecto-docente/app/Http/Controllers/MoviesController.php`, `HomeController.php` y `AuthController.php`.

- La clase extiende `Controller` y el nombre termina en `Controller`.
- Un controller por responsabilidad. La home no lista el ABM. El ABM de entradas no renderiza el sitio público. El login vive en `AuthController`.
- Lectura: `Model::all()`, `find` o `findOrFail`. Pasar datos con el segundo argumento de `view('carpeta.vista', ['clave' => $valor])`.
- Escritura: `Model::create($data)`, `$modelo->update($data)`, `$modelo->delete()`.
- `$data` es lo que devuelve `$request->validate()`, como `$credenciales` en `AuthController`. No se usa `$_POST` ni `$request->input()` para guardar.
- Después de crear, editar o borrar: `redirect()->route('...')->with('feedback.message', '...')`.
- PHPDoc en la clase y en los métodos públicos. El docente no los escribe porque comenta para la cursada; el parcial los evalúa.

## Modelos

Referencia: `proyecto-docente/app/Models/Movie.php`.

- Heredan de `Model`.
- La tabla es el plural en inglés y snake_case (`services`, `posts`). Si se cumple eso, no se declara `$table`.
- La PK es `id`. No se copia `movie_id` ni `$primaryKey`.
- `$fillable` lista solo los campos que el formulario puede asignar en masa.
- El precio de un servicio se guarda en centavos (`unsignedInteger`) y se lee en pesos con `Attribute::make`. Se escribe como la versión activa de `Movie::price()`: argumentos por nombre y arrow functions (`get: fn ($value) => $value / 100`, `set: fn ($value) => $value * 100`).
- No se usa el atributo `#[Fillable]` de Laravel 13 en los modelos nuestros. El docente escribe `protected $fillable`. `User.php` queda como viene.

## Migraciones y seeders

Referencia: `proyecto-docente/database/migrations/2026_08_25_231756_create_movies_table.php`, `MovieSeeder.php`, `UserSeeder.php` y `DatabaseSeeder.php`.

- Migración anónima con `Schema::create` y `down()` que hace `Schema::dropIfExists`.
- Toda tabla de negocio cierra con `$table->timestamps()`.
- La tabla `users` se deja como viene (`0001_01_01_000000_create_users_table.php`). La consigna permite usarla. Tiene `id`, `name`, `email`, `password`, `remember_token` y fechas; `name` es obligatorio, así que el seeder lo completa.
- Los seeders insertan con `DB::table('...')->insert([...])` y completan `created_at` y `updated_at` con `now()`.
- Las contraseñas se guardan con `Hash::make`, como en `UserSeeder`.
- `DatabaseSeeder` los llama con `$this->call([...])`, con `UserSeeder` primero.
- La carga inicial tiene que poder repetirse con `php artisan migrate:fresh --seed`.

## Base de datos

- Motor MySQL. En el `.env` del docente el default es SQLite; el parcial pide una base con nombre.
- `DB_DATABASE` se llama `apellido_nombre` (o `apellido1_apellido2` si el trabajo es en grupo).
- `users`: la tabla de Laravel (`id`, `name`, `email`, `password`, ...).
- `services`: `id`, `title`, `short_description`, `full_description`, `price`, `delivery_days`, `is_active`, `created_at`, `updated_at`.
- `posts`: `id`, `title`, `summary`, `content`, `image`, `published_at`, `created_at`, `updated_at`.

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
- En desarrollo, `pnpm dev`. Para el zip, `pnpm build` e incluir `public/build/`: `.gitignore` lo excluye, y sin esa carpeta el sitio queda sin estilos.

## Autenticación

Referencia: `proyecto-docente/app/Http/Controllers/AuthController.php`, `database/seeders/UserSeeder.php`, `resources/views/auth/login.blade.php`, `bootstrap/app.php` y las rutas con `->middleware('auth')`.

- `UserSeeder` crea el usuario admin con `DB::table('users')->insert()` y `Hash::make`.
- `AuthController` tiene tres métodos: `showForm` (muestra el login), `processForm` (valida y entra) y `processLogout` (sale).
- `processForm` valida `email` y `password` y llama a `Auth::attempt(['email' => ..., 'password' => ...])`. Si falla, vuelve al login con el feedback de error. Si entra, redirige a `admin.posts.index` con el feedback de bienvenida.
- Al entrar se llama a `$request->session()->regenerate()`. Es una excepción al docente, que no lo hace: la documentación de Laravel lo pide para evitar la fijación de sesión, igual que el docente sigue esa documentación en el logout.
- `processLogout` hace `Auth::logout()`, `$request->session()->invalidate()` y `$request->session()->regenerateToken()`, y vuelve al login con feedback.
- Las rutas del ABM se protegen con el middleware `auth` de Laravel. No se escribe un middleware propio porque el docente usa el de Laravel.
- En el `withMiddleware` de `bootstrap/app.php` se configura `$middleware->redirectGuestsTo(fn () => route('auth.login.form'))`, para que un visitante sin sesión vaya a `/admin/login`.

## Nombres y responsabilidad

- Clases, métodos y variables con nombres que digan qué son. Español o inglés, el mismo criterio en todo el archivo.
- Una clase, una razón para cambiar. El controller no arma el schema. El modelo no redirige. La vista no valida.
- Comentarios de clase solo donde el parcial los pide (PHPDoc) o donde una línea no se entiende sola. No se copian al proyecto los comentarios largos de cursada que explican Laravel dentro de `proyecto-docente`.
