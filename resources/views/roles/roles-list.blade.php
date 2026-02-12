<x-layouts.app :title="__('Gestion de Roles')">

    {{-- Contenedor principal --}}
    <div class="max-w-7xl mx-auto space-y-6">

        {{-- Encabezado --}}
        <div class="bg-gradient-to-r from-emerald-50 via-white to-cyan-50 border border-emerald-100 rounded-2xl p-6 shadow-sm">
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div class="space-y-2">
                    <p class="inline-flex items-center text-xs font-semibold uppercase tracking-[0.2em] text-emerald-600 bg-emerald-50 rounded-full px-3 py-1">
                        <span class="w-2 h-2 bg-emerald-500 rounded-full mr-2"></span>
                        Sistema de Roles
                    </p>
                    <div>
                        <h1 class="text-3xl font-bold text-slate-900 leading-tight">Asignacion de Roles</h1>
                        <p class="text-slate-500">Administra los roles de usuarios del sistema SCR.</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <div class="hidden md:flex items-center gap-2 px-3 py-2 bg-white border border-emerald-100 rounded-xl shadow-sm">
                        <span class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center font-semibold">US</span>
                        <div>
                            <p class="text-xs text-slate-400">Total usuarios</p>
                            <p class="text-lg font-semibold text-slate-800" id="usersTotalCount"></p>
                        </div>
                    </div>
                    <a href="{{ route('roles.create') }}"
                       class="inline-flex items-center gap-2 bg-emerald-500 hover:bg-emerald-400 text-white px-4 py-2.5 rounded-xl font-medium transition-all duration-200 shadow-sm hover:shadow-md">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        <span>Asignar Rol</span>
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
                              d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs uppercase tracking-wide text-slate-400 font-semibold">Listado</p>
                    <p class="text-base font-semibold text-slate-800">Usuarios y Roles</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <div class="relative">
                    <input
                        id="searchUsers"
                        type="search"
                        placeholder="Buscar usuario..."
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

    {{-- CDNs & SCRIPT --}}
    @include('partials.footer-script-cdn')

    {{-- Script busqueda + paginacion AJAX --}}
    <script>
        $(document).ready(function() {
            const table = $('#usersTable').DataTable({
                processing: true,
                serverSide: false,
                ajax: '{{ route("roles.index") }}',
                dom: 'lrtip',
                columns: [
                    { data: 'id', name: 'id' },
                    {
                        data: 'name',
                        name: 'name',
                        render: function(data) {
                            return '<div class="flex items-center space-x-2"><svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg><span class="text-sm text-foreground">' + (data ?? '') + '</span></div>';
                        }
                    },
                    {
                        data: 'email',
                        name: 'email',
                        render: function(data) {
                            return '<div class="flex items-center space-x-2"><svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg><span class="text-sm text-foreground">' + (data ?? '') + '</span></div>';
                        }
                    },
                    {
                        data: 'roles',
                        name: 'roles',
                        render: function(data) {
                            return '<div class="flex items-center space-x-2"><svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg><span class="text-sm text-foreground">' + (data ?? '') + '</span></div>';
                        }
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        render: function(data) {
                            return '<div class="flex items-center space-x-2"><svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg><span class="text-sm text-foreground">' + (data ?? '') + '</span></div>';
                        }
                    },
                    { data: 'acciones', name: 'acciones', orderable: false, searchable: false }
                ],
                language: { url: '/i18n/es-ES.json' },
                pageLength: 10,
                responsive: true
            });

            $('#searchUsers').on('keyup', function() {
                table.search(this.value).draw();
            });

            table.on('xhr', function() {
                const json = table.ajax.json();
                const total = json && json.data ? json.data.length : 0;
                $('#usersTotalCount').text(total);
            });
        });
    </script>

</x-layouts.app>
