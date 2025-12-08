<x-layouts.app :title="__('Reporte RESPEL - '.$unit->name)">
    <div class="max-w-7xl mx-auto space-y-6">
        <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                <div>
                    <p class="text-xs uppercase tracking-[0.2em] text-rose-600 font-semibold">Reporte gráfico</p>
                    <h1 class="text-2xl font-bold text-slate-900">Residuos peligrosos - {{ $unit->name }}</h1>
                    <p class="text-sm text-slate-500">Visualiza cantidades por día, tipo, semana, mes y usuario.</p>
                </div>
                <a href="{{ route('hazardou-wastes.byUnit', ['unit' => $unit->id]) }}" class="px-4 py-2 rounded-lg border border-slate-200 text-slate-600 hover:bg-slate-50 transition text-sm">← Volver al listado</a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-sm">
                <h3 class="text-sm font-semibold text-slate-700 mb-2">Cantidad por día</h3>
                <div id="chartCantidadPorDia"></div>
            </div>
            <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-sm">
                <h3 class="text-sm font-semibold text-slate-700 mb-2">Cantidad por tipo</h3>
                <div id="chartCantidadesPorTipo"></div>
            </div>
            <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-sm">
                <h3 class="text-sm font-semibold text-slate-700 mb-2">Cantidad semanal</h3>
                <div id="chartSemanal"></div>
            </div>
            <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-sm">
                <h3 class="text-sm font-semibold text-slate-700 mb-2">Acumulado mensual</h3>
                <div id="chartMensual"></div>
            </div>
            <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-sm lg:col-span-2">
                <h3 class="text-sm font-semibold text-slate-700 mb-2">Distribución por usuario</h3>
                <div id="chartUsuarios"></div>
            </div>
        </div>
    </div>

    @include('partials.footer-script-cdn')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        const color = '{{ $color }}';
        // Cantidad por día (línea)
        new ApexCharts(document.querySelector('#chartCantidadPorDia'), {
            chart: { type: 'line', height: 320, toolbar: { show: false } },
            stroke: { curve: 'smooth', width: 3 },
            colors: [color],
            series: [{ name: 'Cantidad', data: @json($byDay['series']) }],
            xaxis: { categories: @json($byDay['categories']), labels: { rotate: -45 } },
            dataLabels: { enabled: false },
            tooltip: { shared: true, intersect: false },
            grid: { borderColor: '#f1f5f9' }
        }).render();

        // Cantidad por tipo (barras)
        new ApexCharts(document.querySelector('#chartCantidadesPorTipo'), {
            chart: { type: 'bar', height: 320, toolbar: { show: false } },
            plotOptions: { bar: { borderRadius: 6, columnWidth: '55%' } },
            colors: [color],
            series: [{ name: 'Cantidad', data: @json($byType['series']) }],
            xaxis: { categories: @json($byType['labels']) },
            dataLabels: { enabled: false },
            grid: { borderColor: '#f1f5f9' }
        }).render();

        // Cantidad semanal (área)
        new ApexCharts(document.querySelector('#chartSemanal'), {
            chart: { type: 'area', height: 320, toolbar: { show: false } },
            colors: [color],
            series: [{ name: 'Cantidad', data: @json($byWeek['series']) }],
            xaxis: { categories: @json($byWeek['categories']), labels: { rotate: -45 } },
            dataLabels: { enabled: false },
            stroke: { curve: 'smooth' },
            grid: { borderColor: '#f1f5f9' }
        }).render();

        // Acumulado mensual (barras apiladas)
        new ApexCharts(document.querySelector('#chartMensual'), {
            chart: { type: 'bar', height: 320, stacked: true, toolbar: { show: false } },
            plotOptions: { bar: { borderRadius: 6, columnWidth: '55%' } },
            colors: [color],
            series: [{ name: 'Cantidad', data: @json($byMonth['series']) }],
            xaxis: { categories: @json($byMonth['categories']) },
            dataLabels: { enabled: false },
            grid: { borderColor: '#f1f5f9' }
        }).render();

        // Distribución por usuario (donut)
        new ApexCharts(document.querySelector('#chartUsuarios'), {
            chart: { type: 'donut', height: 360 },
            labels: @json($byUser['labels']),
            series: @json($byUser['series']),
            colors: ['#f43f5e', '#fb7185', '#fda4af', '#fecdd3', '#ffe4e6'],
            legend: { position: 'bottom' },
            dataLabels: { enabled: true }
        }).render();
    </script>
</x-layouts.app>
