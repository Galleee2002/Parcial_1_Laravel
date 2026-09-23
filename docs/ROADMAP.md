# Roadmap de RestoCode

Este orden puede cambiar cuando el docente suba clases nuevas. Si una clase trae otra implementación (por ejemplo el login), se reemplaza el paso de este archivo y la regla correspondiente en [RULES.md](RULES.md). Hasta entonces, los pasos 16 a 19 quedan provisorios.

Acá está en qué orden se construye cada feature. Cómo se escribe el código está en [RULES.md](RULES.md). No se pasa al paso siguiente si el anterior no se puede abrir en el navegador.

La base es `proyecto-docente` (Laravel 13). El skeleton Laravel 10 de la raíz no se usa. El dominio sale de [PRD.md](PRD.md): servicios para locales gastronómicos y un blog. El admin solo administra entradas.

Equivalencia con el ABM de películas del docente:

- La lectura de `movies` pasa a ser `services` (`/servicios` y `/servicios/{id}`). Sin ABM.
- El ABM de `movies` pasa al admin de `posts` (`/admin/posts`), con el layout `admin`.
- El listado público del blog no lleva editar ni eliminar. Esos botones quedan solo en el admin.

`services` tiene, sin contar `id` ni las fechas de Laravel: `title`, `short_description`, `full_description`, `price`, `delivery_days`, `is_active`.

## 1. Proyecto listo y home estática

Dejar Laravel 13 andando, con la base `apellido_nombre` en MySQL, y una home que solo presente el sitio.

Archivos: `.env`, `resources/views/components/layouts/main.blade.php`, `resources/views/home.blade.php`, `app/Http/Controllers/HomeController.php`, `routes/web.php`, `resources/css/app.css`. El layout carga Tailwind con `@vite`. En desarrollo, `npm run dev`.

Patrón: `HomeController@index` y `<x-layouts.main>` de `proyecto-docente/resources/views/welcome.blade.php` y `components/layouts/main.blade.php`. La nav queda en Inicio, Servicios y Blog.

Probar: `php artisan migrate` y abrir `/`. Se ve el hero, la nav y el footer.

## 2. Migración y modelo Service

Crear la tabla y el modelo, con el precio guardado en centavos.

Archivos: `database/migrations/*_create_services_table.php`, `app/Models/Service.php`.

Patrón: migración de `movies` y `Movie::price()` con `Attribute::make`. La PK es `id`, como pide el PRD. Reglas de modelo en [RULES.md](RULES.md).

Probar: `php artisan migrate` crea `services`.

## 3. ServiceSeeder

Cargar al menos tres servicios gastronómicos (menú QR, landing y web con reservas). Uno puede ir con `is_active` en falso para probar el filtro de la home más adelante.

Archivos: `database/seeders/ServiceSeeder.php`, `database/seeders/DatabaseSeeder.php`.

Patrón: `MovieSeeder` con `DB::table()->insert()` y `now()`, llamado con `$this->call()`.

Probar: `php artisan migrate:fresh --seed` y ver filas en `services`. El precio en la tabla está en centavos.

## 4. Listado de servicios

Mostrar los servicios en `/servicios`.

Archivos: `ServicesController@index`, ruta `services.index`, `resources/views/services/index.blade.php`.

Patrón: `MoviesController@index` y `movies/index.blade.php`. Sin botones de alta, edición ni baja.

Probar: `/servicios` lista título, precio legible (el accessor divide por 100) y el enlace al detalle.

## 5. Detalle de un servicio

Mostrar un servicio en `/servicios/{id}`.

Archivos: `ServicesController@show`, ruta `services.show` con `whereNumber('id')`, `resources/views/services/show.blade.php`.

Patrón: `MoviesController@show` y `movies/show.blade.php`.

Probar: `/servicios/1` muestra la descripción completa. Un id inexistente responde 404 con `findOrFail`. Un segmento que no es número no entra en esta ruta.

## 6. Home con servicios activos

Sumar al hero la grilla de servicios con `is_active` verdadero.

Archivos: `HomeController@index`, `resources/views/home.blade.php`.

Patrón: el mismo `Model::all()` del listado, filtrando activos. La vista sigue usando `<x-layouts.main>`.

Probar: `/` muestra solo los servicios activos y el botón a `/servicios`. El servicio inactivo del seeder no aparece.

## 7. Migración y modelo Post

Crear `posts` con `title`, `summary`, `content`, `image` (nullable), `published_at` y `timestamps`.

Archivos: `database/migrations/*_create_posts_table.php`, `app/Models/Post.php`.

Patrón: migración de `movies`. `published_at` es un `date`, igual que `release_date`. `image` es un string nullable: el docente dejó la portada como "coming soon" y no se implementa subida de archivos.

Probar: `php artisan migrate` crea `posts`.

## 8. PostSeeder

Cargar al menos tres entradas sobre digitalización gastronómica.

Archivos: `database/seeders/PostSeeder.php`, `DatabaseSeeder.php`.

Patrón: `MovieSeeder`.

Probar: `php artisan migrate:fresh --seed` deja servicios y entradas.

## 9. Listado público del blog

Mostrar las entradas en `/blog`.

Archivos: `PostsController@index` (o un controller de lectura aparte del admin), ruta `blog.index`, `resources/views/blog/index.blade.php`.

Patrón: `movies/index.blade.php`, sin acciones de editar ni eliminar.

Probar: `/blog` lista título, resumen y enlace al detalle.

## 10. Detalle de una entrada

Mostrar una entrada en `/blog/{id}`.

Archivos: método `show`, ruta `blog.show` con `whereNumber('id')`, `resources/views/blog/show.blade.php`.

Patrón: `movies/show.blade.php`.

Probar: `/blog/1` muestra el contenido. Un id inexistente responde 404.

## 11. Home con las últimas tres entradas

En `/`, debajo de los servicios, mostrar las tres entradas más recientes.

Archivos: `HomeController@index`, `resources/views/home.blade.php`.

Patrón: la consulta del listado de películas, ordenada por `published_at` descendente y limitada a 3.

Probar: `/` muestra tres novedades y el enlace a `/blog`.

## 12. Layout admin y tabla de entradas

Armar el panel y el listado `/admin/posts`, todavía sin login.

Archivos: `resources/views/components/layouts/admin.blade.php`, `AdminPostsController@index`, ruta `admin.posts.index`, `resources/views/admin/posts/index.blade.php`.

Patrón: `components/layouts/admin.blade.php` del docente, pasado a `route()` como el layout `main`, con el mismo `@vite` y utilidades de Tailwind. La tabla y los botones salen de `movies/index.blade.php`. El aviso de éxito usa la misma clave `feedback.message` de [RULES.md](RULES.md).

Probar: `/admin/posts` lista las entradas con enlaces a crear, editar y eliminar.

## 13. Alta de una entrada

Formulario y guardado en `/admin/posts/crear`.

Archivos: `create`, `store`, rutas GET y POST `admin.posts.create` y `admin.posts.store`, `resources/views/admin/posts/create.blade.php`.

Patrón: `MoviesController@store` y `movies/create.blade.php`. Campos: `title`, `summary`, `content`, `image`, `published_at`. Validación, `old()`, `@error` y feedback según [RULES.md](RULES.md). Incluir `@csrf`.

Probar: guardar una entrada válida redirige al listado con el mensaje de éxito. Un campo vacío vuelve al formulario con el error y los datos escritos.

## 14. Edición

Formulario y actualización en `/admin/posts/{id}/editar`.

Archivos: `edit`, `update`, rutas GET y POST, `resources/views/admin/posts/edit.blade.php`.

Patrón: `MoviesController@update` y `movies/edit.blade.php`. Los values usan `old('campo', $post->campo)`.

Probar: editar cambia la fila y muestra el feedback. Un dato inválido no pisa el registro.

## 15. Confirmación y baja

Pantalla de confirmación y borrado en `/admin/posts/{id}/eliminar`.

Archivos: `delete`, `destroy`, rutas GET y POST, `resources/views/admin/posts/delete.blade.php`.

Patrón: `movies/delete.blade.php` y `MoviesController@destroy`.

Probar: el GET solo muestra la confirmación. El POST borra y vuelve al listado con el feedback. No hay botón de borrado en `/blog`.

## 16. Usuario admin (provisorio)

Cargar un usuario para entrar al panel. Se reescribe si la clase de login trae otro seeder.

Archivos: `database/seeders/UserSeeder.php`, `DatabaseSeeder.php`.

Patrón: `DB::table()->insert()` de `MovieSeeder`. La contraseña se guarda con `Hash::make`, como en `database/factories/UserFactory.php` del docente. La tabla `users` no se modifica.

Probar: `php artisan migrate:fresh --seed` crea el usuario. Anotar email y contraseña de prueba en un comentario del seeder para poder explicarlos.

## 17. Login (provisorio)

Pantalla `/admin/login` y acción que guarda el usuario en sesión. Se reemplaza por la clase de login cuando exista.

Archivos: `LoginController` con el formulario y el `store`, rutas `admin.login` y `admin.login.store`, `resources/views/admin/login.blade.php`.

Patrón de formulario: `movies/create.blade.php` (`validate`, mensajes, `old()`, `@error`, `@csrf`). La sesión usa `session()`, el helper que el layout `main` del docente ya explica. Buscar el usuario por email y comprobar la contraseña con `Hash::check`. Si falla, volver atrás con un error. Si entra, regenerar la sesión y guardar `user_id`.

Probar: credenciales malas muestran el error. Credenciales buenas llegan a `/admin/posts`.

## 18. Logout (provisorio)

Cerrar la sesión y volver al login.

Archivos: método de logout en `LoginController`, ruta POST `admin.logout`, botón en el layout admin.

Patrón: `redirect()->route()` y el manejo de `session()` ya usado en el layout del docente.

Probar: después de salir, `/admin/posts` no se abre y pide el login (cuando el paso 19 esté).

## 19. Middleware del admin (provisorio)

Cortar `/admin/posts` si no hay `user_id` en la sesión. No protege el login. Se reemplaza si la clase registra el middleware de otra forma.

Archivos: `app/Http/Middleware/EnsureUserIsAuthenticated.php`, alias en el `withMiddleware` de `bootstrap/app.php`, `->middleware()` en las rutas del ABM.

Patrón: el callback `withMiddleware` de `proyecto-docente/bootstrap/app.php` está vacío y es el lugar para registrarlo. Adentro solo se mira `session()->has('user_id')` y, si no está, `redirect()->route('admin.login')`.

Probar: sin sesión, crear, editar, eliminar y el listado redirigen a `/admin/login`. Con sesión, el ABM sigue funcionando. `/`, `/servicios` y `/blog` siguen públicos.

## 20. Entrega

Archivo `datos.txt` en la raíz, con el texto que pide [PRD.md](PRD.md). Completar carrera, cuatrimestre, año, turno, comisión y apellido y nombre.

Checklist antes de comprimir:

- Home con hero, servicios activos y tres novedades.
- `/servicios` y `/servicios/{id}` leen la base.
- `/blog` y `/blog/{id}` leen la base.
- `/admin/login` es propio: sin Breeze, Jetstream ni controllers de autenticación de Laravel.
- ABM de entradas con validación en PHP, errores en la vista y feedback de éxito.
- Tres tablas creadas y cargadas con migraciones y seeders. Base llamada `apellido_nombre`.
- `services` tiene más de cinco campos sin contar `id` ni `created_at` / `updated_at`.
- HTML semántico, estilos con Tailwind cargados por Vite (`public/build/` incluido en el zip), PHPDoc en controllers y métodos clave.
- El zip se llama `apellido-nombre.zip` y contiene el proyecto más `datos.txt`.
