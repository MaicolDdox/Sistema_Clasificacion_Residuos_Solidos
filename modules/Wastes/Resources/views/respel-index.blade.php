<x-layouts.app :title="__('Residuos peligrosos de la unidad '.$unit->name)">
    <div class="max-w-7xl mx-auto space-y-6">
        <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <p class="text-xs uppercase tracking-[0.2em] text-emerald-600 font-semibold">RESPEL</p>
                    <h1 class="text-2xl font-bold text-slate-900">Residuos peligrosos - {{ $unit->name }}</h1>
                    <p class="text-sm text-slate-500">Agrupados por semanas (lunes a domingo).</p>
                </div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('hazardou-wastes.create', ['unit' => $unit->id]) }}" class="px-4 py-2 rounded-lg bg-emerald-500 text-white text-sm font-semibold hover:bg-emerald-400 transition">
                        Nuevo RESPEL
                    </a>
                    <a href="{{ route('wastes.units.byArea', ['area' => $unit->area_id]) }}" class="px-4 py-2 rounded-lg border border-slate-200 text-slate-600 hover:bg-slate-50 transition text-sm">Volver a unidades</a>
                </div>
            </div>
            @include('partials.session-message')
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-4">
            <div class="overflow-hidden border border-slate-100 rounded-xl">
                <table id="respelTable" class="w-full text-sm text-left">
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
            $('#respelTable').DataTable({
                processing: true,
                serverSide: false,
                ajax: '{{ route("hazardou-wastes.byUnit", $unit) }}',
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
