<x-layouts.app :title="__('Reporte RESOL - '.$unit->name)">
    <div class="max-w-7xl mx-auto space-y-6">
        <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                <div>
                    <p class="text-xs uppercase tracking-[0.2em] text-emerald-600 font-semibold">Reporte gráfico</p>
                    <h1 class="text-2xl font-bold text-slate-900">Residuos sólidos - {{ $unit->name }}</h1>
                    <p class="text-sm text-slate-500">Visualiza cantidades por día, tipo, semana, mes y usuario.</p>
                </div>
                <a href="{{ route('wastes.byUnit', ['unit' => $unit->id]) }}" class="px-4 py-2 rounded-lg border border-slate-200 text-slate-600 hover:bg-slate-50 transition text-sm">← Volver al listado</a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-sm">
                <h3 class="text-sm font-semibold text-slate-700 mb-2">Cantidad por día</h3>
                <div id="chartCantidadPorDia" class="w-full min-h-[280px] md:min-h-[320px] overflow-hidden"></div>
            </div>
            <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-sm">
                <h3 class="text-sm font-semibold text-slate-700 mb-2">Cantidad por tipo</h3>
                <div id="chartCantidadesPorTipo" class="w-full min-h-[280px] md:min-h-[320px] overflow-hidden"></div>
            </div>
            <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-sm">
                <h3 class="text-sm font-semibold text-slate-700 mb-2">Cantidad semanal</h3>
                <div id="chartSemanal" class="w-full min-h-[280px] md:min-h-[320px] overflow-hidden"></div>
            </div>
            <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-sm">
                <h3 class="text-sm font-semibold text-slate-700 mb-2">Acumulado mensual</h3>
                <div id="chartMensual" class="w-full min-h-[280px] md:min-h-[320px] overflow-hidden"></div>
            </div>
            <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-sm lg:col-span-2">
                <h3 class="text-sm font-semibold text-slate-700 mb-2">Distribución por usuario</h3>
                <div id="chartUsuarios" class="w-full min-h-[320px] md:min-h-[360px] overflow-hidden"></div>
            </div>
        </div>
    </div>

    @include('partials.footer-script-cdn')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        const color = '{{ $color }}';
        const chartInstances = [];

        function createCartesianOptions(options) {
            return {
                ...options,
                chart: {
                    width: '100%',
                    toolbar: { show: false },
                    ...(options.chart || {}),
                },
                xaxis: {
                    labels: {
                        rotate: -45,
                        style: { fontSize: '12px' },
                    },
                    ...(options.xaxis || {}),
                },
                dataLabels: {
                    enabled: false,
                    ...(options.dataLabels || {}),
                },
                grid: {
                    borderColor: '#f1f5f9',
                    ...(options.grid || {}),
                },
                responsive: [
                    {
                        breakpoint: 1024,
                        options: {
                            chart: { height: 300 },
                            xaxis: {
                                labels: {
                                    rotate: -35,
                                    style: { fontSize: '11px' },
                                },
                            },
                        },
                    },
                    {
                        breakpoint: 640,
                        options: {
                            chart: { height: 280 },
                            xaxis: {
                                labels: {
                                    rotate: -20,
                                    hideOverlappingLabels: true,
                                    style: { fontSize: '10px' },
                                },
                            },
                            legend: {
                                position: 'bottom',
                                fontSize: '11px',
                            },
                        },
                    },
                    ...(Array.isArray(options.responsive) ? options.responsive : []),
                ],
            };
        }

        function createDonutOptions(options) {
            return {
                ...options,
                chart: {
                    width: '100%',
                    ...(options.chart || {}),
                },
                legend: {
                    position: 'bottom',
                    ...(options.legend || {}),
                },
                responsive: [
                    {
                        breakpoint: 1024,
                        options: {
                            chart: { height: 340 },
                            legend: {
                                position: 'bottom',
                                fontSize: '12px',
                            },
                        },
                    },
                    {
                        breakpoint: 640,
                        options: {
                            chart: { height: 320 },
                            legend: {
                                position: 'bottom',
                                fontSize: '11px',
                            },
                            dataLabels: {
                                enabled: false,
                            },
                        },
                    },
                    ...(Array.isArray(options.responsive) ? options.responsive : []),
                ],
            };
        }

        function renderChart(selector, options) {
            const element = document.querySelector(selector);
            if (!element) {
                return;
            }

            const chart = new ApexCharts(element, options);
            chartInstances.push(chart);
            chart.render();
        }

        function debounce(callback, wait = 150) {
            let timeoutId;

            return (...args) => {
                window.clearTimeout(timeoutId);
                timeoutId = window.setTimeout(() => callback(...args), wait);
            };
        }

        renderChart('#chartCantidadPorDia', createCartesianOptions({
            chart: { type: 'line', height: 320 },
            stroke: { curve: 'smooth', width: 3 },
            colors: [color],
            series: [{ name: 'Cantidad', data: @json($byDay['series']) }],
            xaxis: { categories: @json($byDay['categories']) },
            tooltip: { shared: true, intersect: false },
        }));

        renderChart('#chartCantidadesPorTipo', createCartesianOptions({
            chart: { type: 'bar', height: 320 },
            plotOptions: { bar: { borderRadius: 6, columnWidth: '55%' } },
            colors: [color],
            series: [{ name: 'Cantidad', data: @json($byType['series']) }],
            xaxis: { categories: @json($byType['labels']) },
            responsive: [
                {
                    breakpoint: 640,
                    options: {
                        plotOptions: { bar: { columnWidth: '70%' } },
                    },
                },
            ],
        }));

        renderChart('#chartSemanal', createCartesianOptions({
            chart: { type: 'area', height: 320 },
            colors: [color],
            series: [{ name: 'Cantidad', data: @json($byWeek['series']) }],
            xaxis: { categories: @json($byWeek['categories']) },
            stroke: { curve: 'smooth' },
        }));

        renderChart('#chartMensual', createCartesianOptions({
            chart: { type: 'bar', height: 320, stacked: true },
            plotOptions: { bar: { borderRadius: 6, columnWidth: '55%' } },
            colors: [color],
            series: [{ name: 'Cantidad', data: @json($byMonth['series']) }],
            xaxis: { categories: @json($byMonth['categories']) },
            responsive: [
                {
                    breakpoint: 640,
                    options: {
                        plotOptions: { bar: { columnWidth: '70%' } },
                    },
                },
            ],
        }));

        renderChart('#chartUsuarios', createDonutOptions({
            chart: { type: 'donut', height: 360 },
            labels: @json($byUser['labels']),
            series: @json($byUser['series']),
            colors: ['#10b981', '#34d399', '#6ee7b7', '#a7f3d0', '#ecfeff'],
            dataLabels: { enabled: true },
        }));

        const handleResize = debounce(() => {
            chartInstances.forEach((chart) => chart.resize());
        }, 150);

        window.addEventListener('resize', handleResize);
        window.addEventListener('beforeunload', () => {
            window.removeEventListener('resize', handleResize);
        });
    </script>
</x-layouts.app>
