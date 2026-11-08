# Segundo parcial — contexto y proyecto del docente

Este archivo es el inventario de `proyecto-docente/` (rar del 27-oct-2026, extraído en esa carpeta) frente a la consigna del segundo parcial. No implementa features. El orden para armar lo que esa carpeta no trae está en [ROADMAP.md](ROADMAP.md), pasos 24 a 29.

Cómo se escribe el código: [RULES.md](RULES.md). Orden de pasos: [ROADMAP.md](ROADMAP.md). Snapshot del primero: [PRIMER_PARCIAL.md](PRIMER_PARCIAL.md).

Si una clase nueva contradice esto, gana la clase y se actualizan RULES / ROADMAP / este archivo.

## 1. Fuente de verdad

1. `proyecto-docente/` (local, gitignoreada). Corte de octubre. Copiar la técnica **activa**, no las alternativas comentadas. No se modifica ni se entrega.
2. `docs/Portales y Comercio Electrónico - Segundo Parcial.pdf`.
3. RULES / ROADMAP / PRD, cuando una clase los actualice.

Misma lógica que el primer parcial: el docente enseña **sintaxis y estructura** (controllers, migraciones, Eloquent, middleware). RestoCode cambia el **dominio** (gastronomía, `services`, `posts`, URLs bajo `/admin`) y deja las diferencias documentadas para no entregar un clon.

`proyecto-docente` en disco es el Laravel de películas de octubre: login, `cover`, middleware de edad, `ratings` y géneros. No trae registro, rol ni usuario–servicio.

## 2. Equivalencia con el docente (sigue del 1er)

| Docente | RestoCode |
|---|---|
| Lectura de `movies` | `services` en `/servicios` y `/servicios/{id}`. Sin ABM. |
| ABM de `movies` | admin de `posts` en `/admin/posts`, layout `admin`. |
| Login `/iniciar-sesion`, logout `/cerrar-session` | `/admin/login` y `/admin/logout`. Nombres de ruta iguales: `auth.login.form`, `auth.login.process`, `auth.logout.process`. |
| PK `movie_id` / `rating_id` / `genre_id` | PK `id`. No se copia `$primaryKey`. |
| Bootstrap en `public/css` | Tailwind por Vite. |
| Comentarios largos de cursada | No se copian. El parcial pide PHPDoc. |

## 3. Inventario de `proyecto-docente` (27-oct-2026)

El inventario de abajo es esa carpeta. Los archivos se leen ahí.

### Ya se usó en el 1er (sigue igual)

- `AuthController`: `showForm`, `processForm` con `Auth::attempt($credentials)` (versión activa), `processLogout` con `invalidate` + `regenerateToken`. El docente **no** llama `session()->regenerate()` al entrar; RestoCode sí (excepción ya justificada).
- ABM de `movies` con GET+POST, `whereNumber`, `findOrFail`.
- `Movie::price()` activo: `Attribute::make(get: fn ($value) => $value / 100, set: fn ($value) => $value * 100)`.
- `UserSeeder`: `sara@za.com` / `asdasd` con `Hash::make`, sin `created_at` / `updated_at`. RestoCode completa las fechas.

### Nuevo respecto al cierre del 1er

**`redirectGuestsTo` y `auth` en el ABM.** En `bootstrap/app.php`: `$middleware->redirectGuestsTo(fn () => route('auth.login.form'))`. En el docente, crear, editar y eliminar de películas llevan `->middleware('auth')`; el listado público no, porque es el catálogo. En RestoCode el paso 20 ya está aplicado: las ocho rutas `admin.posts.*`, incluido el listado, llevan `auth`, y el invitado va a `/admin/login`. No se copió el alias `over18`.

**Middleware propio + alias.** Clase `EnsureIsOver18YearsOld` con `handle(Request $request, Closure $next)`. Alias en `withMiddleware`: `'over18' => EnsureIsOver18YearsOld::class`. La ruta `movies.show` usa `->middleware('over18')`. El contenido mira `$request->route('movie')`, `rating_fk === 4` y la sesión `is_over_18`; si no, redirige a verificación de edad. **La consigna no pide verificación de edad:** se copia el *patrón* (clase, alias, `return $next($request)`), no la regla de +18.

**Upload de archivos.** Migración `add_cover_columns_to_movies_table`: `cover` y `cover_description` nullable. En `store`/`update`: `if ($request->hasFile('cover')) { $data['cover'] = $request->file('cover')->store('covers', 'public'); }` (en update el `store` a veces va sin disk `public`; la versión activa a documentar al implementar es la de `store` con `'public'`). Al actualizar o borrar, si hay archivo viejo: `Storage::exists` + `Storage::delete`. El 2do parcial **sí** pide alta/modificación de imágenes en el blog. Cuando se implemente, el patrón va a `posts`, no a `movies.cover`.

**Relación 1:n.** Tabla `ratings` (`rating_id` tinyIncrements, `name`, `abbreviation`). Migración que agrega `rating_fk` a `movies` con `$table->foreign('rating_fk')->references('rating_id')->on('ratings')`. En `Movie`: `belongsTo(Rating::class, 'rating_fk', 'rating_id')`. Modelo `Rating` con `$primaryKey = 'rating_id'`.

**Relación n:n.** Tablas `genres` (`genre_id` smallIncrements, `name`) y pivot `movies_have_genres` (`movie_fk`, `genre_fk`, timestamps, PK compuesta). En `Movie`: `belongsToMany(Genre::class, 'movies_have_genres', 'movie_fk', 'genre_fk', 'movie_id', 'genre_id')`. Escritura: `attach` al crear, `sync` al editar, `detach` al borrar. Seeders `GenreSeeder` y `MovieHasGenreSeeder` con `DB::table()->insert()`.

**Eager load, orderBy, paginate.** `Movie::with(['rating', 'genres'])->paginate(2)` y `Genre::orderBy('name')->get()`. El RULES del 1er decía no filtrar/ordenar/limitar. El docente **ya lo muestra**. RestoCode no lo copia hasta que un paso del ROADMAP lo pida.

**Mail y reserva.** `MoviesReservationController@registerReservation` envía `MovieReserved` con `Mail::to(Auth::user())->send(...)`. Ruta POST `/peliculas/{id}/reservar` con `auth`. **No está en la consigna.** No se copia.

**Otras piezas del rar que no se portan:** layouts con Bootstrap, `public/css/bootstrap.min.css`, `lang/en` y `lang/es` (parcial), vistas vendor de paginación, `_ide_helper.php`, `database.sqlite`, `.env` local del docente.

### Lo que el rar no trae (faltan clases)

- Registro de usuarios.
- Campo o tabla de roles (usuario común vs administrador).
- Middleware que verifique **administrador** (solo está el de edad).
- Listado y detalle de usuarios en el admin.
- Servicio contratado o compras asociados a un usuario.
- Relaciones en el modelo `User` (sigue el Authenticatable de Laravel, con `#[Fillable]`, sin `belongsTo` / `hasMany`).

Esas cuatro cosas las pide el PDF y no vienen armadas. Se arman en los pasos 24 a 28 juntando piezas ya usadas, cuando se pida cada paso. No se espera otra clase.

Excepciones, porque no están en `proyecto-docente` ni en la cursada: columna `role` (`string`) en `users`, con `administrador` y `usuario`, vía `Schema::table` (no una tabla de roles); y la regla `unique:users,email` en el `validate` del registro. El índice `unique` de la migración de `users` no es esa regla. El dominio sale de la consigna. No se copian `ratings`, `genres` ni la verificación de edad.

## 4. Consigna del 2do vs lo que ya se puede copiar

Fuente: PDF del segundo parcial. Lo que se mantiene del 1er (sitio + admin, Blade, validación PHP, feedback, HTML semántico, Tailwind, DB `apellido1_apellido2`, migrations/seeders, PHPDoc) no se repite acá.

| Pedido del PDF | ¿El docente ya lo muestra? | Qué hacer en RestoCode |
|---|---|---|
| Registro y autenticación de usuarios (sin UI/controllers de auth de Laravel) | Auth de login sí. **Registro no.** | Hecho en el paso 25: `validate`, `Hash::make`, `User::create` y `Auth::attempt` en el `AuthController` propio. |
| Admin autenticado como **administrador** | `auth` de Laravel sí. Rol admin **no**. | Paso 24: columna `role` con `Schema::table`. No una tabla de roles. |
| Middleware **personalizado** que verifique al administrador | Patrón de middleware propio sí (`EnsureIsOver18YearsOld`). Contenido de rol **no**. | Hecho en el paso 26: misma estructura `handle` + alias `administrator`. Condición: `Auth::user()->role`. No se copió +18. |
| ABM del blog | Sí (ABM de `movies`). | Ya está en `admin/posts`. |
| Alta/modificación de **imágenes** en el blog | Sí (`cover`). | Hecho en el paso 23: `posts.image`, `store('posts', 'public')`. |
| Relaciones entre tablas y modelos relacionados | Sí (1:n rating, n:n géneros). | Hecho en el paso 27: `belongsToMany` usuario–servicio, pivot `users_have_services` y seeder. **No** se copiaron `ratings`/`genres`. Sin `attach`/`sync`/`detach` en un controller. |
| Listado de usuarios + detalle con servicio contratado o compras (seeders, sin proceso de compra) | **No.** Reserva por mail no es eso. | Hecho en el paso 28: `/admin/usuarios` y `/admin/usuarios/{id}`, sin ABM de usuarios. |
| Al menos un usuario con servicio contratado (seeders) | **No.** | Hecho en el paso 27: `usuario@restocode.com` con Menú QR Básico. |
| 2 roles: usuario común y administrador | **No.** | Paso 24. |
| Zip sin `public/storage` | El docente usa `storage/app/public/covers` y `public/storage/covers`. | La consigna lo prohíbe en el zip. `php artisan storage:link` es local; el enlace no se entrega. |
| `datos.txt` carácter “2do parcial” | — | Paso de entrega. |

## 5. Diferencias que hay que marcar (para no copiarse)

Obligatorias, iguales al 1er más las nuevas:

- Dominio gastronomía, no cine. Tablas `services` y `posts`, no `movies` / `ratings` / `genres`.
- PK `id`. No `movie_id`.
- `@csrf` en todo POST.
- `$data` = retorno de `validate()`, no `$request->input()`.
- `session()->regenerate()` al login.
- Fechas en todos los seeders con `now()`.
- Tailwind + Lucide, no Bootstrap.
- Layout admin con `route()` y `{{ }}`.
- No copiar verificación de edad, mails de reserva, comentarios de cursada, ni las vistas `movies/*`.
- Upload: campo `image` en `posts` (técnica de `cover`, no el nombre). Disk `public`. `exists` / `delete` con `Storage::disk('public')`. En el `src` de las vistas, `asset('storage/' . $post->image)`. No incluir el link `public/storage` en el zip.

## 6. Estado de RestoCode hoy

El código de la raíz es el primer parcial más el paso 20 (`auth` + `redirectGuestsTo`), el paso 23 (imagen en `posts`), el paso 24 (columna `role` en `users`, con `administrador` y `usuario`), el paso 25 (registro en `/registro`, rol `usuario`, sesión hacia `home`), el paso 26 (`EnsureIsAdministrator` con alias `administrator` en cada ruta `admin.posts.*`), el paso 27 (pivot `users_have_services`, `User::services()` y `Service::users()`, una fila de seeder) y el paso 28 (`AdminUsersController` en `/admin/usuarios` y `/admin/usuarios/{id}`, con `$user->services`).

Este archivo no autoriza a implementar el 2do. Cuando se pida un paso, se sigue el [ROADMAP.md](ROADMAP.md). La sintaxis activa se copia de `proyecto-docente`. Este inventario describe esa carpeta.
