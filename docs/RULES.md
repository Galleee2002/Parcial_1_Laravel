# Reglas de RestoCode

Estas reglas pueden cambiar cuando el docente suba clases nuevas. Si una clase contradice una regla de acá, gana la clase: se actualiza este archivo y el paso que corresponda en [ROADMAP.md](ROADMAP.md).

Acá está cómo se escribe el código. El orden de las features está en [ROADMAP.md](ROADMAP.md).

La fuente de verdad es `proyecto-docente`. No se agrega una técnica que esa carpeta no muestre y que el parcial no pida. El dominio (qué páginas y qué tablas) sale de [PRD.md](PRD.md) y de la consigna del parcial.

## Qué no se usa

Hasta que el docente lo muestre en una clase:

- Breeze, Jetstream y los controllers de autenticación que trae Laravel.
- Form Requests. La validación es `$request->validate()` en el controller.
- Verbos PUT y DELETE. El formulario se muestra con GET y se procesa con POST.
- Atributos de validación en el HTML (`required`, `min`, `max`). Los inputs pueden usar `type` (`text`, `date`, `password`).
- Vite como camino del CSS. El diseño se enlaza desde `public/css`.
- Subida de archivos. En el docente la portada está marcada como "coming soon". `posts.image` es un string nullable.

## Rutas

Referencia: `proyecto-docente/routes/web.php`.

- Una ruta por llamado a `Route`, con el array `[Controller::class, 'metodo']` y `->name()`.
- El parámetro dinámico se escribe `{id}` y lleva `->whereNumber('id')`.
- Las rutas con un segmento fijo (`crear`, `listado`) se declaran de forma que `{id}` no las capture.
- Enlaces con `route('nombre', ['id' => $modelo->id])`, no con URLs armadas a mano.
- Nombres: `services.index`, `services.show`, `blog.index`, `blog.show`, `admin.posts.index`, `admin.posts.create`, `admin.posts.store`, `admin.posts.edit`, `admin.posts.update`, `admin.posts.delete`, `admin.posts.destroy`, `admin.login`, `admin.login.store`, `admin.logout`.

## Controllers

Referencia: `proyecto-docente/app/Http/Controllers/MoviesController.php` y `HomeController.php`.

- La clase extiende `Controller` y el nombre termina en `Controller`.
- Un controller por responsabilidad. La home no lista el ABM. El ABM de entradas no renderiza el sitio público.
- Lectura: `Model::all()`, `find` o `findOrFail`. Pasar datos con el segundo argumento de `view('carpeta.vista', ['clave' => $valor])`.
- Escritura: `Model::create($data)`, `$modelo->update(...)`, `$modelo->delete()`.
- `$data` sale de la validación, no de `$_POST`.
- Después de crear, editar o borrar: `redirect()->route('...')->with('feedback.message', '...')`.
- PHPDoc en la clase y en los métodos públicos.

## Modelos

Referencia: `proyecto-docente/app/Models/Movie.php`.

- Heredan de `Model`.
- La tabla es el plural en inglés y snake_case (`services`, `posts`). Si se cumple eso, no se declara `$table`.
- La PK es `id`. No se copia `movie_id`.
- `$fillable` lista solo los campos que el formulario puede asignar en masa.
- El precio de un servicio se guarda en centavos (`unsignedInteger`) y se lee en pesos con `Attribute::make`, igual que `Movie::price()`.
- No se usa el atributo `#[Fillable]` de Laravel 13 en los modelos nuestros. El docente escribe `protected $fillable`.

## Migraciones y seeders

Referencia: `proyecto-docente/database/migrations/2026_08_25_231756_create_movies_table.php`, `MovieSeeder.php` y `DatabaseSeeder.php`.

- Migración anónima con `Schema::create` y `down()` que hace `Schema::dropIfExists`.
- Toda tabla de negocio cierra con `$table->timestamps()`.
- La tabla `users` se deja como viene en el docente (`0001_01_01_000000_create_users_table.php`). La consigna permite usar esa migración. Tiene `id`, `email` y `password`.
- Los seeders insertan con `DB::table('...')->insert([...])` y completan `created_at` y `updated_at` con `now()`.
- `DatabaseSeeder` los llama con `$this->call([...])`.
- La carga inicial tiene que poder repetirse con `php artisan migrate:fresh --seed`.

## Base de datos

- Motor MySQL. En el `.env` del docente el default es SQLite; el parcial pide una base con nombre.
- `DB_DATABASE` se llama `apellido_nombre` (o `apellido1_apellido2` si el trabajo es en grupo).
- `services`: `id`, `title`, `short_description`, `full_description`, `price`, `delivery_days`, `is_active`, `created_at`, `updated_at`.
- `posts`: `id`, `title`, `summary`, `content`, `image`, `published_at`, `created_at`, `updated_at`.

## Vistas

Referencia: `proyecto-docente/resources/views/components/layouts/main.blade.php`, `welcome.blade.php` y `resources/views/movies/`.

- Toda página usa un componente de layout: `<x-layouts.main>` en el sitio y `<x-layouts.admin>` en el panel.
- El título va en `<x-slot:title>`.
- Imprimir con `{{ }}`. No usar `{!! !!}` para datos que vienen de la base.
- Listados con `@foreach`.
- El sitio público no muestra acciones de alta, edición ni baja. Esas acciones viven en el admin. En el docente están en el listado de películas porque ese listado es el panel.
- Borrar es una vista de confirmación, como `movies/delete.blade.php`. El GET no borra.
- HTML semántico: `header`, `nav`, `main`, `section`, `article`, `footer`.
- El layout admin del docente todavía mezcla `url()` y PHP pelado. En RestoCode se escribe con `route()` y `{{ }}`, como el layout `main`.

## Formularios, validación y feedback

Referencia: `movies/create.blade.php`, `movies/edit.blade.php` y `MoviesController@store`.

- Todo POST lleva `@csrf`. Los formularios del docente no lo tienen; sin esa línea Laravel 13 responde 419 y el `store` no corre.
- Reglas en el controller, como string `'required|min:2'` o como array. El segundo argumento de `validate()` son los mensajes en español, con la clave `campo.regla`.
- Si hay errores, un `alert` general cuando `$errors->any()`.
- Cada input: `@class` con `is-invalid` si `$errors->has('campo')`, `old('campo')` en el value, y `@error('campo')` para el mensaje.
- En edición, `old('campo', $modelo->campo)`.
- El éxito viaja en sesión con la clave `feedback.message` y se muestra una sola vez, con el `alert` del layout, igual que en `main.blade.php`.

## CSS

Referencia: `proyecto-docente/public/css/style.css` y el `<link>` de `main.blade.php`.

- Bootstrap desde `public/css/bootstrap.min.css`.
- Lo propio va en `public/css/style.css`.
- Los `<link>` usan `url('css/...')`.

## Autenticación (provisoria)

El docente todavía no implementó el login. En `Movie.php` quedó un TODO. Hasta que suba esa clase, el acceso al admin se hace así:

- Un seeder crea el usuario. La contraseña se hashea con `Hash::make`, como en `database/factories/UserFactory.php`.
- El controller de login es nuestro. Busca por email y verifica con `Hash::check`.
- Si entra, regenera la sesión y guarda `user_id` con `session()`.
- El middleware propio mira `session()->has('user_id')`. Si no está, redirige a `admin.login`.
- El alias se registra en el `withMiddleware` de `bootstrap/app.php`, que en el docente está vacío.
- Solo las rutas del ABM llevan ese middleware. `/admin/login` queda afuera.
- Cuando la clase de login exista, esta sección y los pasos 16 a 19 de [ROADMAP.md](ROADMAP.md) se reemplazan por lo que muestre esa clase.

## Nombres y responsabilidad

- Clases, métodos y variables con nombres que digan qué son. Español o inglés, el mismo criterio en todo el archivo.
- Una clase, una razón para cambiar. El controller no arma el schema. El modelo no redirige. La vista no valida.
- Comentarios de clase solo donde el parcial los pide (PHPDoc) o donde una línea no se entiende sola. No se copian al proyecto los comentarios largos de cursada que explican Laravel dentro de `proyecto-docente`.
