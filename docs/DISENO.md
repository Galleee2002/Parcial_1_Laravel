# Guía de diseño · RestoCode

Esta guía define cómo se estilan las vistas del proyecto. Toda vista nueva o modificada debe respetarla.

## Cómo está integrado Tailwind

Tailwind CSS v4 está **instalado por npm** e integrado con Vite. Se usa como librería: el estilo se aplica exclusivamente con sus clases utilitarias dentro de las vistas Blade.

| Archivo | Rol |
|---|---|
| `package.json` | Dependencias `tailwindcss` y `@tailwindcss/vite`. |
| `vite.config.js` | Carga el plugin `tailwindcss()` y la fuente Instrument Sans (400, 500, 600). |
| `resources/css/app.css` | `@import 'tailwindcss';` y configuración del tema en `@theme`. |
| `resources/views/components/layouts/main.blade.php` | Carga los estilos con `@vite([...])`. |

Comandos (el proyecto usa pnpm):

```sh
pnpm dev     # mientras se desarrolla
pnpm build   # para la entrega / producción
```

## Reglas generales

1. **Solo clases utilitarias de Tailwind en el HTML.** No se escribe CSS propio, no se usa `@apply` ni atributos `style=""`.
2. **La configuración del tema vive únicamente en `@theme` de `resources/css/app.css`.** Si se agrega un color o fuente, se define ahí y se usa como clase (por ejemplo `--color-brand-500` → `bg-brand-500`).
3. **Toda vista usa el layout** `<x-layouts.main>` y define su título con `<x-slot:title>`.
4. **Links internos siempre con `route('nombre')`**, nunca URLs escritas a mano.
5. **Mobile first:** las clases base son para celular; se agregan variantes `md:` para pantallas más grandes.
6. **Orden de clases:** layout → posición → tamaño → espaciado → tipografía → color → estados.
   Ejemplo: `mx-auto flex max-w-6xl items-center justify-between px-4 py-4`.
7. **HTML semántico:** `header`, `nav`, `main`, `section`, `article`, `footer`, `dl/dt/dd`, `time`.
8. **Antes de crear un componente nuevo, reutilizar uno de esta guía.** Si hace falta uno nuevo, se documenta acá.

## Paleta

La paleta base es `zinc`. No se incorporan otros colores sin agregarlos antes a esta guía.

| Uso | Clases |
|---|---|
| Fondo general | `bg-white` |
| Texto principal | `text-zinc-900` |
| Texto secundario | `text-zinc-600` |
| Texto meta / etiquetas | `text-sm text-zinc-500` |
| Bordes | `border-zinc-200` |
| Fondo oscuro (nav, hero) | `bg-zinc-900 text-white` |
| Texto claro sobre fondo oscuro | `text-zinc-200` |
| Hover sobre fondo oscuro | `hover:text-zinc-300` |
| Mensaje de éxito | `border-green-200 bg-green-50 text-green-800` |

## Tipografía

Fuente: Instrument Sans (`font-sans`, aplicada por defecto). Pesos disponibles: `font-normal`, `font-medium`, `font-semibold`.

| Elemento | Clases |
|---|---|
| H1 del hero | `text-4xl font-semibold` |
| H1 de página | `text-3xl font-semibold` |
| H2 de sección (home) | `text-3xl font-semibold` |
| Título de card / H2 interno | `text-xl font-semibold` |
| Bajada del hero | `text-lg text-zinc-200` |
| Precio / dato destacado | `text-lg font-medium` |
| Párrafo largo | `leading-relaxed` |
| Texto meta | `text-sm text-zinc-500` |

## Layout y espaciado

| Elemento | Clases |
|---|---|
| Contenedor general | `mx-auto max-w-6xl px-4` |
| Contenedor de detalle (un solo ítem) | `mx-auto max-w-3xl px-4` |
| Sección estándar | `py-12` |
| Hero | `py-20` |
| Grilla de cards | `mt-8 grid gap-6 md:grid-cols-3` |
| Grupo de botones | `mt-8 flex flex-wrap gap-3` |
| Separación de footer | `mt-12 border-t border-zinc-200 py-4` |

Escala de espaciado vertical entre elementos:

- `mt-1` / `mt-2`: entre título y texto.
- `mt-4`: entre bloques dentro de un mismo componente.
- `mt-6` / `mt-8`: entre secciones internas de una página.

## Estructura base de una vista

```blade
<x-layouts.main>
    <x-slot:title>Título de la página</x-slot:title>

    <section class="mx-auto max-w-6xl px-4 py-12">
        <h1 class="text-3xl font-semibold">Título de la página</h1>
        <p class="mt-2 text-zinc-600">Bajada opcional.</p>

        {{-- contenido --}}
    </section>
</x-layouts.main>
```

## Componentes

### Hero

```blade
<section class="bg-zinc-900 py-20 text-white">
    <div class="mx-auto max-w-6xl px-4">
        <h1 class="text-4xl font-semibold">Título</h1>
        <p class="mt-4 max-w-2xl text-lg text-zinc-200">Bajada.</p>
        <div class="mt-8 flex flex-wrap gap-3">
            {{-- botones --}}
        </div>
    </div>
</section>
```

### Card

```blade
<article class="rounded border border-zinc-200 p-6">
    <h2 class="text-xl font-semibold">{{ $item->title }}</h2>
    <p class="mt-2 text-zinc-600">{{ $item->summary }}</p>
    <a class="mt-4 inline-block underline" href="{{ route('...') }}">Ver detalle</a>
</article>
```

En la home las cards van dentro de una sección con `h2`, por lo que el título de la card pasa a `h3` manteniendo las mismas clases.

### Grilla de cards

```blade
<div class="mt-8 grid gap-6 md:grid-cols-3">
    @foreach ($items as $item)
        {{-- card --}}
    @endforeach
</div>
```

### Botones (sobre fondo oscuro)

```blade
{{-- Primario --}}
<a class="rounded bg-white px-4 py-2 font-medium text-zinc-900" href="{{ route('...') }}">Acción</a>

{{-- Secundario --}}
<a class="rounded border border-white px-4 py-2 font-medium text-white" href="{{ route('...') }}">Acción</a>
```

### Links

```blade
{{-- Link de texto --}}
<a class="underline" href="{{ route('...') }}">Texto</a>

{{-- Link "volver" --}}
<a class="text-sm underline" href="{{ route('...') }}">Volver a ...</a>

{{-- Link de navegación (sobre fondo oscuro) --}}
<a class="hover:text-zinc-300" href="{{ route('...') }}">Sección</a>
```

### Lista de datos (vista de detalle)

```blade
<dl class="mt-6 flex gap-8">
    <div>
        <dt class="text-sm text-zinc-500">Etiqueta</dt>
        <dd class="text-lg font-medium">Valor</dd>
    </div>
</dl>
```

### Fecha

```blade
<p class="mt-1 text-sm text-zinc-500">
    Publicado el <time datetime="{{ $post->published_at }}">{{ $post->published_at }}</time>
</p>
```

### Mensaje flash

Ya está resuelto en el layout y se muestra cuando existe `session('feedback.message')`:

```blade
<div class="mx-auto mt-3 max-w-6xl px-4">
    <div class="rounded border border-green-200 bg-green-50 px-4 py-3 text-green-800">
        {{ session('feedback.message') }}
    </div>
</div>
```

## Checklist antes de sumar o modificar una vista

- [ ] Usa `<x-layouts.main>` y define `<x-slot:title>`.
- [ ] Usa el contenedor `mx-auto max-w-6xl px-4` (o `max-w-3xl` en detalles).
- [ ] Solo clases de Tailwind: sin CSS propio, sin `@apply`, sin `style=""`.
- [ ] Colores y tipografía tomados de las tablas de esta guía.
- [ ] Reutiliza los componentes documentados.
- [ ] Links internos con `route(...)`.
- [ ] Se ve bien en celular (sin `md:`) y en escritorio.
