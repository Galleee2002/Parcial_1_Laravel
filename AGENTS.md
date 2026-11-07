# RestoCode — guía para agentes

Este repositorio es **RestoCode**: sitio Laravel de soluciones digitales para gastronomía (menú QR, landing, reservas) más un blog y un panel que administra entradas.

No asumas técnicas, tablas ni patrones que no estén en las fuentes de abajo. Copiá la sintaxis **activa** de `docs-docente/proyecto` y cambiá el dominio (gastronomía, `services`, `posts`). Marcá las diferencias: no entregues un clon del docente.

## Leer primero

1. [`docs/SEGUNDO_PARCIAL.md`](docs/SEGUNDO_PARCIAL.md) — inventario del material docente vs consigna del 2do.
2. [`docs/PRIMER_PARCIAL.md`](docs/PRIMER_PARCIAL.md) — snapshot del 1er (no reescribirlo con clases nuevas).
3. [`docs/RULES.md`](docs/RULES.md) — cómo se escribe el código.
4. [`docs/ROADMAP.md`](docs/ROADMAP.md) — orden de features y qué está hecho.
5. [`docs/PRD.md`](docs/PRD.md) — dominio y páginas.
6. PDFs en `docs/`: primer y segundo parcial.
7. [`docs-docente/`](docs-docente/) — todo el material del profesor (local, gitignoreado). Índice en [`docs-docente/README.md`](docs-docente/README.md).

## Fuente de verdad

1. **`docs-docente/`** (local, gitignoreada). Ahí está el Laravel en `docs-docente/proyecto/`, el ejercicio de interfaces, los apuntes `.md` y los `.rar`. Copiá la técnica activa de la clase, no las alternativas comentadas. No se modifica ni se entrega.
2. **Consignas PDF** (ahora manda el 2do).
3. **RULES / ROADMAP / PRD**, actualizados cuando una clase nueva los contradiga.

Si el docente muestra algo que el parcial no pide, no se agrega. Si el parcial obliga a apartarse, la excepción se documenta en RULES y se justifica.

Equivalencia: lectura de `movies` → `services`; ABM de `movies` → `admin/posts`; login `/iniciar-sesion` → `/admin/login` (mismos nombres de ruta). PK `id`, no `movie_id`.

## Stack

- PHP `^8.3`, Laravel `^13`.
- MySQL. Nombre de base según consigna: `apellido_nombre` o `apellido1_apellido2`, **sin prefijos**. El `.env.example` todavía tiene `dw3_kuringhian_garcia`; eso no cumple.
- Tailwind 4 + Vite 8, cargados con `@vite` en los layouts.
- Front: **pnpm** (`pnpm-lock.yaml`). Íconos: Lucide en `resources/js/app.js`.
- No está instalado Laravel Boost, Breeze, Jetstream, Fortify ni Sanctum.

## Qué hay implementado (1er parcial)

Rutas en [`routes/web.php`](routes/web.php):

- Públicas: `home`, `services.index`, `services.show`, `blog.index`, `blog.show`.
- Auth propia: `auth.login.form` / `auth.login.process` (`/admin/login`), `auth.logout.process` (`POST /admin/logout`).
- ABM: `admin.posts.*` (listar, crear, editar, eliminar con GET de confirmación + POST), cada una con `->middleware('auth')`.

Controllers: `HomeController`, `ServicesController`, `PostsController`, `AdminPostsController`, `AuthController` (`Auth::attempt`, `session()->regenerate()` al entrar).

Tablas: `users` (Laravel, sin tocar), `services` (6 campos de negocio; precio en centavos + accessor), `posts` (`title`, `summary`, `content`, `image` nullable, `published_at`).

Seeders: `UserSeeder` (`admin@restocode.com` / `restocode`), 5 servicios (el último inactivo), 3 posts. `php artisan migrate:fresh --seed`.

Layouts: `<x-layouts.main>` (sitio y login), `<x-layouts.admin>` (panel).

Las rutas `admin.posts.*` llevan `->middleware('auth')` y `bootstrap/app.php` redirige al invitado con `redirectGuestsTo` hacia `auth.login.form` (paso 20 / 22). El 2do pide además middleware **personalizado de administrador**; no adelantes un campo `role` inventado.

No hay `datos.txt`.

## Qué hay en `docs-docente` y qué no se copia

Ya copiado a RestoCode (paso 20): `redirectGuestsTo` + `middleware('auth')` en el ABM.

Ya copiado (paso 23): upload de `cover` pasado a `posts.image` (`hasFile` → `store('posts', 'public')` + `Storage::disk('public')->delete`).

Sigue en el docente (`docs-docente/proyecto`) y **no se implementa** salvo que se pida:

- Middleware propio `EnsureIsOver18YearsOld` + alias `over18`.
- Relaciones 1:n (`belongsTo` rating) y n:n (`belongsToMany` géneros, pivot, `attach`/`sync`/`detach`).
- `with`, `orderBy`, `paginate`.

No se copia:

- Verificación de edad ni `AgeVerificationController`.
- Mail / `MoviesReservationController` / `MovieReserved`.
- Bootstrap, `public/css`, PK `movie_id`, comentarios largos de cursada.
- `$request->input()` para guardar (en RestoCode `$data` sale de `validate()`).
- Vistas `movies/*` ni el dominio cine.
- El ejercicio `docs-docente/interfaces/` (POO/interfaces PHP) ni los apuntes de teoría, salvo que el ROADMAP lo pida.

Todavía **no** está en el docente: registro, roles, listado/detalle de usuarios, servicio contratado. No lo inventes.

## Qué no se usa

- Breeze, Jetstream, Fortify y los controllers de autenticación de Laravel. El login es nuestro `AuthController`.
- Form Requests. Validación: `$request->validate()` en el controller, mensajes en español.
- PUT / DELETE. GET muestra el form, POST lo procesa. Todo POST lleva `@csrf`.
- Atributos HTML de validación (`required`, `min`, `max`). Con `type="email"` el form lleva `novalidate`.
- `with` / `orderBy` / `paginate` en RestoCode hasta que el ROADMAP lo pida (excepción hecha: 3 novedades de la home).
- Carrito de compras.
- `{!! !!}` para datos de la base.

Nombres de ruta, `$fillable`, `route()`, PHPDoc, `feedback.message` / `feedback.type`: ver RULES.

## Segundo parcial

El paso 23 (imágenes en entradas) ya está. El resto (24–28) no se implementa salvo que el usuario lo pida en el turno.

Pasos tentativos en ROADMAP 22–28. Detalle y tabla consigna vs docente: `docs/SEGUNDO_PARCIAL.md`.

## Entrega (zip de Classroom)

No incluir: `docs/`, `docs-docente/`, `AGENTS.md`, `CLAUDE.md`, `node_modules`, `vendor`, `.env`, ni el link `public/storage`. Sí incluir `public/build/` después de `pnpm build` (está en `.gitignore`). `datos.txt` con carácter **2do parcial**.

### Limpieza total (solo cuando el usuario lo pida)

**No** borrar ni sacar del repo la documentación ni los recursos del docente de forma anticipada. Eso queda para el cierre final.

Únicamente cuando **yo** (el usuario de este chat) lo pida de forma explícita —p. ej. “borrá todos los documentos del parcial para una entrega limpia”— el agente debe:

1. Eliminar del disco todo rastro de material de cursada / agentes / consignas locales: `docs/`, `docs-docente/` (proyecto, interfaces, rars y apuntes), `AGENTS.md`, `CLAUDE.md`, y cualquier otra carpeta o archivo equivalente que solo sirva de contexto de parcial (no el código de RestoCode).
2. Sacar esas entradas del `.gitignore` si ya no existen (o limpiar las que apuntaban a ese material).
3. Revisar el proyecto y quitar referencias sueltas a ese material (rutas, comentarios de entrega en reglas internas, etc.) **solo** si quedan huérfanas tras el borrado.

**No** tocar el historial de ramas ni reescribir git por esta limpieza: las ramas se dejan como están. No ejecutar esta limpieza “porque estamos cerca de entregar” ni por checklist del ROADMAP: hace falta el pedido explícito del usuario.

## Comandos

```sh
php artisan migrate:fresh --seed
pnpm dev
pnpm build
```

No commitees `.env`. No actualices git config. No hagas commit ni push a menos que el usuario lo pida.
