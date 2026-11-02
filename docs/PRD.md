# Documentación del Proyecto: RestoCode

## 1. Contexto e Idea General

**RestoCode** es una plataforma web especializada en ofrecer soluciones digitales y desarrollo web exclusivamente para el sector gastronómico (restaurantes, bares, cafeterías y pizzerías). 

A través del sitio público, los dueños de negocios gastronómicos pueden explorar los servicios ofrecidos (menús digitales QR, páginas web institucionales y sistemas de reservas) y consultar artículos educativos en el blog sobre marketing y digitalización gastronómica.

El proyecto cuenta con un panel de administración restringido que permite gestionar el contenido dinámico del blog de noticias y novedades. El segundo parcial suma registro de usuarios, roles (usuario común y administrador), listado de usuarios en el admin y relaciones en la base; el detalle de esas tablas se copia del docente cuando exista la clase, no se inventa acá. Ver [SEGUNDO_PARCIAL.md](SEGUNDO_PARCIAL.md).

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
4. **Registro y autenticación de usuarios** (2do parcial, aún no implementado):
   * El sitio debe permitir registro y autenticación. Sigue prohibido usar la interfaz y los controllers de autenticación que Laravel provee. El login propio de `/admin/login` ya existe; el registro espera la clase del docente.

### B. Admin (Administración)
1. **Autenticación (`/admin/login`):**
   * Control de acceso propio desarrollado en Laravel mediante Controllers, Middlewares y Sessiones (sin utilizar Breeze, Jetstream ni los controllers por defecto del framework).
   * El 2do pide que quien entra al admin sea un **administrador**, verificado con un **middleware personalizado**. El docente todavía no muestra el rol; sí muestra el patrón de middleware propio (`EnsureIsOver18YearsOld`).
2. **ABM / CRUD de Blog (`/admin/posts`):**
   * **Crear:** Formulario para publicar nuevos artículos.
   * **Editar:** Formulario para modificar publicaciones existentes.
   * **Eliminar:** Mecanismo seguro para remover artículos.
   * **Listar:** Tabla con las entradas creadas y opciones de gestión.
   * El 2do pide alta y modificación de **imágenes** en estas entradas. En el 1er se sacó `image`; el docente ya muestra el patrón con `cover`.
3. **Usuarios (2do parcial, espera clase):**
   * Listado de usuarios y detalle de cada uno, incluyendo el servicio contratado o las compras, si las tiene. Esos datos se cargan por seeders. No hace falta un proceso de compra.

### C. Base de Datos
* **Nombre de la Base de Datos:** `apellido_nombre` (o `apellido1_apellido2` si es en grupo), sin prefijos ni sufijos.
* **Tablas Requeridas:**
  1. `users`: (la tabla que trae Laravel, sin modificar)
     * Campos: `id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`.
  2. `services`: (Tabla de servicios con más de 5 campos específicos)
     * Campos: `id`, `title`, `short_description`, `full_description`, `price`, `delivery_days`, `is_active`, `created_at`, `updated_at`.
  3. `posts`: (Tabla para el blog)
     * Campos hoy: `id`, `title`, `summary`, `content`, `published_at`, `created_at`, `updated_at`.
     * El 2do pide imagen (alta/modificación). No se reintroduce la columna hasta implementar el paso correspondiente, copiando el patrón de `cover` del docente.
* **Relaciones (2do parcial):** debe haber relaciones entre tablas y modelos relacionados. Al menos un usuario con un servicio contratado, cargado por seeders. El docente muestra 1:n y n:n en películas (`rating`, `genres`); **no** muestra usuario–servicio. No se diseña esa tabla en este PRD.
* **Roles (2do parcial):** al menos usuario común y administrador. El docente todavía no los muestra.

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
    Carácter de entrega: 2do Parcial
    ```
* El zip **no** debe incluir el link simbólico `public/storage`, ni `proyecto-docente`, ni `docs/`, ni `AGENTS.md`.