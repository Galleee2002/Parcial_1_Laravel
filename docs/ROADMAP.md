# Roadmap de RestoCode

Este orden puede cambiar cuando el docente suba clases nuevas. Si una clase trae otra implementación, se reemplaza el paso de este archivo y la regla correspondiente en [RULES.md](RULES.md). Los pasos 17 a 20 ya siguen el login que el docente implementó en `AuthController`.

Acá está en qué orden se construye cada feature. Cómo se escribe el código está en [RULES.md](RULES.md). No se pasa al paso siguiente si el anterior no se puede abrir en el navegador.

El proyecto es la raíz de este repositorio, en Laravel 13. `proyecto-docente` no se modifica ni se entrega: es la referencia de cómo escribe el docente (está en `.gitignore`). En disco es el corte de octubre, extraído de `proyecto.rar`: login, `cover`, middleware de edad y géneros. El inventario está en [SEGUNDO_PARCIAL.md](SEGUNDO_PARCIAL.md). El dominio sale de [PRD.md](PRD.md): servicios para locales gastronómicos y un blog. El admin administra entradas; el 2do suma registro, rol, middleware de administrador, contratación y listado de usuarios en los pasos 24 a 29. No se implementa un paso hasta que se pida.

Lo que el docente muestra y la consigna no pide queda afuera: verificación de edad, mails de reserva, Bootstrap. Lo que el 2do pide se arma con sintaxis ya usada en RestoCode o inventariada en ese archivo (upload de `cover`, `belongsToMany`, middleware propio + alias), con el dominio de RestoCode. El paso 20 ya protege el ABM con `auth` y `redirectGuestsTo`. El rol, el registro, el middleware de administrador y la contratación son los pasos 24 a 28.

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

Cinco servicios (menú QR, landing, pedidos online, menú QR multilenguaje y web con reservas); el último, la web con reservas, tiene `is_active` falso. Los activos van primero para que la numeración de la home (`$loop->iteration`) quede correlativa. `DB::table()->insert()` + `now()`, registrado en `DatabaseSeeder`.

## 4. Listado de servicios — hecho

`/servicios` con `ServicesController@index` (`Service::all()`), ruta `services.index` y vista `services/index.blade.php`: título, descripción corta, precio en pesos, días de entrega y enlace al detalle. Sin botones de alta, edición ni baja.

## 5. Detalle de un servicio — hecho

`/servicios/{id}` con `ServicesController@show` (`Service::findOrFail`), ruta `services.show` con `whereNumber('id')` y vista `services/show.blade.php`: título, descripciones corta y completa, precio, días de entrega y enlace de vuelta al listado. El enlace del listado usa `route('services.show', ['id' => ...])`. Un id inexistente o no numérico responde 404.

## 6. Home con servicios activos — hecho

`HomeController@index` pasa `Service::all()` a `home.blade.php`, que suma debajo del hero la lista de servicios: el mismo `@foreach` de `services/index.blade.php` con `@if ($service->is_active)` adentro, con `h2` para la sección y `h3` por fila. Cada fila es un `<article>` horizontal sin fondo propio, separado con `border-b`: número (`0{{ $loop->iteration }}`, en `text-blue-600` como el botón del hero), título, descripción corta y un enlace circular al detalle con el ícono `arrow-up-right` de Lucide y `aria-label`. Al pasar el mouse, la fila se pone en `bg-zinc-900` con `group` / `group-hover:`. Precio y días de entrega quedan para `/servicios`. El botón del hero usa `route('services.index')`. El controller tiene PHPDoc. El servicio inactivo del seeder no aparece en `/`.

## 7. Migración y modelo Post — hecho

Tabla `posts` con `title` (`string` de 100), `summary` (`string`), `content` (`text`), `image` (`string` nullable), `published_at` (`date`, como `release_date`) y `timestamps`. PK `id`. Modelo `Post` con `protected $fillable` de los cinco campos, sin accessors. `image` no lo pide la consigna y se quitó en el paso 14.

Probar: `php artisan migrate` crea `posts`.

## 8. PostSeeder — hecho

Tres entradas sobre digitalización gastronómica (menú QR, reservas online, web del local) con `published_at` distintas. `DB::table()->insert()` + `now()`, registrado en `DatabaseSeeder` después de `ServiceSeeder`. `php artisan migrate:fresh --seed` deja cinco servicios y tres entradas.

## 9. Listado público del blog — hecho

`/blog` con `PostsController@index` (`Post::all()`), controller de lectura separado del futuro `AdminPostsController`, ruta `blog.index` y vista `blog/index.blade.php`: un `<article>` por entrada con título (`h2`), fecha de publicación en `<time datetime>`, resumen y enlace al detalle. Del patrón `movies/index.blade.php` se toman el `@foreach` y los enlaces; la tabla queda para el admin y el listado usa tarjetas como `services/index.blade.php`. Sin `@auth` ni botones de alta, edición o baja. El nav del layout `main` pasa a `route('blog.index')`. El enlace al detalle usa `url('/blog/' . $post->id)` hasta que exista `blog.show` en el paso 10, como pasó con servicios entre los pasos 4 y 5.

## 10. Detalle de una entrada — hecho

`/blog/{id}` con `PostsController@show` (`Post::findOrFail`, con PHPDoc), ruta `blog.show` con `whereNumber('id')` y vista `blog/show.blade.php`: enlace de vuelta al blog, título, resumen, fecha de publicación en `<dl>` con `<time datetime>` y contenido con `whitespace-pre-line` para respetar los saltos de línea sin `{!! !!}`. Sigue el patrón de `movies/show.blade.php` con las clases de `services/show.blade.php`, sin la portada. El enlace de `blog/index.blade.php` pasa a `route('blog.show', ['id' => $post->id])`. Un id inexistente o no numérico responde 404.

## 11. Home con las últimas tres entradas — hecho

`HomeController@index` suma `Post::orderBy('published_at', 'desc')->limit(3)->get()` y lo pasa a `home.blade.php` como `posts`, con el PHPDoc actualizado. Es la excepción a la regla de no ordenar ni limitar que está en [RULES.md](RULES.md): el parcial pide "las últimas 3 entradas" y con `Post::all()` + `@if` no se puede saber cuáles son las más recientes. Se ordena por `published_at` porque el seeder carga todas las entradas con el mismo `now()`. Debajo de los servicios, la home suma la sección "Novedades" (`h2`): un `<article>` cuadrado (`aspect-square`) por entrada con fecha en `<time datetime>`, título (`h3`) y resumen. Toda la card es un enlace a `route('blog.show', ['id' => $post->id])`: el `<a>` va dentro del `<article>` con `h-full` y, al pasar el mouse, subraya el título con `group-hover:underline`; más el enlace "Ver todas las entradas" a `route('blog.index')`. El fondo de cada card es una imagen fija de `public/img` elegida por posición (`card-{{ $loop->iteration }}.webp`, en `style="background-image: ..."`), con un degradado oscuro abajo para leer el texto, como el hero. No sale de la base ni se sube desde el admin: es decoración de la home. Si falta la imagen, queda el fondo `bg-zinc-900`. Sin `@if` en la vista: el controller ya pasa solo tres entradas. Con el seeder se ven, en orden, las del 2026-09-20, 2026-09-02 y 2026-08-10.

## 12. Layout admin y tabla de entradas — hecho

`/admin/posts` con `AdminPostsController@index` (`Post::all()`, con PHPDoc), controller separado de `PostsController`, ruta `admin.posts.index` con `->middleware('auth')` desde el paso 20 y vista `admin/posts/index.blade.php`: tabla con título, fecha de publicación en `<time datetime>` y acciones Ver (`route('blog.show', ['id' => $post->id])`), Editar y Eliminar, más el botón "Publicar una nueva entrada". La tabla y los botones salen de `movies/index.blade.php`. El layout `components/layouts/admin.blade.php` sigue el del docente pasado a `route()` como el layout `main`, con el mismo `@vite`, nav lateral con `aria-current` y el aviso de `feedback.message` de [RULES.md](RULES.md). Los enlaces de crear, editar y eliminar usaron `url()` hasta que existieron `admin.posts.create`, `admin.posts.edit` y `admin.posts.delete` en los pasos 13, 15 y 16, como pasó con el blog entre los pasos 9 y 10. Con el seeder, la tabla lista las tres entradas.

## 13. Alta de una entrada — hecho

`/admin/posts/crear` con `AdminPostsController@create` (muestra el formulario) y `AdminPostsController@store` (valida y guarda), ambos con PHPDoc, rutas GET y POST `admin.posts.create` y `admin.posts.store`, y vista `admin/posts/create.blade.php` con `<x-layouts.admin>`. Sigue el patrón de `MoviesController@store` y `movies/create.blade.php`: campos `title`, `summary`, `content`, `image` (texto; se quitó en el paso 14) y `published_at` (`type="date"`); aviso general con `$errors->any()`; cada input con `@class` para el borde de error, `old('campo')`, `@error` con `aria-invalid` y `aria-errormessage`, y el mensaje con `id="error-campo"`. El formulario lleva `@csrf`. `$data` es lo que devuelve `$request->validate()` con mensajes en español; el docente usa `$request->input()`, pero en `AuthController` ya toma el retorno de `validate()` en `$credentials`. Se guarda con `$post = Post::create($data)` y se redirige a `admin.posts.index` con `feedback.message` armado con `$post->title`, como el docente con `$movie->title`. El botón "Publicar una nueva entrada" del listado pasa a `route('admin.posts.create')`. Guardar una entrada válida vuelve al listado con el mensaje de éxito; un campo vacío vuelve al formulario con el error y los datos escritos.

## 14. Sacar `image` de las entradas — hecho

La consigna no pide imagen en las entradas, así que la columna y el campo del formulario se quitaron. Como el proyecto solo corre en local y todavía no se entregó, se borró la línea `$table->string('image')->nullable()` de `create_posts_table` en vez de sumar una migración con `Schema::table`, y se recreó la base con `php artisan migrate:fresh --seed`. También se quitó `image` del `$fillable` de `Post`, de las tres filas de `PostSeeder`, de las reglas y mensajes de `AdminPostsController@store` y del input de `admin/posts/create.blade.php`. `posts` queda con `id`, `title`, `summary`, `content`, `published_at` y fechas.

## 15. Edición — hecho

`/admin/posts/{id}/editar` con `AdminPostsController@edit` (`Post::findOrFail`, muestra el formulario) y `AdminPostsController@update` (valida y actualiza), ambos con PHPDoc, rutas GET y POST `admin.posts.edit` y `admin.posts.update` con `whereNumber('id')`, y vista `admin/posts/edit.blade.php` con `<x-layouts.admin>`. Sigue el patrón de `MoviesController@edit`/`update` y `movies/edit.blade.php`, sin la parte de la portada (`hasFile`, `store`, `Storage::delete` y la imagen actual). Como el docente, `update` repite las reglas de `store` y valida antes de buscar la entrada; después hace `$post->update($data)` y redirige a `admin.posts.index` con `feedback.message` armado con `$post->title`. El formulario es el de alta con `@csrf`, `action` a `route('admin.posts.update', ['id' => $post->id])` y cada value con `old('campo', $post->campo)`; `published_at` llega como string `Y-m-d`, que es lo que espera `type="date"`. El enlace "Editar" del listado pasa a `route('admin.posts.edit', ['id' => $post->id])`. Editar vuelve al listado con el mensaje de éxito; un título vacío vuelve al formulario con el error y lo escrito, sin tocar la fila; un id inexistente o no numérico responde 404.

## 16. Confirmación y baja — hecho

`/admin/posts/{id}/eliminar` con `AdminPostsController@delete` (`Post::findOrFail`, muestra la confirmación) y `AdminPostsController@destroy` (borra), ambos con PHPDoc, rutas GET y POST `admin.posts.delete` y `admin.posts.destroy` con `whereNumber('id')`, y vista `admin/posts/delete.blade.php` con `<x-layouts.admin>`. Sigue el patrón de `MoviesController@delete`/`destroy` y `movies/delete.blade.php`, sin el borrado de la portada con `Storage` ni el TODO de relaciones. La vista muestra "Confirmación necesaria", el título (`h2`), resumen y fecha de publicación en un `<dl>` con `<time datetime>`, el contenido con `whitespace-pre-line` y el aviso de que la acción es irreversible; el `<form method="post">` lleva `@csrf`, el botón "Eliminar" y un enlace "Cancelar" a `admin.posts.index`, como el formulario de edición. `destroy` hace `$post = Post::findOrFail($id)`, `$post->delete()` y redirige a `admin.posts.index` con `feedback.message` armado con `$post->title`, que sigue en memoria después de borrar la fila, como `$movie->title` en el docente. El enlace "Eliminar" del listado pasa a `route('admin.posts.delete', ['id' => $post->id])`. El GET solo muestra la confirmación y la entrada sigue en la tabla; el POST la borra y vuelve al listado con el mensaje de éxito; un id inexistente o no numérico responde 404; `/blog` no tiene botón de borrado.

## 17. Usuario admin — hecho

`database/seeders/UserSeeder.php` carga el usuario del panel con `DB::table('users')->insert()`: `id` 1, `name` "Admin RestoCode", `email` `admin@restocode.com` y `password` con `Hash::make('restocode')`. Sigue el `UserSeeder` del docente; como él no carga `created_at` ni `updated_at`, acá se suman con `now()`, como en `MovieSeeder` y en los otros seeders, para que ninguna fecha quede en `null`. El email y la contraseña de prueba quedan en un comentario del seeder para poder explicarlos. `email_verified_at` y `remember_token` quedan en `null`. La tabla `users` y el modelo `User` no se modifican. `UserSeeder` va primero en el `$this->call([...])` de `DatabaseSeeder`, antes de `ServiceSeeder` y `PostSeeder`. `php artisan migrate:fresh --seed` deja un usuario, cinco servicios y tres entradas, y `Hash::check('restocode', $user->password)` da `true`. Entrar con ese usuario se prueba en el paso 18.

## 18. Login — hecho

`/admin/login` con `AuthController@showForm` (muestra el formulario) y `AuthController@processForm` (valida e inicia la sesión), ambos con PHPDoc, rutas GET y POST `auth.login.form` y `auth.login.process` sin middleware, y vista `auth/login.blade.php` con `<x-layouts.main>`. El docente usa la URL `/iniciar-sesion`; acá va bajo `/admin` con los mismos nombres de ruta. Sigue el patrón de `AuthController@processForm` y `auth/login.blade.php` del docente: `$credentials = $request->validate(...)` con `email` (`required|email`) y `password` (`required`), con mensajes en español porque la consigna pide informar los errores, y `Auth::attempt($credentials)`, que es la versión activa del docente. Si falla, vuelve a `auth.login.form` con `feedback.message`, `feedback.type` `danger` y `->withInput()`, que no reenvía la contraseña. Si entra, `$request->session()->regenerate()` (excepción al docente, ver [RULES.md](RULES.md)) y redirección a `admin.posts.index` con "Sesión iniciada con éxito. ¡Hola de nuevo!". El formulario sigue el patrón de `admin/posts/create.blade.php`: aviso general con `$errors->any()`, `@class`, `@error` con `aria-invalid` y `aria-errormessage`, `@csrf`, `old('email')` (la contraseña no se rellena) y `novalidate`, porque el email usa `type="email"`. El aviso de credenciales incorrectas lo muestra el bloque de `feedback.message` del layout `main`. Campos vacíos muestran "El email es obligatorio." y "La contraseña es obligatoria."; un email sin formato muestra su error; una contraseña incorrecta vuelve con el aviso rojo y el email escrito; `admin@restocode.com` / `restocode` llega a `/admin/posts` con el mensaje de bienvenida y la cookie de sesión cambia. El nav público no enlaza al login: se entra escribiendo `/admin/login`. Desde el paso 20, `/admin/posts` sin sesión redirige a `/admin/login`.

## 19. Logout — hecho

`AuthController@processLogout` (con PHPDoc) y ruta POST `/admin/logout` con el nombre `auth.logout.process`, sin middleware. El docente usa la URL `/cerrar-session`; acá va bajo `/admin` con el mismo nombre de ruta. Sigue el patrón de `AuthController@processLogout` del docente: `Auth::logout()`, `$request->session()->invalidate()`, `$request->session()->regenerateToken()` y redirección a `auth.login.form` con "Sesión cerrada con éxito. ¡Te esperamos pronto!", que el bloque de `feedback.message` del layout `main` muestra en verde. El botón es un `<li>` nuevo en el nav del layout `admin`, debajo de "Ver sitio": un `<form method="post">` con `@csrf` y un `<button>` con `auth()->user()->email` en el texto. Va dentro de `@auth`, como el nav del docente. Desde el paso 20 el ABM no se renderiza sin sesión, así que ese layout solo llega con usuario. Con sesión, el nav muestra "admin@restocode.com (Cerrar sesión)"; al hacer clic, el POST responde 302 a `/admin/login` con el aviso de salida; después, el panel ya no se abre. Que `/admin/posts` no abra sin sesión quedó probado en el paso 20.

## 20. Protección del admin — hecho

Las ocho rutas `admin.posts.*` de `routes/web.php` llevan `->middleware('auth')`, una por una. En el docente, crear, editar y eliminar de `movies` llevan ese middleware; el listado (`movies.index`) queda público porque es el catálogo. Acá el catálogo es `/blog`, así que `admin.posts.index` también lleva `auth`. En `bootstrap/app.php`, `withMiddleware` configura `$middleware->redirectGuestsTo(fn () => route('auth.login.form'))`, igual que el docente. Se usa el middleware `auth` de Laravel; no se escribe uno propio ni se copia el alias `over18`. Login y logout siguen sin `auth`, para no armar un bucle con esa redirección.

Sin sesión, el listado, crear, editar y eliminar (GET y POST) responden 302 a `/admin/login` y el POST no escribe. Con `admin@restocode.com` / `restocode` el ABM lista, crea, edita y borra, y el logout vuelve al login. `/`, `/servicios` y `/blog` siguen públicos. Un id no numérico del ABM sigue en 404. `/admin/login` sigue abriendo.

## 21. Entrega

Este checklist es la entrega del 1er parcial. Después del paso 23, `posts` volvió a tener `image` y los formularios del ABM suben archivos: el ítem que dice lo contrario quedó viejo. La entrega del 2do es el paso 29.

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

### Footer del sitio público — hecho

El footer del layout `main` era una sola línea de texto. Ahora cierra todas las páginas que usan `<x-layouts.main>` (home, servicios, blog y login) con el mismo estilo oscuro del header y del hero. El panel conserva su footer propio en el layout `admin`.

Archivos: `resources/views/components/layouts/main.blade.php` y `resources/js/app.js`.

Patrón: `<footer>` con `bg-zinc-900 text-white` y el contenedor `mx-auto max-w-6xl px-4` del header. Arriba, una banda (`<section>`) con `h2` "¿Listo para digitalizar tu local?" y el botón "Ver servicios" a `route('services.index')`, con las mismas clases que el botón del hero. Debajo, tres columnas: la marca con la tagline del hero; un `<nav aria-label="Pie de página">` con Inicio, Servicios y Blog (`route()` y `hover:text-blue-300`, como el nav del header); y un `<address>` con datos de contacto ficticios (email con `mailto:`, teléfono con `tel:` y ciudad) acompañados por los íconos `mail`, `phone` y `map-pin` de Lucide con `aria-hidden="true"`, registrados en `app.js` como pide [RULES.md](RULES.md). Cierra una barra con `© {{ date('Y') }} RestoCode`. Todo es estático: no se lee la base ni se toca ningún controller.

Probar: `/`, `/servicios`, `/servicios/{id}`, `/blog`, `/blog/{id}` y `/admin/login` muestran el footer con los íconos, en columnas en desktop y apilado en mobile. `/admin/posts` sigue con el footer del panel.

## Segundo parcial

No se implementa un paso hasta que se pida en el turno. El orden de abajo junta piezas que ya están en `proyecto-docente` (corte de octubre) o en RestoCode. Esa carpeta no trae registro, columna de rol ni usuario–servicio. Si una clase trae otro orden o otra sintaxis, se reemplaza el paso y la regla en [RULES.md](RULES.md).

No se agregan confirmación de contraseña, ABM de usuarios, proceso de compra, `attach` / `sync` / `detach` en un controller, verificación de edad, mails ni `paginate`.

### 22. Proteger el admin con `auth` — hecho

Es el paso 20, ya aplicado: `->middleware('auth')` en cada `admin.posts.*` y `$middleware->redirectGuestsTo(fn () => route('auth.login.form'))`. El 2do pide además un middleware personalizado de administrador: el rol es el paso 24 y el middleware, el 26. Este corte usa el `auth` de Laravel, como el docente, y no adelanta el chequeo de rol.

### 23. Imágenes en las entradas — hecho

Migración `2026_11_02_100000_add_image_column_to_posts_table` con `Schema::table`: columna `image` (`string` nullable). `Post::$fillable` suma `image`. El seeder no carga archivos: las entradas seed quedan sin imagen, como las películas del docente sin `cover`.

`AdminPostsController@store` y `update` copian el patrón de `MoviesController`: después de `validate()`, `if ($request->hasFile('image')) { $data['image'] = $request->file('image')->store('posts', 'public'); }`. `$data` sigue saliendo de `validate()`. En `update` se guarda `$oldImage` antes de actualizar; si llegó un archivo nuevo y el viejo existe en el disk `public`, `Storage::disk('public')->delete($oldImage)`. `destroy` borra la fila y, si había archivo, lo elimina del mismo disk. No se copia `DB::transaction` (eso es de la pivot de géneros). El `store()` de `update` usa disk `'public'` (el docente a veces lo omite). `exists` / `delete` / `url` van con `Storage::disk('public')` porque en Laravel 13 el disk default es `local`.

Formularios de alta y edición: `enctype="multipart/form-data"`, `type="file"` `name="image"` con `@class` / `@error` / `aria-*`. En edición, bloque “Imagen actual” como `movies/edit.blade.php` y la ayuda “Solo seleccioná una nueva imagen si querés reemplazar la actual”. `blog/show.blade.php` muestra la foto con `asset('storage/' . $post->image)` o “Sin imagen.”, como `movies/show.blade.php`. `exists` / `delete` van con `Storage::disk('public')`; `asset()` se usa en el `src` porque `Storage::url()` concatena `APP_URL` y en local no coincide con `artisan serve`. El listado admin, `/blog` y la confirmación de baja no muestran la imagen. Las cards de “Novedades” de la home siguen con `public/img/card-{n}.webp`.

No se copiaron `cover` / `cover_description`. El zip no incluye `public/storage`; `php artisan storage:link` es local.

### 24. Rol — hecho

Migración nueva con `Schema::table` sobre `users`, igual que `2026_11_02_100000_add_image_column_to_posts_table`. No se edita `0001_01_01_000000_create_users_table`. Columna `role` (`string`). Valores: `administrador` y `usuario`. No hay tabla de roles. Excepción documentada: el parcial pide dos roles y el docente nunca agregó la columna; la técnica es la de agregar una columna a una tabla que ya existe.

`UserSeeder` deja a `admin@restocode.com` / `restocode` (`id` 1, `name` "Admin RestoCode") con `role` `administrador` y suma un usuario común `usuario@restocode.com` / `restocode` (`id` 2, `name` "Usuario RestoCode") con `role` `usuario`. Sigue `DB::table('users')->insert()` y `Hash::make`, con `created_at` y `updated_at` en `now()`. `email_verified_at` y `remember_token` quedan en `null`. En `User`, el `#[Fillable]` de Laravel suma `role`. Sin middleware en este paso.

Probar: `php artisan migrate:fresh --seed` deja los dos usuarios con el rol que corresponde. El login de `admin@restocode.com` sigue abriendo `/admin/posts`.

### 25. Registro — hecho

Formulario público en `/registro`, con `AuthController@showRegisterForm` y `AuthController@processRegister` (PHPDoc), rutas GET y POST `auth.register.form` y `auth.register.process`, sin middleware, y vista `auth/register.blade.php` con `<x-layouts.main>`. No es un controller de autenticación de Laravel: son dos métodos más en el `AuthController` que ya tiene el login.

Campos: nombre, email y contraseña. Misma estructura que `auth/login.blade.php`: `$request->validate()` con mensajes en español, `@csrf`, `novalidate`, `@class`, `@error` y `aria-*`. Reglas: `name` obligatorio, `email` con `required|email|unique:users,email`, `password` obligatorio. `unique:users,email` es la única regla que no está en la cursada ni en `proyecto-docente`; el índice `unique` de la migración de `users` no es esa regla. Sin confirmación de contraseña.

Se guarda con `User::create` (como `Post::create`) y `Hash::make` (como `UserSeeder`). El `role` del registro es `usuario`. Después, `Auth::attempt` y `$request->session()->regenerate()` dejan la sesión abierta, como el login. La redirección va a `home` con `feedback.message`: el registrado es usuario común y el panel queda para el administrador (paso 26).

Probar: un email nuevo llega a `/` con sesión iniciada. El mismo email otra vez vuelve al formulario con el error de email repetido. Un campo vacío vuelve con su mensaje y lo escrito. `admin@restocode.com` no se puede volver a registrar.

### 26. Middleware de administrador — hecho

Clase `EnsureIsAdministrator` con `handle(Request $request, Closure $next)`. Si el rol es `administrador`, `return $next($request)`. Si no, redirige a `home` con `feedback.message` «No tenés permisos de administrador para acceder al panel.» y `feedback.type` `danger`. Alias `administrator` en el `withMiddleware` de `bootstrap/app.php`. La estructura se copia de `proyecto-docente/app/Http/Middleware/EnsureIsOver18YearsOld.php`. No se copia la verificación de edad ni `AgeVerificationController`. La condición mira `Auth::user()->role`.

Cada ruta `admin.posts.*` conserva `->middleware('auth')` y suma `->middleware('administrator')`. El `auth` sigue mandando al invitado a `/admin/login` con `redirectGuestsTo`. El alias corre con el usuario ya autenticado. Login, logout y registro no lo llevan.

Probar: sin sesión, `/admin/posts` responde 302 a `/admin/login`. Con `usuario@restocode.com` / `restocode`, responde 302 a `/` con el aviso de que no es administrador y el POST no escribe. Con `admin@restocode.com` / `restocode` el ABM sigue andando. `/`, `/servicios`, `/blog` y `/registro` siguen públicos.

### 27. Contratación — no hecho

Relación n:n entre usuarios y servicios, con la sintaxis inventariada de géneros (`belongsToMany`, tabla pivot, FKs). No se copian `genres`, `movies_have_genres` ni las PK `movie_id` / `genre_id`. La pivot es `users_have_services`, con FKs a `users.id` y `services.id`, y `timestamps`. En `User`, método `services()`. En `Service`, método `users()`.

La fila se carga solo con `DB::table()->insert()` y `now()` en un seeder registrado en `DatabaseSeeder`: el usuario `usuario@restocode.com` queda con un servicio activo. Al menos un usuario con un servicio contratado, como pide el parcial. Sin `attach`, `sync` ni `detach` en un controller: no hay formulario de contratación. Sin proceso de compra.

Probar: `php artisan migrate:fresh --seed` deja esa fila. El usuario común tiene un servicio; el administrador, ninguno. Todavía no hay pantalla: el listado es el paso 28.

### 28. Listado y detalle de usuarios — no hecho

`/admin/usuarios` con `AdminUsersController@index` (`User::all()`, con PHPDoc) y `/admin/usuarios/{id}` con `AdminUsersController@show` (`User::findOrFail`, con PHPDoc). Rutas `admin.users.index` y `admin.users.show`, esta última con `whereNumber('id')`. Las dos llevan `->middleware('auth')` y `->middleware('administrator')`. Vistas `admin/users/index.blade.php` y `admin/users/show.blade.php` con `<x-layouts.admin>`.

El listado es una tabla al estilo de `admin/posts/index.blade.php`: nombre, email, rol y un enlace al detalle. El detalle muestra esos datos y los servicios de la relación (`$user->services`), con título y precio en pesos. Sin alta, edición ni baja de usuarios. Sin `with`, `orderBy` ni `paginate`.

Probar: con `admin@restocode.com` se ven los dos usuarios y, en el detalle del usuario común, el servicio del paso 27. El detalle del administrador no muestra servicios. Con `usuario@restocode.com`, las dos URLs responden 302 a `/`. Sin sesión, responden 302 a `/admin/login`. Un id inexistente o no numérico responde 404.

### 29. Entrega del 2do — no hecho

`datos.txt` en la raíz con carácter “2do parcial”, con el texto que pide [PRD.md](PRD.md). Renombrar la base en MySQL y en `DB_DATABASE` del `.env` a `apellido1_apellido2` (hoy es `dw3_kuringhian_garcia`) y correr `php artisan migrate:fresh --seed`.

Zip sin `proyecto-docente`, sin `docs/`, sin `AGENTS.md` y sin el link `public/storage`. `php artisan storage:link` queda en local. `public/build/` entra después de `pnpm build`. El nombre del zip es `apellido-nombre_apellido2-nombre2.zip` (o `apellido-nombre.zip` si es individual).
