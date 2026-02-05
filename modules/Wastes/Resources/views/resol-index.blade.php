<x-layouts.app :title="__('Residuos sólidos de la unidad '.$unit->name)">
    <div class="max-w-7xl mx-auto space-y-6">
        <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <p class="text-xs uppercase tracking-[0.2em] text-emerald-600 font-semibold">RESOL</p>
                    <h1 class="text-2xl font-bold text-slate-900">Residuos sólidos - {{ $unit->name }}</h1>
                    <p class="text-sm text-slate-500">Agrupados por semanas (lunes a domingo).</p>
                </div>
                <div class="flex items-center gap-2">
                    <a
                        href="{{ route('wastes.report.resol', $unit) }}"
                        class="inline-flex items-center gap-2 bg-emerald-100 hover:bg-emerald-200 text-emerald-700 px-4 py-2 rounded-lg transition-all duration-200"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M11 3a1 1 0 011 1v14a1 1 0 11-2 0V4a1 1 0 011-1zm5 4a1 1 0 011 1v10a1 1 0 11-2 0V8a1 1 0 011-1zm-10 6a1 1 0 011 1v4a1 1 0 11-2 0v-4a1 1 0 011-1z"/>
                        </svg>
                        Reporte gráfico
                    </a>
                    <a href="{{ route('wastes.create', ['unit' => $unit->id]) }}" class="px-4 py-2 rounded-lg bg-emerald-500 text-white text-sm font-semibold hover:bg-emerald-400 transition">
                        Nuevo RESOL
                    </a>
                    <a href="{{ route('wastes.units.byArea', ['area' => $unit->area_id]) }}" class="px-4 py-2 rounded-lg border border-slate-200 text-slate-600 hover:bg-slate-50 transition text-sm">Volver a unidades</a>
                </div>
            </div>
            @include('partials.session-message')
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-4">
            <div class="overflow-hidden border border-slate-100 rounded-xl">
                <table id="resolTable" class="w-full text-sm text-left">
                    <thead class="bg-slate-50 text-slate-600 uppercase text-xs tracking-wide">
                        <tr>
                            <th class="px-4 py-3 font-semibold">Fecha entrada</th>
                            <th class="px-4 py-3 font-semibold">Tipo</th>
                            <th class="px-4 py-3 font-semibold">Cantidad</th>
                            <th class="px-4 py-3 font-semibold">Observaciones</th>
                            <th class="px-4 py-3 font-semibold">Usuario</th>
                            <th class="px-4 py-3 font-semibold text-center">Acciones</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    @include('partials.footer-script-cdn')
    <link rel="stylesheet" href="https://cdn.datatables.net/rowgroup/1.5.0/css/rowGroup.dataTables.min.css">
    <script src="https://cdn.datatables.net/rowgroup/1.5.0/js/dataTables.rowGroup.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            $('#resolTable').DataTable({
                processing: true,
                serverSide: false,
                ajax: '{{ route("wastes.byUnit", $unit) }}',
                dom: 'lrtip',
                order: [[0, 'desc']],
                rowGroup: { dataSrc: 'grupo_semana' },
                columns: [
                    { data: 'entry_date', name: 'entry_date' },
                    { data: 'waste_type', name: 'waste_type' },
                    { data: 'amount', name: 'amount' },
                    { data: 'observations', name: 'observations' },
                    { data: 'usuario', name: 'usuario' },
                    { data: 'acciones', name: 'acciones', orderable: false, searchable: false },
                ],
                language: { url: '/i18n/es-ES.json' },
                pageLength: 10,
                responsive: true,
            });
        });
    </script>
</x-layouts.app>
