# Documentación del Proyecto: RestoCode

## 1. Contexto e Idea General

**RestoCode** es una plataforma web especializada en ofrecer soluciones digitales y desarrollo web exclusivamente para el sector gastronómico (restaurantes, bares, cafeterías y pizzerías). 

A través del sitio público, los dueños de negocios gastronómicos pueden explorar los servicios ofrecidos (menús digitales QR, páginas web institucionales y sistemas de reservas) y consultar artículos educativos en el blog sobre marketing y digitalización gastronómica.

El proyecto cuenta con un panel de administración restringido que permite gestionar el contenido dinámico del blog de noticias y novedades.

---

## 2. Objetivos del Proyecto

* **Objetivo Comercial (Ficción del sitio):** Ayudar a establecimientos gastronómicos a modernizar su atención, optimizar costos de carta impresa y aumentar ventas mediante menús digitales interactivos accesibles por código QR.
* **Objetivo Académico:** Aplicar los conceptos fundamentales del desarrollo con **Laravel** (Patrón MVC, Blade, Eloquent ORM, Validaciones en PHP, Autenticación personalizada, Middlewares, Migraciones y Seeders) cumpliendo rigurosamente con las especificaciones y normativas de la materia.

---

## 3. Especificaciones Técnicas y Cumplimiento de Consigna

### A. Sitio Público (Usuarios)
1. **Home (`/`):**
   * **Hero Section:** Presentación del servicio enfocado en gastronomía con un botón CTA ("Ver Servicios").
   * **Sección de Servicios:** Lista numerada con los servicios activos, leídos de la base de datos.
   * **Novedades Recientes:** Muestra las últimas 3 entradas del blog traídas dinámicamente desde la base de datos.
2. **Servicios (`/servicios` y `/servicios/{id}`):**
   * Presentación de paquetes (Menú QR Básico, Web Landing Gastronómica, Pedidos Online, Menú QR Multilenguaje, Web Premium + Reservas).
   * Vista de detalle de cada servicio.
3. **Blog / Novedades (`/blog` y `/blog/{id}`):**
   * Listado de artículos sobre tendencias, consejos y estrategias para gastronómicos.
   * Vista detallada de cada artículo.

### B. Admin (Administración)
1. **Autenticación (`/admin/login`):**
   * Control de acceso propio desarrollado en Laravel mediante Controllers, Middlewares y Sessiones (sin utilizar Breeze, Jetstream ni los controllers por defecto del framework).
2. **ABM / CRUD de Blog (`/admin/posts`):**
   * **Crear:** Formulario para publicar nuevos artículos.
   * **Editar:** Formulario para modificar publicaciones existentes.
   * **Eliminar:** Mecanismo seguro para remover artículos.
   * **Listar:** Tabla con las entradas creadas y opciones de gestión.

### C. Base de Datos
* **Nombre de la Base de Datos:** `apellido_nombre` (o `apellido1_apellido2` si es en grupo), sin prefijos ni sufijos.
* **Tablas Requeridas:**
  1. `users`: (la tabla que trae Laravel, sin modificar)
     * Campos: `id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`.
  2. `services`: (Tabla de servicios con más de 5 campos específicos)
     * Campos: `id`, `title`, `short_description`, `full_description`, `price`, `delivery_days`, `is_active`, `created_at`, `updated_at`.
  3. `posts`: (Tabla para el blog)
     * Campos: `id`, `title`, `summary`, `content`, `published_at`, `created_at`, `updated_at`.

---

## 4. Buenas Prácticas y Criterios de Evaluación

* **PHP & Laravel:**
  * Uso estricto de **Blade** para renderizar vistas.
  * Implementación de **Migrations** y **Seeders** para inicializar la base de datos con datos de prueba (`php artisan migrate --seed`).
  * Validaciones procesadas del lado del servidor en PHP con `$request->validate()` en el controller, enviando mensajes de error claros a la vista. **No se usa la validación HTML** (la consigna la prohíbe).
  * Notificaciones de feedback al usuario (*Flash Messages* en sesión) tras operaciones exitosas (ej. "Entrada creada con éxito").
* **Estructura y Código:**
  * Uso de componentes MVC (Models, Controllers, Middlewares).
  * Principio de Responsabilidad Única (SRP).
  * Nombres limpios e intencionales en español o inglés para variables, métodos y clases.
  * Etiquetas semánticas en HTML (`<header>`, `<nav>`, `<main>`, `<section>`, `<article>`, `<footer>`).
  * Estilización con Tailwind CSS, compilado por Vite y cargado con `@vite` en los layouts. La consigna permite Bootstrap o Tailwind; se eligió Tailwind.
  * Documentación con PHPDoc en controladores y métodos clave.

---

## 5. Requisitos de Entrega Digital

* Archivo comprimido con nombre `apellido-nombre.zip` (o `apellido1-nombre1_apellido2-nombre2.zip`).
* Contenido del archivo comprimido:
  * Código fuente completo del proyecto Laravel.
  * Archivo `datos.txt` en la raíz con la siguiente estructura:
    ```text
    Carrera: [Tu Carrera]
    Materia: Portales y Comercio Electrónico
    Cuatrimestre: [N° Cuatrimestre]
    Año: [Año Actual]
    Turno: [Turno]
    Comisión: [Comisión]
    Apellido y Nombre: [Datos de todos los integrantes]
    Docente: Santiago Gallino
    Carácter de entrega: 1er Parcial
    ```