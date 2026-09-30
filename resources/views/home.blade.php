<x-layouts.main>
    <x-slot:title>Inicio</x-slot:title>

    <section class="relative isolate overflow-hidden border-b border-zinc-800 bg-zinc-950 text-zinc-50">
        <div class="pointer-events-none absolute inset-x-0 top-0 h-px bg-linear-to-r from-transparent via-blue-500/40 to-transparent" aria-hidden="true"></div>
        <div class="pointer-events-none absolute -top-40 left-1/2 -z-10 h-80 w-[48rem] -translate-x-1/2 rounded-full bg-blue-500/10 blur-3xl lg:left-3/4" aria-hidden="true"></div>

        <div class="mx-auto grid max-w-6xl gap-14 px-4 py-16 sm:py-20 lg:grid-cols-12 lg:items-center lg:gap-10 lg:py-28">
            <div class="lg:col-span-6">
                <div class="flex items-center gap-2" aria-hidden="true">
                    <span class="h-px w-8 bg-blue-500"></span>
                    <span class="size-1.5 rounded-full bg-cyan-400"></span>
                </div>

                <h1 class="mt-6 text-4xl font-semibold leading-[1.05] tracking-tight text-balance text-zinc-50 sm:text-5xl xl:text-6xl">
                    Digitalizá tu local <span class="text-blue-500">gastronómico</span>
                </h1>
                <p class="mt-6 max-w-xl text-base leading-relaxed text-pretty text-zinc-400 sm:text-lg">
                    Menús QR, sitios web y reservas para restaurantes, bares y cafeterías.
                </p>

                <div class="mt-10 flex flex-col gap-3 sm:flex-row">
                    <a class="group inline-flex items-center justify-center gap-2 rounded-lg bg-blue-500 px-5 py-3 text-sm font-semibold text-zinc-950 transition-colors hover:bg-blue-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-500" href="{{ route('services.index') }}">
                        Ver servicios
                        <svg class="size-4 transition-transform group-hover:translate-x-0.5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M3 10a.75.75 0 0 1 .75-.75h10.638l-3.96-3.71a.75.75 0 1 1 1.024-1.096l5.25 4.922a.75.75 0 0 1 0 1.096l-5.25 4.922a.75.75 0 1 1-1.024-1.096l3.96-3.71H3.75A.75.75 0 0 1 3 10Z" clip-rule="evenodd" />
                        </svg>
                    </a>
                    <a class="inline-flex items-center justify-center rounded-lg border border-zinc-800 bg-zinc-900/60 px-5 py-3 text-sm font-semibold text-zinc-50 transition-colors hover:border-zinc-700 hover:bg-zinc-900 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-500" href="{{ route('services.index') }}">Ver demo</a>
                </div>
            </div>

            <div class="relative mx-auto w-full max-w-lg pt-10 pb-16 lg:col-span-6 lg:max-w-none lg:pl-6" aria-hidden="true">
                <div class="relative ml-auto w-[88%] rounded-2xl border border-zinc-800 bg-zinc-900/80 shadow-2xl shadow-black/40 backdrop-blur-sm">
                    <div class="flex items-center gap-1.5 border-b border-zinc-800 px-4 py-3">
                        <span class="size-2 rounded-full bg-zinc-700"></span>
                        <span class="size-2 rounded-full bg-zinc-700"></span>
                        <span class="size-2 rounded-full bg-zinc-700"></span>
                        <span class="ml-3 h-4 flex-1 rounded-md bg-zinc-800"></span>
                    </div>

                    <div class="p-5 sm:p-6">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-medium tracking-wider text-zinc-400 uppercase">Sitio web</span>
                            <span class="size-1.5 rounded-full bg-cyan-400"></span>
                        </div>

                        <div class="mt-4 rounded-xl border border-zinc-800 bg-linear-to-br from-blue-700/30 via-zinc-900 to-zinc-900 p-4 sm:p-5">
                            <div class="h-2.5 w-1/2 rounded-full bg-zinc-600"></div>
                            <div class="mt-2 h-2 w-3/4 rounded-full bg-zinc-700"></div>
                            <div class="mt-5 h-6 w-20 rounded-md bg-blue-500"></div>
                        </div>

                        <div class="mt-4 grid grid-cols-3 gap-3">
                            @foreach (range(1, 3) as $item)
                                <div class="rounded-lg border border-zinc-800 bg-zinc-950/60 p-3">
                                    <div @class([
                                        'aspect-square w-full rounded-md',
                                        'bg-blue-500/20' => $item === 1,
                                        'bg-zinc-800' => $item !== 1,
                                    ])></div>
                                    <div class="mt-3 h-1.5 w-full rounded-full bg-zinc-700"></div>
                                    <div class="mt-1.5 h-1.5 w-2/3 rounded-full bg-zinc-800"></div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="absolute top-0 right-2 w-40 rounded-xl border border-zinc-800 bg-zinc-950/90 p-4 shadow-xl shadow-black/50 backdrop-blur-sm sm:right-4 sm:w-44">
                    <div class="flex items-center gap-2">
                        <span class="size-1.5 rounded-full bg-blue-500"></span>
                        <span class="text-xs font-medium tracking-wider text-zinc-400 uppercase">Reservas</span>
                    </div>
                    <div class="mt-3 grid grid-cols-7 gap-1">
                        @foreach (range(1, 14) as $day)
                            <span @class([
                                'aspect-square rounded-sm',
                                'bg-blue-500' => $day === 10,
                                'bg-cyan-400/70' => $day === 12,
                                'bg-zinc-800' => ! in_array($day, [10, 12]),
                            ])></span>
                        @endforeach
                    </div>
                </div>

                <div class="absolute bottom-0 left-0 w-36 rounded-xl border border-zinc-800 bg-zinc-950/90 p-4 shadow-xl shadow-black/50 backdrop-blur-sm sm:w-40">
                    <div class="flex items-center gap-2">
                        <span class="size-1.5 rounded-full bg-cyan-400"></span>
                        <span class="text-xs font-medium tracking-wider text-zinc-400 uppercase">Menú QR</span>
                    </div>
                    <div class="mt-3 rounded-md bg-zinc-100 p-1.5">
                        <svg class="block w-full" viewBox="0 0 21 21" shape-rendering="crispEdges">
                            <rect class="fill-zinc-950" width="7" height="7" />
                            <rect class="fill-zinc-100" x="1" y="1" width="5" height="5" />
                            <rect class="fill-blue-500" x="2" y="2" width="3" height="3" />

                            <rect class="fill-zinc-950" x="14" width="7" height="7" />
                            <rect class="fill-zinc-100" x="15" y="1" width="5" height="5" />
                            <rect class="fill-zinc-950" x="16" y="2" width="3" height="3" />

                            <rect class="fill-zinc-950" y="14" width="7" height="7" />
                            <rect class="fill-zinc-100" x="1" y="15" width="5" height="5" />
                            <rect class="fill-zinc-950" x="2" y="16" width="3" height="3" />

                            <path class="fill-zinc-950" d="
                                M9 0h1v1h-1z M11 0h1v1h-1z
                                M8 1h1v1h-1z M10 1h1v1h-1z
                                M12 2h1v1h-1z
                                M9 3h2v1h-2z
                                M8 4h1v1h-1z M11 4h1v1h-1z
                                M9 5h1v1h-1z M12 5h1v1h-1z
                                M8 6h1v1h-1z M10 6h1v1h-1z M12 6h1v1h-1z
                                M0 8h1v1h-1z M2 8h1v1h-1z M4 8h1v1h-1z M6 8h1v1h-1z M8 8h2v1h-2z M11 8h1v1h-1z M14 8h1v1h-1z M16 8h1v1h-1z M19 8h1v1h-1z
                                M1 9h1v1h-1z M3 9h1v1h-1z M10 9h1v1h-1z M13 9h1v1h-1z M17 9h1v1h-1z M20 9h1v1h-1z
                                M0 10h1v1h-1z M5 10h2v1h-2z M8 10h1v1h-1z M12 10h1v1h-1z M15 10h1v1h-1z M18 10h1v1h-1z
                                M2 11h1v1h-1z M4 11h1v1h-1z M9 11h1v1h-1z M11 11h1v1h-1z M14 11h1v1h-1z M16 11h1v1h-1z M20 11h1v1h-1z
                                M1 12h1v1h-1z M3 12h1v1h-1z M6 12h1v1h-1z M10 12h1v1h-1z M13 12h1v1h-1z M17 12h1v1h-1z M19 12h1v1h-1z
                                M8 13h1v1h-1z M12 13h1v1h-1z M15 13h1v1h-1z M18 13h1v1h-1z
                                M9 14h1v1h-1z M11 14h1v1h-1z M14 14h1v1h-1z M16 14h1v1h-1z M20 14h1v1h-1z
                                M10 15h1v1h-1z M13 15h1v1h-1z M17 15h1v1h-1z M19 15h1v1h-1z
                                M8 16h1v1h-1z M12 16h1v1h-1z M15 16h1v1h-1z M18 16h1v1h-1z
                                M9 17h1v1h-1z M11 17h1v1h-1z M14 17h1v1h-1z M20 17h1v1h-1z
                                M10 18h1v1h-1z M13 18h1v1h-1z M16 18h1v1h-1z M19 18h1v1h-1z
                                M8 19h1v1h-1z M12 19h1v1h-1z M15 19h1v1h-1z M17 19h1v1h-1z
                                M9 20h1v1h-1z M11 20h1v1h-1z M14 20h1v1h-1z M18 20h1v1h-1z M20 20h1v1h-1z
                            " />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-zinc-950 text-zinc-50">
        <div class="mx-auto max-w-6xl px-4 py-16 sm:py-20 lg:py-24">
            <div class="flex items-center gap-2" aria-hidden="true">
                <span class="h-px w-8 bg-blue-500"></span>
                <span class="size-1.5 rounded-full bg-cyan-400"></span>
            </div>
            <h2 class="mt-5 text-3xl font-semibold tracking-tight text-balance text-zinc-50 sm:text-4xl">Nuestros servicios</h2>

            <div class="mt-10 grid gap-5 sm:mt-12 md:grid-cols-2 lg:grid-cols-3 lg:gap-6">
                @foreach ($services as $service)
                    @if ($service->is_active)
                        <article class="group relative flex h-full flex-col overflow-hidden rounded-xl border border-zinc-800 bg-zinc-900/60 p-6 transition-colors duration-300 hover:border-blue-500/40 hover:bg-zinc-900 sm:p-7">
                            <div class="pointer-events-none absolute inset-x-0 top-0 h-px bg-linear-to-r from-transparent via-blue-500/0 to-transparent transition-colors duration-300 group-hover:via-blue-500/50" aria-hidden="true"></div>

                            <h3 class="text-lg font-semibold tracking-tight text-zinc-50 sm:text-xl">{{ $service->title }}</h3>
                            <p class="mt-3 text-sm leading-relaxed text-pretty text-zinc-400 sm:text-base">{{ $service->short_description }}</p>

                            <div class="mt-auto pt-8">
                                <div class="flex flex-wrap items-end justify-between gap-x-4 gap-y-2 border-t border-zinc-800 pt-5">
                                    <p class="text-2xl font-semibold tracking-tight text-zinc-50 tabular-nums">${{ $service->price }}</p>
                                    <p class="flex items-center gap-2 text-sm text-zinc-400">
                                        <span class="size-1.5 shrink-0 rounded-full bg-cyan-400" aria-hidden="true"></span>
                                        Entrega en {{ $service->delivery_days }} días
                                    </p>
                                </div>

                                <a class="mt-5 inline-flex items-center gap-1.5 text-sm font-semibold text-blue-400 transition-colors hover:text-blue-300 focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-blue-500" href="{{ route('services.show', ['id' => $service->id]) }}">
                                    Ver detalle
                                    <svg class="size-4 transition-transform duration-300 group-hover:translate-x-0.5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M3 10a.75.75 0 0 1 .75-.75h10.638l-3.96-3.71a.75.75 0 1 1 1.024-1.096l5.25 4.922a.75.75 0 0 1 0 1.096l-5.25 4.922a.75.75 0 1 1-1.024-1.096l3.96-3.71H3.75A.75.75 0 0 1 3 10Z" clip-rule="evenodd" />
                                    </svg>
                                </a>
                            </div>
                        </article>
                    @endif
                @endforeach
            </div>
        </div>
    </section>

    <section class="border-t border-zinc-800 bg-zinc-950 text-zinc-50">
        <div class="mx-auto max-w-6xl px-4 py-16 sm:py-20 lg:py-24">
            <div class="flex items-center gap-2" aria-hidden="true">
                <span class="h-px w-8 bg-blue-500"></span>
                <span class="size-1.5 rounded-full bg-cyan-400"></span>
            </div>

            <div class="mt-5 flex flex-wrap items-end justify-between gap-4">
                <h2 class="text-3xl font-semibold tracking-tight text-balance text-zinc-50 sm:text-4xl">Novedades</h2>
                <a class="text-sm font-semibold text-blue-400 transition-colors hover:text-blue-300 focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-blue-500" href="{{ route('blog.index') }}">Ver todas las entradas</a>
            </div>

            <div class="mt-10 grid gap-5 sm:mt-12 md:grid-cols-2 lg:grid-cols-3 lg:gap-6">
                @foreach ($posts as $post)
                    <article class="flex h-full flex-col rounded-xl border border-zinc-800 bg-zinc-900/60 p-6 transition-colors duration-300 hover:border-blue-500/40 hover:bg-zinc-900 sm:p-7">
                        <p class="text-sm text-zinc-400">
                            <time datetime="{{ $post->published_at }}">{{ $post->published_at }}</time>
                        </p>
                        <h3 class="mt-2 text-lg font-semibold tracking-tight text-zinc-50 sm:text-xl">{{ $post->title }}</h3>
                        <p class="mt-3 text-sm leading-relaxed text-pretty text-zinc-400 sm:text-base">{{ $post->summary }}</p>

                        <a class="mt-auto pt-6 text-sm font-semibold text-blue-400 transition-colors hover:text-blue-300 focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-blue-500" href="{{ route('blog.show', ['id' => $post->id]) }}">Leer entrada</a>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
</x-layouts.main>
