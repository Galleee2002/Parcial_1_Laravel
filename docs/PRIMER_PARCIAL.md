# Snapshot del primer parcial — RestoCode

Este archivo es el contexto durable del **primer parcial** para poder mejorar el **mismo proyecto** y cumplir el segundo. No implementa el segundo: solo registra lo que ya está en las consignas, en `docs/PRD.md`, `docs/ROADMAP.md`, `docs/RULES.md` y en el código de `origin/main`.

El 2do parcial vive en [SEGUNDO_PARCIAL.md](SEGUNDO_PARCIAL.md) y en las reglas vivas de RULES / ROADMAP / PRD (actualizadas cuando aparece una clase nueva). Este snapshot no se reescribe con esas clases.

Si una decisión no aparece en esas fuentes, queda como **pendiente del proyecto del docente**. No se asume.

## 1. Para qué existe este archivo

En la entrega del primer parcial se sacaron del zip los documentos de agentes (`AGENTS.md`, `CLAUDE.md`) y no se incluye `proyecto-docente`. Este snapshot existe para que, si se vuelven a sacar `docs/` u otros archivos de contexto, no se pierda:

- la consigna del primer parcial
- el dominio RestoCode
- las reglas con las que se escribió el código
- el inventario de lo que realmente quedó implementado
- los huecos respecto a esa misma consigna y al ROADMAP
- lo **nuevo** que pide el segundo parcial (checklist, sin diseño ni código)

**No va en el zip de Classroom.** Tampoco van `AGENTS.md`, `CLAUDE.md`, `docs/`, `proyecto-docente`, `node_modules`, `vendor` ni, en el segundo parcial, el link `public/storage`.

Las reglas vivas del código siguen en `docs/RULES.md` y `docs/ROADMAP.md`. Este archivo no las reemplaza: las congela tal como estaban al cierre del primer parcial.

Fuentes:

- `docs/Portales y Comercio Electrónico - Primer Parcial.pdf`
- `docs/Portales y Comercio Electrónico - Segundo Parcial.pdf`
- `docs/PRD.md`, `docs/ROADMAP.md`, `docs/RULES.md` de `origin/main` (`e8ba6f8`)
- el árbol de aplicación de ese mismo commit

## 2. Repo y estado git

- **Proyecto:** RestoCode (sitio de soluciones digitales para gastronomía).
- **Rama:** `main`.
- **Remote único:** `origin` → `https://github.com/Galleee2002/parcial_1_milagros_gael.git` (repo del grupo, no del docente).
- **No hay GitLab** ni un segundo remote del docente.
- **Autores en git:** Galle (`gaelgarcia.dev@gmail.com`) y Milagros Sol Kuringhian (`milagros.kuringhian@davinci.edu.ar`).
- **Docente de la materia (consigna / `datos.txt`):** Santiago Gallino.

### Copia local al momento de este snapshot

HEAD local: `7ade4e7` (22-sep-2026, Milagros) — tabla `services`, modelo, seeder, home estática. Historia local (5 commits):

```
7ade4e7 Table services / docs
3ce139e Tailwind
30beb1d Home controller
b982368 Upgrade a Laravel 13
b3400f1 First commit (gael)
```

Ese HEAD es ancestro de `origin/main`. **0 commits locales únicos.** Traer origin es un **fast-forward**, no un merge.

### Los 31 commits que hay que traer

`origin/main` está en `e8ba6f8` (04-oct-2026, Galle) — *View del blog mejorada a nivel frontend*.

Esos 31 commits son **del equipo**, no de Santiago Gallino. Cubren servicios, blog, ABM de posts, login/logout, Lucide, footer y ajustes de front.

Al traerlos, `docs/PRD.md`, `docs/ROADMAP.md`, `docs/RULES.md` y el PDF del primer parcial **no se borran**: se actualizan. Origin **sí elimina** `AGENTS.md`, `CLAUDE.md`, `package-lock.json` (pasa a `pnpm-lock.yaml`), `resources/views/welcome.blade.php` y `public/styles.css`.

`proyecto-docente` no está en el disco ni en el repo. Está en `.gitignore` (`/proyecto-docente`). Es la referencia de cómo escribe el docente; no se modifica ni se entrega.

## 3. Consigna del primer parcial

Fuente: `docs/Portales y Comercio Electrónico - Primer Parcial.pdf`. Profesor: Santiago Gallino.

**Tema libre** (excepto política o religión): web dinámica con blog / novedades / noticias y un producto o servicio a la venta o para contratación.

Que la entrega funcione es condición **necesaria pero no suficiente**.

### Sitio (usuarios)

- Ofrecer un servicio o producto. No hace falta carrito de compras.
- Sección de blog / novedades / noticias sobre el servicio o temas relacionados.
- Home que presente el producto.

### Admin

- Autenticación para acceder. **Prohibido** el uso de la interfaz de autenticación y controllers que Laravel provee.
- ABM para administrar las entradas del blog / novedades / noticias.

Ambos: HTML semántico (se evalúa) y CSS personalizado. Se puede usar Bootstrap o Tailwind.

### Base de datos

- Un integrante: `apellido_nombre`. Grupo: `apellido1_apellido2`.
- Al menos 3 tablas: usuarios, blog/novedades, servicios/productos.
- `users`: al menos `id`, `email`, `password`. Se puede usar la que trae Laravel.
- Al menos una de las otras tablas: 5 campos o más, sin contar PK ni fechas de Laravel.
- Creación de tablas y carga inicial **solo** con migrations y seeders.

### PHP / Laravel

- Versión actual de Laravel, POO, prácticas del framework.
- Vistas con Blade.
- Validar todos los ingresos e informar errores. **No** validación HTML.
- Mensajes de feedback.
- Se evalúa además: complejidad, accesibilidad / navegabilidad / usabilidad, tablas de relaciones extras, SRP y POO, nombres coherentes, HTML semántico, PHPDoc, estilización, uso de Models / Controllers / Middlewares, prolijidad.

### Entrega

Zip/rar `apellido-nombre.zip` o `apellido-nombre_apellido2-nombre2.zip` con el proyecto completo y `datos.txt` (carrera, materia, cuatrimestre, año, turno, comisión, apellido y nombre, docente, carácter: **1er Parcial**). Incumplir la modalidad puede restar al menos 1 punto. Puede haber preguntas orales sobre el código.

Uso de LLMs: no está permitido desarrollar la entrega con IA. Uso limitado para diseño y semántica. La responsabilidad final es del alumno.

## 4. Dominio RestoCode (PRD de origin)

Fuente: `docs/PRD.md` de `origin/main`.

Plataforma de soluciones digitales para restaurantes, bares, cafeterías y pizzerías. Sitio público con servicios (menú QR, web institucional, reservas), demos y blog. Panel restringido que administra el blog.

- **Objetivo comercial (ficción):** digitalizar locales, bajar costo de carta impresa, vender más con menú QR.
- **Objetivo académico:** MVC, Blade, Eloquent, validaciones PHP, autenticación propia, middlewares, migrations y seeders, según la materia.

### Sitio público (PRD)

- Home `/`: hero, servicios activos leídos de la base, últimas 3 entradas del blog.
- Servicios `/servicios` y `/servicios/{id}`: paquetes y detalle. En origin los paquetes del seeder son Menú QR Básico, Landing Gastronómica, Pedidos Online, Menú QR Multilenguaje, Web Premium + Reservas.
- Blog `/blog` y `/blog/{id}`: listado y detalle. Sin botones de editar ni eliminar.

### Admin (PRD)

- Login `/admin/login` propio (Controllers, Middlewares y sesiones; sin Breeze, Jetstream ni controllers de auth de Laravel).
- ABM `/admin/posts`: crear, editar, eliminar, listar.

### Tablas (PRD de origin, alineado al código)

- `users`: la de Laravel, sin modificar (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`).
- `services`: `id`, `title`, `short_description`, `full_description`, `price`, `delivery_days`, `is_active`, `created_at`, `updated_at`.
- `posts`: `id`, `title`, `summary`, `content`, `published_at`, `created_at`, `updated_at`. **Sin `image`.**

Tailwind (la consigna permite Bootstrap o Tailwind; se eligió Tailwind). Vite + `@vite`. PHPDoc en controllers y métodos clave.

## 5. Equivalencia con el proyecto del docente

Fuente: `docs/ROADMAP.md` de origin. La base es Laravel 13. `proyecto-docente` no se modifica ni se entrega.

El ABM de películas del docente se traduce así:

| Docente | RestoCode |
|---|---|
| Lectura de `movies` | `services` en `/servicios` y `/servicios/{id}`. Sin ABM. |
| ABM de `movies` | admin de `posts` en `/admin/posts`, layout `admin`. |
| Listado de películas con editar/eliminar | el listado público del blog **no** lleva esas acciones; quedan solo en el admin. |

Lo que el docente muestra y la consigna del primer parcial **no** pide, queda afuera. En el primer parcial se sacó la subida de archivos (`cover` de `movies` / `image` de `posts`). El ROADMAP anota que “tablas de relaciones extras” era TODO en el docente (`MoviesController@destroy`); cuando lo muestre, se evalúa sumar un paso. No se inventa esa relación.

El docente pone login en `/iniciar-sesion` y logout en `/cerrar-session`. En RestoCode van en `/admin/login` y `/admin/logout`; los **nombres de ruta** son los del docente (`auth.login.form`, `auth.login.process`, `auth.logout.process`).

## 6. Reglas vigentes al cierre del primer parcial

Fuente: `docs/RULES.md` de `origin/main`. Si una clase nueva contradice una regla, gana la clase y se actualizan RULES y ROADMAP.

Fuente de verdad: `proyecto-docente`. No se agrega una técnica que esa carpeta no muestre y que el parcial no pida. Si el docente deja una alternativa comentada y otra activa, se copia la **activa**. El dominio sale del PRD y de la consigna.

Cuando el parcial obliga a apartarse del docente, la regla lo dice y se tiene que poder justificar en el coloquio.

### Qué no se usa

- Breeze, Jetstream, Fortify y los controllers de autenticación que trae Laravel. El controller de login es nuestro. `Auth::attempt` y el middleware `auth` **sí** se usan porque el docente los muestra.
- Form Requests. Validación: `$request->validate()` en el controller.
- Verbos PUT y DELETE. Formulario con GET, proceso con POST.
- Validación del navegador (`required`, `min`, `max`). `type` sí (`text`, `email`, `date`, `password`). Si hay `type="email"`, el form lleva `novalidate`.
- Filtrar, ordenar o limitar consultas (`where`, `orderBy`, `limit`, o equivalentes de Collection), **salvo** las 3 novedades de la home (el parcial pide “las últimas 3 entradas” y con `Post::all()` + `@if` no se sabe cuáles son las más recientes). `HomeController` usa `Post::orderBy('published_at', 'desc')->limit(3)->get()`. El resto: `all()` y, si hace falta mostrar un subconjunto, `@if` en la vista.
- Bootstrap y hojas en `public/css`. Tailwind por Vite.
- Subida de archivos. El docente la muestra; el primer parcial no la pedía. `posts` no tiene `image`. Las cards de novedades de la home usan `public/img/card-1.webp` … `card-3.webp` por `$loop->iteration`: decoración, no un campo de la base.

### Rutas

- Un `Route` por llamado, `[Controller::class, 'metodo']`, `->name()`.
- Parámetro `{id}` con `->whereNumber('id')`.
- Enlaces con `route()`, no URLs armadas a mano.
- Cada ruta del ABM debería llevar `->middleware('auth')` de a una, como `movies` en el docente. **En el código de origin eso no está aplicado** (ver sección 8).
- Nombres: `home`, `services.index`, `services.show`, `blog.index`, `blog.show`, `admin.posts.index`, `admin.posts.create`, `admin.posts.store`, `admin.posts.edit`, `admin.posts.update`, `admin.posts.delete`, `admin.posts.destroy`, `auth.login.form`, `auth.login.process`, `auth.logout.process`.

### Controllers, modelos, persistencia

- Un controller por responsabilidad. Home no lista el ABM. El ABM no renderiza el sitio público. Login en `AuthController`.
- Lectura: `Model::all()`, `find` o `findOrFail` (salvo novedades de home). `view('carpeta.vista', ['clave' => $valor])`.
- Escritura: `Model::create($data)`, `$modelo->update($data)`, `$modelo->delete()`. `$data` es el retorno de `validate()`, no `$_POST` ni `$request->input()` para guardar.
- Después de crear/editar/borrar: `redirect()->route('...')->with('feedback.message', '...')`.
- PHPDoc en la clase y en los métodos públicos.
- Modelos: tabla plural inglés snake_case, PK `id`, `protected $fillable`. Precio de servicio en centavos (`unsignedInteger`) y accessor `Attribute::make` con `get:` / `set:` arrow functions, como la versión **activa** de `Movie::price()`. No usar `#[Fillable]` en modelos nuestros. `User.php` queda como viene.
- Seeders: `DB::table(...)->insert([...])` + `now()` en fechas. Contraseñas con `Hash::make`. `DatabaseSeeder` llama `UserSeeder`, `ServiceSeeder`, `PostSeeder` en ese orden. Repetible con `php artisan migrate:fresh --seed`.
- MySQL. Nombre de base **sin prefijos** (`apellido1_apellido2` en grupo). Un nombre `dw3_apellido1_apellido2` no cumple y puede restar un punto.

### Vistas, forms, CSS

- `<x-layouts.main>` en sitio y login; `<x-layouts.admin>` en el panel.
- Imprimir con `{{ }}`. No `{!! !!}` para datos de la base.
- Sitio público sin alta/edición/baja. Borrar = vista de confirmación; el GET no borra.
- HTML semántico: `header`, `nav`, `main`, `section`, `article`, `footer`. Detalle con `<dl>`.
- Todo POST lleva `@csrf` (excepción al docente: en Laravel 13, sin token, un host HTTP que no sea localhost puede responder 419).
- Mensajes de `validate()` en español, clave `campo.regla`.
- `@error` con `aria-invalid` y `aria-errormessage`, como el docente.
- Feedback: `feedback.message`; si no es éxito, `feedback.type` = `danger`.
- Credenciales malas: no son error de validación; se vuelve al login con feedback `danger` y `withInput()`.
- Tailwind 4: `@import 'tailwindcss'` + `@vite(['resources/css/app.css', 'resources/js/app.js'])`.
- Íconos Lucide: `createIcons` en `resources/js/app.js`; en la vista `<i data-lucide="nombre"></i>`.
- Desarrollo: `pnpm dev`. Para el zip: `pnpm build` e incluir `public/build/` (está en `.gitignore`).

### Autenticación (como quedó documentada)

Referencia del docente: `AuthController`, `UserSeeder`, `auth/login.blade.php`, `bootstrap/app.php`, rutas con `->middleware('auth')`.

- `UserSeeder` inserta el admin con `Hash::make`.
- `AuthController`: `showForm`, `processForm`, `processLogout`.
- `processForm`: `validate` de `email` + `password`, `Auth::attempt($credentials)` (versión activa del docente). Si entra: `$request->session()->regenerate()` (**excepción** al docente; Laravel lo pide para fijación de sesión) y redirect a `admin.posts.index`.
- `processLogout`: `Auth::logout()`, `session()->invalidate()`, `regenerateToken()`.
- ABM protegido con middleware `auth` de Laravel. No se escribe uno propio **en el primer parcial** porque el docente usa el de Laravel.
- En `bootstrap/app.php` debería ir `$middleware->redirectGuestsTo(fn () => route('auth.login.form'))`. **En el código de origin eso no está** (sección 8).

## 7. Inventario real de `origin/main` (`e8ba6f8`)

Esto es lo que queda en el disco **después** del fast-forward. No es el HEAD local `7ade4e7`.

### Stack

- PHP `^8.3`, Laravel `^13.17` (lock: v13.33.0 en el HEAD viejo; origin no cambia el framework de forma visible en `composer.json` salvo scripts `pnpm`).
- MySQL.
- Tailwind 4 + Vite 8 + `laravel-vite-plugin`.
- Gestor de front: **pnpm** (`packageManager: pnpm@10.33.0`). Dependencia `lucide`.
- Sin Breeze / Jetstream / Sanctum / Boost.

### Rutas (`routes/web.php`)

| Método | URI | Nombre | Controller |
|---|---|---|---|
| GET | `/` | `home` | `HomeController@index` |
| GET | `/servicios` | `services.index` | `ServicesController@index` |
| GET | `/servicios/{id}` | `services.show` | `ServicesController@show` (`whereNumber`) |
| GET | `/blog` | `blog.index` | `PostsController@index` |
| GET | `/blog/{id}` | `blog.show` | `PostsController@show` (`whereNumber`) |
| GET | `/admin/login` | `auth.login.form` | `AuthController@showForm` |
| POST | `/admin/login` | `auth.login.process` | `AuthController@processForm` |
| POST | `/admin/logout` | `auth.logout.process` | `AuthController@processLogout` |
| GET | `/admin/posts` | `admin.posts.index` | `AdminPostsController@index` |
| GET | `/admin/posts/crear` | `admin.posts.create` | `AdminPostsController@create` |
| POST | `/admin/posts/crear` | `admin.posts.store` | `AdminPostsController@store` |
| GET | `/admin/posts/{id}/editar` | `admin.posts.edit` | `AdminPostsController@edit` |
| POST | `/admin/posts/{id}/editar` | `admin.posts.update` | `AdminPostsController@update` |
| GET | `/admin/posts/{id}/eliminar` | `admin.posts.delete` | `AdminPostsController@delete` |
| POST | `/admin/posts/{id}/eliminar` | `admin.posts.destroy` | `AdminPostsController@destroy` |

Ninguna ruta del ABM tiene `->middleware('auth')`.

### Controllers

- `HomeController@index`: `Service::all()` + `Post::orderBy('published_at', 'desc')->limit(3)->get()`.
- `ServicesController`: `all()` / `findOrFail`.
- `PostsController`: `all()` / `findOrFail` (sitio público).
- `AdminPostsController`: CRUD con `$request->validate()`, `Post::create` / `update` / `delete`, feedback con `$post->title`. Campos validados: `title`, `summary`, `content`, `published_at`.
- `AuthController`: `Auth::attempt`, `session()->regenerate()` al entrar; logout con `invalidate` + `regenerateToken`.

### Modelos y tablas

**`services`** (`2026_09_23_005006_create_services_table.php`): `id`, `title` string(100), `short_description` string, `full_description` text, `price` unsignedInteger (centavos; accessor divide/multiplica 100), `delivery_days` unsignedInteger, `is_active` boolean, timestamps.

**`posts`** (`2026_09_29_132002_create_posts_table.php`): `id`, `title` string(100), `summary` string, `content` text, `published_at` date, timestamps. **No hay columna `image`.**

**`users`:** migración de Laravel, sin cambios.

`Post::$fillable` = `title`, `summary`, `content`, `published_at`. `Service::$fillable` = los seis campos de negocio.

### Seeders

`DatabaseSeeder` llama, en orden: `UserSeeder`, `ServiceSeeder`, `PostSeeder`.

- Usuario admin: `id` 1, name `Admin RestoCode`, email `admin@restocode.com`, password hasheada de `restocode` (comentario en el seeder).
- Cinco servicios; el último (`Web Premium + Reservas`) tiene `is_active` = false. Precios en centavos: 150000, 280000, 320000, 210000, 450000.
- Tres posts, `published_at` 2026-08-10, 2026-09-02, 2026-09-20. En home, con el seeder, se ven en orden 20-sep, 02-sep, 10-ago.

### Vistas

- Layouts: `resources/views/components/layouts/main.blade.php`, `admin.blade.php`.
- Públicas: `home.blade.php`, `services/index.blade.php`, `services/show.blade.php`, `blog/index.blade.php`, `blog/show.blade.php`, `auth/login.blade.php`.
- Admin: `admin/posts/index.blade.php`, `create.blade.php`, `edit.blade.php`, `delete.blade.php`.
- Nav público: Inicio, Servicios, Blog, e ícono Lucide `user` a `auth.login.form`.
- Footer en `main` (no se muestra en rutas `auth.login.*`).
- Imágenes fijas: `public/img/hero.webp`, `card-1.webp`, `card-2.webp`, `card-3.webp`.

### ROADMAP de origin: pasos 1–19 y extras de footer = hechos. Paso 20 (protección del admin) y 21 (entrega) = no hechos.

## 8. Huecos del primer parcial (hechos, no propuestas)

Respecto a la consigna, al PRD y al ROADMAP de origin, el código de `e8ba6f8` deja esto pendiente. **No se implementa en esta documentación.**

1. **Paso 20 — protección del admin.** `bootstrap/app.php` tiene `withMiddleware` vacío. Las rutas `admin.posts.*` no llevan `->middleware('auth')`. El ABM abre sin sesión. El ROADMAP ya describe el patrón del docente (`redirectGuestsTo` + `auth` en cada ruta) y no lo marca como hecho.
2. **No hay `datos.txt`** en la raíz.
3. **Nombre de la base.** `.env.example` de origin usa `DB_DATABASE=dw3_kuringhian_garcia` y `DB_PORT=8889`. El ROADMAP dice que el prefijo `dw3_` no cumple y se corrige en el paso 21. La consigna pide `apellido1_apellido2` sin prefijos.
4. **`.env` local (no versionado, el pull no lo pisa):** `DB_DATABASE=parcial_1_milagros_gael`, `DB_HOST=localhost`, `DB_PORT=3306`, `SESSION_DRIVER=file`. Tampoco coincide con `apellido1_apellido2`.
5. **Paso 21 — entrega** (zip, `datos.txt`, `pnpm build` + `public/build/`, rename de la base) no está cerrado en el ROADMAP.

Nada de esto se completa aquí. El segundo parcial puede exigir cambiar auth (roles, middleware **personalizado**); no se adelanta el paso 20 con un diseño que el 2do después contradiga. Se espera al proyecto del docente.

## 9. Consigna del segundo parcial (checklist)

Fuente: `docs/Portales y Comercio Electrónico - Segundo Parcial.pdf`. Profesor: Santiago Gallino.

Se usa **el mismo proyecto**. Lo que sigue es lo que el PDF pide. **No hay diseño de tablas, ni código, ni nombres de columnas inventados.**

Se mantiene del primero: tema libre (excepto política y religión), sitio + admin, servicio o producto (sin carrito), blog, home, Blade, validación PHP (sin HTML), feedback, HTML semántico, Bootstrap o Tailwind, DB `apellido_nombre` / `apellido1_apellido2`, al menos 3 tablas (users + blog + servicios/productos), users con id/email/password (se puede usar la de Laravel), al menos una tabla con 5+ campos de negocio, migrations y seeders, PHPDoc, SRP, zip con `datos.txt`.

### Lo nuevo respecto al primer parcial

- El sitio debe tener **registro y autenticación de usuarios**. Sigue **prohibido** usar la interfaz de autenticación y controllers que Laravel provee.
- El admin requiere autenticación de un usuario **administrador**.
- El admin debe **listar usuarios** y ver el **detalle** de cada uno, incluyendo el servicio contratado o las compras, si las tiene. Esos datos se cargan por **seeders**. No hace falta un proceso de compra.
- Al menos un usuario debe tener un servicio contratado, cargado por seeders.
- Debe haber **relaciones entre tablas**.
- Debe haber **modelos relacionados**, según esas relaciones.
- La tabla del blog debe poder hacer **alta y modificación de imágenes**.
- Al menos **2 roles**: usuario común y administrador. La verificación del administrador se hace con un **Middleware personalizado**.
- Entrega: carácter de `datos.txt` = **2do parcial**. El zip **no** debe incluir el link simbólico `public/storage`.
- Copiar trabajo = 1 para copiador y copiado.
- Defensa oral posible, en vivo o en la clase siguiente a la devolución.

### Lo que el primer parcial hizo y el segundo cambia

- `posts.image` se **sacó** en el paso 14 del primer parcial porque la consigna de entonces no lo pedía. El segundo **sí** pide imágenes en el blog. No se reintroduce la columna ni el upload hasta actualizar RULES/ROADMAP copiando el patrón **activo** de `proyecto-docente` (el docente ya muestra `hasFile()`, `store()`, `Storage::delete()`, `cover`).
- El primer parcial documentó middleware `auth` de Laravel (paso 20, no aplicado). El segundo pide middleware **personalizado** para el administrador. No se inventa el alias ni los campos de rol hasta ver la clase.
- Un solo usuario seedeado (`admin@restocode.com`). El segundo pide registro de usuarios comunes, roles, y al menos un usuario con servicio contratado.

## 10. Fuente de verdad para implementar el segundo

Orden, sin asumir:

1. **`proyecto-docente`** (carpeta local gitignoreada). Copiar la técnica **activa** que muestre la clase, no las alternativas comentadas. El primer parcial ya copió `AuthController@processForm` + `Auth::attempt`.
2. **PDFs de consigna.** Si el parcial obliga a apartarse del docente, se documenta la excepción en RULES y se justifica.
3. **`docs/RULES.md` y `docs/ROADMAP.md`**, actualizados cuando exista la clase correspondiente.
4. Este snapshot, para no perder el cierre del primero.

Si `proyecto-docente` no está en disco, **no se inventa** el schema de roles, la pivot usuario–servicio, el upload de imágenes ni el middleware. Se espera la carpeta o la clase.

Cuando se implemente el segundo, se actualizan PRD / ROADMAP / RULES. Este archivo no se usa como especificación de tablas nuevas.

### Excepciones al docente que ya están justificadas (primer parcial)

- `@csrf` en todo POST.
- `$request->session()->regenerate()` al login.
- URLs de login/logout bajo `/admin`, nombres de ruta iguales a los del docente.
- `now()` en fechas del `UserSeeder` (el docente no las completa).
- No copiar subida de archivos ni PK `movie_id` ni comentarios largos de cursada.
- `$data` = retorno de `validate()` (el docente en `MoviesController` usa `$request->input()`; en `AuthController` ya usa el retorno de `validate()`).

### Comandos que el proyecto ya documenta

```sh
php artisan migrate:fresh --seed
pnpm dev
pnpm build
```

Credenciales de prueba del seeder (comentario en `UserSeeder`): `admin@restocode.com` / `restocode`.
