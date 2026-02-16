<x-layouts.app :title="__('Unidades del área '.$area->name)">
    <div class="max-w-7xl mx-auto space-y-6">
        <div class="bg-gradient-to-r from-emerald-50 via-white to-cyan-50 border border-emerald-100 rounded-2xl p-6 shadow-sm">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div class="space-y-2">
                    <p class="inline-flex items-center text-xs font-semibold uppercase tracking-[0.2em] text-emerald-600 bg-emerald-50 rounded-full px-3 py-1">
                        <span class="w-2 h-2 bg-emerald-500 rounded-full mr-2"></span>
                        Residuos
                    </p>
                    <div>
                        <h1 class="text-3xl font-bold text-slate-900 leading-tight">Unidades productivas del Área {{ $area->name }}</h1>
                        <p class="text-slate-500">Selecciona una unidad para registrar o consultar residuos.</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ url()->previous() }}" class="px-3 py-2 rounded-lg border border-slate-200 text-slate-600 hover:bg-slate-50 transition text-sm">
                        ← Volver
                    </a>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-4">
            <div class="md:hidden mb-4">
                <div class="relative">
                    <input
                        id="unitsByAreaMobileSearch"
                        type="search"
                        placeholder="Buscar unidad productiva..."
                        class="w-full pl-10 pr-4 py-2.5 rounded-lg border border-slate-200 bg-white text-sm text-slate-700 focus:ring-2 focus:ring-emerald-200 focus:border-emerald-400 shadow-sm"
                    >
                    <svg class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M11 18a7 7 0 100-14 7 7 0 000 14z" />
                    </svg>
                </div>
            </div>

            <div class="w-full max-w-full overflow-x-auto border border-slate-100 rounded-xl hidden md:block">
                <table id="unitsByAreaTable" class="w-full min-w-[740px] table-auto text-sm text-left">
                    <thead class="bg-slate-50 text-slate-600 uppercase text-xs tracking-wide">
                        <tr>
                            <th class="px-4 py-3 font-semibold">Unidad productiva</th>
                            <th class="px-4 py-3 font-semibold text-center whitespace-nowrap">Acciones</th>
                        </tr>
                    </thead>
                </table>
            </div>

            <div id="unitsByAreaMobileCards" class="space-y-3 md:hidden"></div>
            <div id="unitsByAreaMobilePagination" class="mt-4 md:hidden"></div>
        </div>
    </div>

    @include('partials.footer-script-cdn')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
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
                const container = $('#unitsByAreaMobilePagination');

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
                const container = $('#unitsByAreaMobileCards');
                const totalRows = mobileState.filteredRows.length;

                if (!totalRows) {
                    container.html('<div class="text-center text-slate-400 py-8 text-sm">No hay unidades disponibles en esta área.</div>');
                    $('#unitsByAreaMobilePagination').empty();
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
                            <div>
                                <p class="text-sm font-semibold text-slate-800">${stripHtml(row.name)}</p>
                            </div>
                            <div class="pt-2 border-t border-slate-100">
                                ${row.acciones ?? ''}
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
                renderMobileCards();
            }

            function filterMobileRows(query) {
                const term = String(query ?? '').trim().toLowerCase();
                if (!term) {
                    mobileState.filteredRows = mobileState.allRows.slice();
                } else {
                    mobileState.filteredRows = mobileState.allRows.filter(function(row) {
                        return normalize(row.name).includes(term);
                    });
                }
                mobileState.currentPage = 1;
                renderMobileCards();
            }

            $('#unitsByAreaMobilePagination').on('click', 'button[data-page]', function() {
                const requestedPage = Number($(this).attr('data-page'));
                if (!Number.isInteger(requestedPage)) {
                    return;
                }

                const maxPage = Math.max(1, Math.ceil(mobileState.filteredRows.length / mobileState.pageSize));
                mobileState.currentPage = Math.min(Math.max(requestedPage, 1), maxPage);
                renderMobileCards();
            });

            $('#unitsByAreaMobileSearch').on('keyup', function() {
                filterMobileRows(this.value);
            });

            const table = $('#unitsByAreaTable').DataTable({
                processing: true,
                serverSide: false,
                ajax: {
                    url: '{{ route("wastes.units.byArea", $area) }}',
                    dataSrc: function(json) {
                        const rows = Array.isArray(json.data) ? json.data : [];
                        setMobileRows(rows);
                        return rows;
                    }
                },
                dom: 'lrtip',
                columns: [
                    { data: 'name', name: 'name' },
                    { data: 'acciones', name: 'acciones', orderable: false, searchable: false }
                ],
                columnDefs: [
                    { targets: 0, className: 'units-name-cell' },
                    { targets: 1, className: 'units-actions-cell' },
                ],
                language: { url: '/i18n/es-ES.json' },
                pageLength: 10,
                autoWidth: false,
                responsive: true,
            });
        });
    </script>
</x-layouts.app>
