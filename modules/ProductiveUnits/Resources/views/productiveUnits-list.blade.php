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

    {{-- Tabla AJAX (solo desktop) --}}
    <div class="mt-6 bg-white rounded-2xl shadow-sm border border-slate-200 p-4 hidden md:block">
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

    {{-- Cards mobile --}}
    <div id="unitsMobileCards" class="mt-6 space-y-3 md:hidden"></div>
    <div id="unitsMobilePagination" class="mt-4 md:hidden"></div>

    {{-- ================== CDNs & SCRIPT ================== --}}
    @include('partials.footer-script-cdn')

    {{-- Script busqueda + paginacion AJAX --}}
    <script>
        $(document).ready(function() {
            const mobileState = {
                allRows: [],
                filteredRows: [],
                currentPage: 1,
                pageSize: 10,
            };

            function stripHtml(value) {
                return $('<div>').html(value ?? '').text();
            }

            function normalize(value) {
                return stripHtml(value).toLowerCase();
            }

            function wasteBadgeClass(value) {
                if (value === 'Residuos Solidos') {
                    return 'bg-blue-100 text-blue-700';
                }
                if (value === 'Residuos Peligrosos') {
                    return 'bg-red-100 text-amber-700';
                }
                if (value === 'RESOL/RESPEL') {
                    return 'bg-purple-100 text-purple-700';
                }

                return 'bg-slate-100 text-slate-700';
            }

            function renderMobilePagination() {
                const totalRows = mobileState.filteredRows.length;
                const totalPages = Math.ceil(totalRows / mobileState.pageSize);
                const container = $('#unitsMobilePagination');

                if (totalPages <= 1) {
                    container.empty();
                    return;
                }

                const previousDisabled = mobileState.currentPage === 1;
                const nextDisabled = mobileState.currentPage === totalPages;

                container.html(`
                    <div class="flex items-center justify-between gap-2 bg-white border border-slate-200 rounded-xl p-2 shadow-sm">
                        <button
                            type="button"
                            data-page="${mobileState.currentPage - 1}"
                            class="px-3 py-2 text-sm rounded-lg border border-slate-200 text-slate-700 ${previousDisabled ? 'opacity-50 pointer-events-none' : 'hover:bg-slate-50'}"
                        >
                            Anterior
                        </button>
                        <p class="text-xs sm:text-sm text-slate-500 text-center">
                            Página ${mobileState.currentPage} de ${totalPages}
                        </p>
                        <button
                            type="button"
                            data-page="${mobileState.currentPage + 1}"
                            class="px-3 py-2 text-sm rounded-lg border border-slate-200 text-slate-700 ${nextDisabled ? 'opacity-50 pointer-events-none' : 'hover:bg-slate-50'}"
                        >
                            Siguiente
                        </button>
                    </div>
                `);
            }

            function renderMobileCards() {
                const container = $('#unitsMobileCards');
                const totalRows = mobileState.filteredRows.length;

                if (!totalRows) {
                    container.html('<div class="text-center text-slate-400 py-8 text-sm">No hay unidades productivas registradas.</div>');
                    $('#unitsMobilePagination').empty();
                    return;
                }

                const totalPages = Math.ceil(totalRows / mobileState.pageSize);
                mobileState.currentPage = Math.min(Math.max(mobileState.currentPage, 1), totalPages);

                const start = (mobileState.currentPage - 1) * mobileState.pageSize;
                const pageRows = mobileState.filteredRows.slice(start, start + mobileState.pageSize);

                container.empty();
                pageRows.forEach(function(row) {
                    const badgeClass = wasteBadgeClass(row.waste_type);
                    const card = `
                        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4 space-y-3">
                            <div class="flex items-center justify-between gap-3">
                                <div class="min-w-0">
                                    <p class="text-sm font-semibold text-slate-800 truncate">${stripHtml(row.name)}</p>
                                    <p class="text-xs text-slate-400">${stripHtml(row.area) || 'Sin area'}</p>
                                </div>
                                <div class="shrink-0">
                                    ${row.acciones ?? ''}
                                </div>
                            </div>
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${badgeClass}">
                                    ${stripHtml(row.waste_type) || 'No definido'}
                                </span>
                            </div>
                            <div class="space-y-2 text-xs text-slate-500">
                                <p><span class="font-medium text-slate-700">Descripción:</span> ${stripHtml(row.description) || 'Sin descripción'}</p>
                                <p><span class="font-medium text-slate-700">Creación:</span> ${stripHtml(row.created_at)}</p>
                                <p><span class="font-medium text-slate-700">Actualización:</span> ${stripHtml(row.updated_at)}</p>
                            </div>
                        </div>
                    `;
                    container.append(card);
                });

                renderMobilePagination();
            }

            function setMobileRows(rows) {
                mobileState.allRows = rows;
                mobileState.filteredRows = rows.slice();
                mobileState.currentPage = 1;
                $('#unitsTotalCount').text(rows.length);
                renderMobileCards();
            }

            function filterMobileRows(query) {
                const term = String(query ?? '').trim().toLowerCase();
                if (!term) {
                    mobileState.filteredRows = mobileState.allRows.slice();
                } else {
                    mobileState.filteredRows = mobileState.allRows.filter(function(row) {
                        return normalize(row.id).includes(term)
                            || normalize(row.area).includes(term)
                            || normalize(row.name).includes(term)
                            || normalize(row.description).includes(term)
                            || normalize(row.waste_type).includes(term)
                            || normalize(row.created_at).includes(term)
                            || normalize(row.updated_at).includes(term);
                    });
                }
                mobileState.currentPage = 1;
                renderMobileCards();
            }

            $('#unitsMobilePagination').on('click', 'button[data-page]', function() {
                const requestedPage = Number($(this).attr('data-page'));
                if (!Number.isInteger(requestedPage)) {
                    return;
                }

                const maxPage = Math.max(1, Math.ceil(mobileState.filteredRows.length / mobileState.pageSize));
                mobileState.currentPage = Math.min(Math.max(requestedPage, 1), maxPage);
                renderMobileCards();
            });

            const table = $('#productiveUnitsTable').DataTable({
                processing: true,
                serverSide: false,
                ajax: {
                    url: '{{ route("productive-units.index") }}',
                    dataSrc: function(json) {
                        const rows = Array.isArray(json.data) ? json.data : [];
                        setMobileRows(rows);
                        return rows;
                    }
                },
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
                filterMobileRows(this.value);
            });
        });
    </script>

</x-layouts.app>
