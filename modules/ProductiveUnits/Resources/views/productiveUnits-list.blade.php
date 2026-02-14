<x-layouts.app :title="__('Unidades Productivas')">

    {{-- Contenedor principal --}}
    <div class="max-w-7xl mx-auto space-y-6">

        {{-- Encabezado --}}
        <div class="bg-gradient-to-r from-emerald-50 via-white to-cyan-50 border border-emerald-100 rounded-2xl p-6 shadow-sm">
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div class="space-y-2">
                    <p class="inline-flex items-center text-xs font-semibold uppercase tracking-[0.2em] text-emerald-600 bg-emerald-50 rounded-full px-3 py-1">
                        <span class="w-2 h-2 bg-emerald-500 rounded-full mr-2"></span>
                        Catalogo
                    </p>
                    <div>
                        <h1 class="text-3xl font-bold text-slate-900 leading-tight">Gestion de Unidades Productivas</h1>
                        <p class="text-slate-500">Administra las unidades productivas y su area asignada con acciones rapidas.</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <div class="hidden md:flex items-center gap-2 px-3 py-2 bg-white border border-emerald-100 rounded-xl shadow-sm">
                        <span class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center font-semibold">UP</span>
                        <div>
                            <p class="text-xs text-slate-400">Total registros</p>
                            <p class="text-lg font-semibold text-slate-800" id="unitsTotalCount">—</p>
                        </div>
                    </div>
                    <a href="{{ route('productive-units.create') }}"
                       class="inline-flex items-center gap-2 bg-emerald-500 hover:bg-emerald-400 text-white px-4 py-2.5 rounded-xl font-medium transition-all duration-200 shadow-sm hover:shadow-md">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        <span>Nueva Unidad</span>
                    </a>
                </div>
            </div>
        </div>

        {{-- Mensajes de confirmacion --}}
        @include('partials.session-message')

        {{-- Barra de herramientas --}}
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between bg-white border border-slate-200 rounded-xl px-4 py-3 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 4h16v5H4zM4 13h16v7H4z" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs uppercase tracking-wide text-slate-400 font-semibold">Listado</p>
                    <p class="text-base font-semibold text-slate-800">Unidades registradas</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <div class="relative">
                    <input
                        id="searchUnits"
                        type="search"
                        placeholder="Buscar unidad..."
                        class="pl-10 pr-4 py-2.5 rounded-lg border border-slate-200 bg-white text-sm text-slate-700 focus:ring-2 focus:ring-emerald-200 focus:border-emerald-400 shadow-sm"
                    >
                    <svg class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M11 18a7 7 0 100-14 7 7 0 000 14z" />
                    </svg>
                </div>
                <div class="flex items-center gap-2 text-xs text-slate-500">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    Sincronizado en vivo
                </div>
            </div>
        </div>
    </div>

    {{-- Tabla AJAX --}}
    <div class="mt-6 bg-white rounded-2xl shadow-sm border border-slate-200 p-4">
        <div class="overflow-hidden border border-slate-100 rounded-xl">
            <table id="productiveUnitsTable" class="w-full text-sm text-left">
                <thead class="bg-slate-50 text-slate-600 uppercase text-xs tracking-wide">
                    <tr>
                        <th class="px-4 py-3 font-semibold">#</th>
                        <th class="px-4 py-3 font-semibold">Area</th>
                        <th class="px-4 py-3 font-semibold">Nombre</th>
                        <th class="px-4 py-3 font-semibold">Descripcion</th>
                        <th class="px-4 py-3 font-semibold">Tipo Residuo</th>
                        <th class="px-4 py-3 font-semibold">Creacion</th>
                        <th class="px-4 py-3 font-semibold">Actualizacion</th>
                        <th class="px-4 py-3 font-semibold text-center">Acciones</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    {{-- ================== CDNs & SCRIPT ================== --}}
    @include('partials.footer-script-cdn')

    {{-- Script busqueda + paginacion AJAX --}}
    <script>
        $(document).ready(function() {
            const table = $('#productiveUnitsTable').DataTable({
                processing: true,
                serverSide: false,
                ajax: '{{ route("productive-units.index") }}',
                dom: 'lrtip', // ocultar search box nativo (usamos el superior)
                columns: [
                    { data: 'id', name: 'id' },
                    {
                        data: 'area',
                        name: 'area',
                        render: function(data) {
                            return `
                                <div class="flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                                    </svg>
                                    <span class="text-sm text-foreground">${data ?? 'Sin area'}</span>
                                </div>`;
                        }
                    },
                    {
                        data: 'name',
                        name: 'name',
                        render: function(data) {
                            return `
                                <div class="flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M6 8h12M6 12h7m-7 4h9" />
                                    </svg>
                                    <span class="text-sm text-foreground">${data ?? ''}</span>
                                </div>`;
                        }
                    },
                    {
                        data: 'description',
                        name: 'description',
                        render: function(data) {
                            return `
                                <div class="flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M8 9h8M8 13h5m-9 5h12a2 2 0 002-2V7a2 2 0 00-2-2H4a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                    </svg>
                                    <span class="text-sm text-foreground">${data ?? ''}</span>
                                </div>`;
                        }
                    },
                    {
                        data: 'waste_type',
                        name: 'waste_type',
                        render: function(data) {
                            let badgeClass = 'bg-slate-100 text-slate-700';
                            if (data === 'Residuos Solidos') badgeClass = 'bg-blue-100 text-blue-700';
                            if (data === 'Residuos Peligrosos') badgeClass = 'bg-red-100 text-amber-700';
                            if (data === 'RESOL/RESPEL') badgeClass = 'bg-purple-100 text-purple-700';
                            
                            return `
                                <div class="flex items-center space-x-2">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${badgeClass}">
                                        ${data ?? 'No definido'}
                                    </span>
                                </div>`;
                        }
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        render: function(data) {
                            return `
                                <div class="flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span class="text-sm text-foreground">${data ?? ''}</span>
                                </div>`;
                        }
                    },
                    {
                        data: 'updated_at',
                        name: 'updated_at',
                        render: function(data) {
                            return `
                                <div class="flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M4 4v5h.582M20 20v-5h-.581M5.582 9A7 7 0 0112 5c2.761 0 5.112 1.59 6.418 3.922M18.418 15A7 7 0 0112 19a7 7 0 01-6.418-3.922" />
                                    </svg>
                                    <span class="text-sm text-foreground">${data ?? ''}</span>
                                </div>`;
                        }
                    },
                    { data: 'acciones', name: 'acciones', orderable: false, searchable: false }
                ],
                language: { url: '/i18n/es-ES.json' },
                pageLength: 10,
                responsive: true
            });

            // Filtro en tiempo real si existe el input
            $('#searchUnits').on('keyup', function() {
                table.search(this.value).draw();
            });

            // Total de registros (solo si llega data)
            table.on('xhr', function() {
                const json = table.ajax.json();
                const total = json && json.data ? json.data.length : 0;
                $('#unitsTotalCount').text(total);
            });
        });
    </script>

</x-layouts.app>
