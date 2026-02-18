<x-layouts.app :title="__('Gestion de Roles')">

    {{-- Contenedor principal --}}
    <div class="max-w-7xl mx-auto space-y-4 sm:space-y-6 px-4 sm:px-6 lg:px-0">

        {{-- Encabezado --}}
        <x-ui.page-header
            eyebrow="Sistema de Roles"
            title="Asignacion de Roles"
            subtitle="Administra los roles de usuarios del sistema SCR."
            eyebrowTone="emerald"
        >
            <x-slot:actions>
                <div class="hidden md:flex items-center gap-2 px-3 py-2 bg-white border border-emerald-100 rounded-xl shadow-sm">
                    <span class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center font-semibold">US</span>
                    <div>
                        <p class="text-xs text-slate-400">Total usuarios</p>
                        <p class="text-lg font-semibold text-slate-800" id="usersTotalCount"></p>
                    </div>
                </div>
                <a href="{{ route('roles.create') }}"
                    class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-emerald-500 hover:bg-emerald-400 text-white px-4 py-2.5 rounded-xl font-medium transition-all duration-200 shadow-sm hover:shadow-md">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    <span>Asignar Rol</span>
                </a>
            </x-slot:actions>
        </x-ui.page-header>

        {{-- Barra de herramientas --}}
        <div class="flex flex-col gap-3 sm:gap-4 md:flex-row md:items-center md:justify-between bg-white border border-slate-200 rounded-xl px-3 sm:px-4 py-3 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs uppercase tracking-wide text-slate-400 font-semibold">Listado</p>
                    <p class="text-base font-semibold text-slate-800">Usuarios y Roles</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <div class="relative w-full sm:w-auto">
                    <input
                        id="searchUsers"
                        type="search"
                        placeholder="Buscar usuario..."
                        class="w-full sm:w-auto pl-10 pr-4 py-2.5 rounded-lg border border-slate-200 bg-white text-sm text-slate-700 focus:ring-2 focus:ring-emerald-200 focus:border-emerald-400 shadow-sm"
                    >
                    <svg class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M11 18a7 7 0 100-14 7 7 0 000 14z" />
                    </svg>
                </div>
                <div class="hidden sm:flex items-center gap-2 text-xs text-slate-500">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    Sincronizado en vivo
                </div>
            </div>
        </div>
    </div>

    {{-- Tabla AJAX (solo desktop) --}}
    <div class="mt-6 bg-white rounded-2xl shadow-sm border border-slate-200 p-4 hidden md:block">
        <div class="overflow-hidden border border-slate-100 rounded-xl">
            <table id="usersTable" class="w-full text-sm text-left">
                <thead class="bg-slate-50 text-slate-600 uppercase text-xs tracking-wide">
                    <tr>
                        <th class="px-4 py-3 font-semibold">#</th>
                        <th class="px-4 py-3 font-semibold">Nombre</th>
                        <th class="px-4 py-3 font-semibold">Email</th>
                        <th class="px-4 py-3 font-semibold">Roles</th>
                        <th class="px-4 py-3 font-semibold">Registro</th>
                        <th class="px-4 py-3 font-semibold text-center">Acciones</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    {{-- Cards mobile --}}
    <div id="mobileCards" class="mt-6 space-y-3 md:hidden"></div>
    <div id="mobileCardsPagination" class="mt-4 md:hidden"></div>

    {{-- CDNs & SCRIPT --}}
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

            function renderMobilePagination() {
                const totalRows = mobileState.filteredRows.length;
                const totalPages = Math.ceil(totalRows / mobileState.pageSize);
                const container = $('#mobileCardsPagination');

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
                const container = $('#mobileCards');
                const totalRows = mobileState.filteredRows.length;

                if (!totalRows) {
                    container.html('<div class="text-center text-slate-400 py-8 text-sm">No hay usuarios registrados.</div>');
                    $('#mobileCardsPagination').empty();
                    return;
                }

                const totalPages = Math.ceil(totalRows / mobileState.pageSize);
                if (mobileState.currentPage > totalPages) {
                    mobileState.currentPage = totalPages;
                }
                if (mobileState.currentPage < 1) {
                    mobileState.currentPage = 1;
                }

                const start = (mobileState.currentPage - 1) * mobileState.pageSize;
                const pageRows = mobileState.filteredRows.slice(start, start + mobileState.pageSize);

                container.empty();
                pageRows.forEach(function(row) {
                    const safeName = stripHtml(row.name);
                    const safeEmail = stripHtml(row.email);
                    const safeCreated = stripHtml(row.created_at);
                    const safeRoles = stripHtml(row.roles) || 'Sin rol';
                    const safeId = stripHtml(row.id);
                    const card = `
                        <div class="mobile-card bg-white rounded-xl border border-slate-200 shadow-sm p-4 space-y-3">
                            <div class="flex items-center justify-between">
                                <div class="min-w-0">
                                    <p class="text-sm font-semibold text-slate-800 truncate">${safeName}</p>
                                    <p class="text-xs text-slate-400 truncate">#${safeId}</p>
                                </div>
                                <div class="shrink-0">
                                    ${row.acciones ?? ''}
                                </div>
                            </div>
                            <div class="space-y-2 text-xs text-slate-500">
                                <p><span class="font-medium text-slate-700">Email:</span> ${safeEmail}</p>
                                <p><span class="font-medium text-slate-700">Roles:</span> ${safeRoles}</p>
                                <p><span class="font-medium text-slate-700">Registro:</span> ${safeCreated}</p>
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
                $('#usersTotalCount').text(rows.length);
                renderMobileCards();
            }

            function filterMobileRows(query) {
                const term = String(query ?? '').trim().toLowerCase();
                if (!term) {
                    mobileState.filteredRows = mobileState.allRows.slice();
                } else {
                    mobileState.filteredRows = mobileState.allRows.filter(function(row) {
                        return normalize(row.id).includes(term)
                            || normalize(row.name).includes(term)
                            || normalize(row.email).includes(term)
                            || normalize(row.roles).includes(term)
                            || normalize(row.created_at).includes(term);
                    });
                }
                mobileState.currentPage = 1;
                renderMobileCards();
            }

            $('#mobileCardsPagination').on('click', 'button[data-page]', function() {
                const requestedPage = Number($(this).attr('data-page'));
                if (!Number.isInteger(requestedPage)) {
                    return;
                }

                const maxPage = Math.max(1, Math.ceil(mobileState.filteredRows.length / mobileState.pageSize));
                mobileState.currentPage = Math.min(Math.max(requestedPage, 1), maxPage);
                renderMobileCards();
            });

            const table = $('#usersTable').DataTable({
                processing: true,
                serverSide: false,
                ajax: {
                    url: '{{ route("roles.index") }}',
                    dataSrc: function(json) {
                        const rows = Array.isArray(json.data) ? json.data : [];
                        setMobileRows(rows);
                        return rows;
                    }
                },
                dom: 'lrtip',
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'name', name: 'name' },
                    { data: 'email', name: 'email' },
                    { data: 'roles', name: 'roles' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'acciones', name: 'acciones', orderable: false, searchable: false }
                ],
                columnDefs: [
                    { targets: [0, 4], className: 'users-nowrap-cell' },
                    { targets: [5], className: 'users-actions-cell' },
                ],
                language: { url: '/i18n/es-ES.json' },
                pageLength: 10,
                autoWidth: false,
                responsive: true
            });

            // Busqueda filtra tabla y cards
            $('#searchUsers').on('keyup', function() {
                table.search(this.value).draw();
                filterMobileRows(this.value);
            });
        });
    </script>

</x-layouts.app>
