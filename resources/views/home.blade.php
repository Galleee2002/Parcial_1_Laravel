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
                    @php
                        $qrModule = function (int $r, int $c): ?string {
                            if (($r < 7 && ($c < 7 || $c > 13)) || ($r > 13 && $c < 7)) {
                                $lr = $r % 14;
                                $lc = $c % 14;
                                $center = $lr >= 2 && $lr <= 4 && $lc >= 2 && $lc <= 4;

                                if ($center) {
                                    return $r < 7 && $c < 7 ? 'bg-blue-500' : 'bg-zinc-950';
                                }

                                return in_array($lr, [0, 6]) || in_array($lc, [0, 6]) ? 'bg-zinc-950' : null;
                            }

                            if (($r === 7 && ($c < 8 || $c > 12)) || ($r === 13 && $c < 8) || ($c === 7 && ($r < 8 || $r > 12)) || ($c === 13 && $r < 8)) {
                                return null;
                            }

                            if ($r === 6 || $c === 6) {
                                return ($r + $c) % 2 === 0 ? 'bg-zinc-950' : null;
                            }

                            return hexdec(md5("{$r}-{$c}")[0]) % 2 === 0 ? 'bg-zinc-950' : null;
                        };
                    @endphp
                    <div class="mt-3 grid grid-cols-21 rounded-md bg-zinc-100 p-1.5">
                        @foreach (range(0, 440) as $i)
                            <span class="aspect-square {{ $qrModule(intdiv($i, 21), $i % 21) }}"></span>
                        @endforeach
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

            @php($activeServicesCount = $services->where('is_active', true)->count())
            <div @class([
                'mt-10 grid gap-5 sm:mt-12 md:grid-cols-2 lg:gap-6',
                'xl:grid-cols-4' => $activeServicesCount === 4,
                'lg:grid-cols-3' => $activeServicesCount !== 4,
            ])>
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
</x-layouts.main>
