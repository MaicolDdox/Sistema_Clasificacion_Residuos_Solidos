<x-layouts.app :title="__('Unidades Productivas')">

    <div class="max-w-7xl mx-auto space-y-4 md:space-y-6 px-4 sm:px-6 lg:px-8">
        <x-ui.page-header
            eyebrow="Catalogo"
            title="Gestion de Unidades Productivas"
            subtitle="Administra las unidades productivas y su area asignada con acciones rapidas."
            eyebrowTone="emerald"
        >
            <x-slot:actions>
                <div class="hidden lg:flex items-center gap-2 px-3 py-2 bg-white border border-emerald-100 rounded-xl shadow-sm">
                    <span class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center font-semibold text-sm">UP</span>
                    <div>
                        <p class="text-xs text-slate-400">Total registros</p>
                        <p class="text-lg font-semibold text-slate-800" id="unitsTotalCount">—</p>
                    </div>
                </div>
                @can('productive-units.create')
                    <a href="{{ route('productive-units.create') }}"
                        class="inline-flex items-center justify-center gap-2 bg-emerald-500 hover:bg-emerald-400 text-white px-4 py-2.5 rounded-xl font-medium transition-all duration-200 shadow-sm hover:shadow-md whitespace-nowrap text-sm md:text-base">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        <span>Nueva Unidad Productiva</span>
                    </a>
                @endcan
            </x-slot:actions>
        </x-ui.page-header>

        @include('partials.session-message')

        <div class="flex flex-col gap-3 md:gap-4 md:flex-row md:items-center md:justify-between bg-white border border-slate-200 rounded-xl px-3 md:px-4 py-3 shadow-sm">
            <div class="flex items-center gap-2 md:gap-3">
                <div class="w-9 h-9 md:w-10 md:h-10 bg-emerald-50 text-emerald-600 rounded-lg md:rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs uppercase tracking-wide text-slate-400 font-semibold">Listado</p>
                    <p class="text-sm md:text-base font-semibold text-slate-800">Unidades registradas</p>
                </div>
            </div>
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 md:gap-3">
                <div class="relative flex-1 sm:flex-initial">
                    <input
                        id="searchUnits"
                        type="search"
                        placeholder="Buscar unidad..."
                        class="w-full pl-9 md:pl-10 pr-3 md:pr-4 py-2 md:py-2.5 rounded-lg border border-slate-200 bg-white text-sm text-slate-700 focus:ring-2 focus:ring-emerald-200 focus:border-emerald-400 shadow-sm"
                    >
                    <svg class="w-4 h-4 text-slate-400 absolute left-2.5 md:left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M11 18a7 7 0 100-14 7 7 0 000 14z" />
                    </svg>
                </div>
                <div class="hidden md:flex items-center gap-2 text-xs text-slate-500">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    Sincronizado en vivo
                </div>
            </div>
        </div>
    </div>

    <div class="mt-4 md:mt-6 bg-white rounded-xl md:rounded-2xl shadow-sm border border-slate-200 p-2 md:p-4 mx-4 sm:mx-6 lg:mx-8 hidden md:block">
        <div class="overflow-x-auto border border-slate-100 rounded-lg md:rounded-xl">
            <table id="productiveUnitsTable" class="w-full text-sm text-left">
                <thead class="bg-slate-50 text-slate-600 uppercase text-xs tracking-wide">
                    <tr>
                        <th class="px-2 md:px-4 py-2 md:py-3 font-semibold">#</th>
                        <th class="px-2 md:px-4 py-2 md:py-3 font-semibold">Area</th>
                        <th class="px-2 md:px-4 py-2 md:py-3 font-semibold">Nombre</th>
                        <th class="px-2 md:px-4 py-2 md:py-3 font-semibold hidden lg:table-cell">Descripcion</th>
                        <th class="px-2 md:px-4 py-2 md:py-3 font-semibold hidden lg:table-cell">Tipo Residuo</th>
                        <th class="px-2 md:px-4 py-2 md:py-3 font-semibold hidden xl:table-cell">Creacion</th>
                        <th class="px-2 md:px-4 py-2 md:py-3 font-semibold hidden xl:table-cell">Actualizacion</th>
                        <th class="px-2 md:px-4 py-2 md:py-3 font-semibold text-center">Acciones</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <div id="unitsMobileCards" class="mt-4 mx-4 sm:mx-6 lg:mx-8 space-y-3 md:hidden"></div>
    <div id="unitsMobilePagination" class="mt-4 mx-4 sm:mx-6 lg:mx-8 md:hidden"></div>

    @include('partials.footer-script-cdn')

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
                    const card = `
                        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4 space-y-3">
                            <div class="flex items-center justify-between gap-3">
                                <div class="min-w-0">
                                    <p class="text-sm font-semibold text-slate-800 truncate">${stripHtml(row.name)}</p>
                                    <p class="text-xs text-slate-400">#${stripHtml(row.id)}</p>
                                </div>
                                <div class="shrink-0">
                                    ${row.acciones ?? ''}
                                </div>
                            </div>
                            <div class="space-y-2 text-xs text-slate-500">
                                ${row.mobile_info ?? ''}
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
                dom: 'lrtip',
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'area', name: 'area' },
                    { data: 'name', name: 'name' },
                    { data: 'description', name: 'description' },
                    { data: 'waste_type', name: 'waste_type' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'updated_at', name: 'updated_at' },
                    { data: 'acciones', name: 'acciones', orderable: false, searchable: false }
                ],
                columnDefs: [
                    { targets: [0, 5, 6], className: 'areas-nowrap-cell' },
                    { targets: [7], className: 'areas-actions-cell' },
                ],
                language: { url: '/i18n/es-ES.json' },
                pageLength: 10,
                autoWidth: false,
                responsive: true
            });

            $('#searchUnits').on('keyup', function() {
                table.search(this.value).draw();
                filterMobileRows(this.value);
            });
        });
    </script>

</x-layouts.app>
