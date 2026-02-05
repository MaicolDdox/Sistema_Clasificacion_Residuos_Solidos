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
            <div class="overflow-hidden border border-slate-100 rounded-xl">
                <table id="unitsByAreaTable" class="w-full text-sm text-left">
                    <thead class="bg-slate-50 text-slate-600 uppercase text-xs tracking-wide">
                        <tr>
                            <th class="px-4 py-3 font-semibold">Unidad productiva</th>
                            <th class="px-4 py-3 font-semibold text-center">Acciones</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    @include('partials.footer-script-cdn')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const table = $('#unitsByAreaTable').DataTable({
                processing: true,
                serverSide: false,
                ajax: '{{ route("wastes.units.byArea", $area) }}',
                dom: 'lrtip',
                columns: [
                    { data: 'name', name: 'name' },
                    { data: 'acciones', name: 'acciones', orderable: false, searchable: false }
                ],
                language: { url: '/i18n/es-ES.json' },
                pageLength: 10,
                responsive: true,
            });
        });
    </script>
</x-layouts.app>
