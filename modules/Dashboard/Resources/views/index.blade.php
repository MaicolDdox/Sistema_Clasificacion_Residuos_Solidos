<x-layouts.app :title="__('Dashboard')">
    <div class="max-w-7xl mx-auto space-y-6">
        <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
            <div class="flex flex-col gap-2 md:flex-row md:items-end md:justify-between">
                <div>
                    <p class="text-xs uppercase tracking-[0.2em] text-emerald-600 font-semibold">Panel principal</p>
                    <h1 class="text-2xl font-bold text-slate-900">Dashboard de residuos</h1>
                    <p class="text-sm text-slate-500">Resumen general de RESOL, RESPEL y estado de asignacion de roles.</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <article class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
                <p class="text-xs uppercase tracking-[0.2em] text-emerald-600 font-semibold">RESOL</p>
                <h2 class="mt-2 text-sm font-medium text-slate-500">Cantidad total</h2>
                <p class="mt-3 text-3xl font-bold text-slate-900">{{ number_format($totalResol) }} KG</p>
            </article>

            <article class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
                <p class="text-xs uppercase tracking-[0.2em] text-rose-600 font-semibold">RESPEL</p>
                <h2 class="mt-2 text-sm font-medium text-slate-500">Cantidad total</h2>
                <p class="mt-3 text-3xl font-bold text-slate-900">{{ number_format($totalRespel) }} KG</p>
            </article>

            <article class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
                <p class="text-xs uppercase tracking-[0.2em] text-amber-600 font-semibold">Usuarios</p>
                <h2 class="mt-2 text-sm font-medium text-slate-500">Sin rol asignado</h2>
                <p class="mt-3 text-3xl font-bold text-slate-900">{{ number_format($totalUsersWithoutRole) }}</p>
            </article>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 2xl:grid-cols-3 gap-6">
            <section class="bg-white border border-slate-200 rounded-2xl p-4 shadow-sm">
                <h3 class="text-sm font-semibold text-slate-700 mb-3">RESOL vs RESPEL</h3>
                <div id="chart-residue-share" class="h-[320px]"></div>
            </section>

            <section class="bg-white border border-slate-200 rounded-2xl p-4 shadow-sm">
                <h3 class="text-sm font-semibold text-slate-700 mb-3">RESOL por unidades</h3>
                <div id="chart-resol-by-unit" class="h-[320px]"></div>
            </section>

            <section class="bg-white border border-slate-200 rounded-2xl p-4 shadow-sm lg:col-span-2 2xl:col-span-1">
                <h3 class="text-sm font-semibold text-slate-700 mb-3">RESPEL por unidades</h3>
                <div id="chart-respel-by-unit" class="h-[320px]"></div>
            </section>
        </div>
    </div>

    <script>
        const pieSeries = @json($pieSeries);
        const unitLabels = @json($unitLabels);
        const resolByUnitSeries = @json($resolByUnitSeries);
        const respelByUnitSeries = @json($respelByUnitSeries);

        if (typeof ApexCharts !== 'undefined') {
            new ApexCharts(document.querySelector('#chart-residue-share'), {
                chart: { type: 'pie', height: 320, toolbar: { show: false } },
                labels: ['RESOL', 'RESPEL'],
                series: pieSeries,
                colors: ['#10b981', '#f43f5e'],
                legend: { position: 'bottom' },
                dataLabels: { enabled: true }
            }).render();

            new ApexCharts(document.querySelector('#chart-resol-by-unit'), {
                chart: { type: 'line', height: 320, toolbar: { show: false } },
                stroke: { curve: 'smooth', width: 3 },
                colors: ['#10b981'],
                series: [{ name: 'RESOL', data: resolByUnitSeries }],
                xaxis: { categories: unitLabels, labels: { rotate: -45 } },
                dataLabels: { enabled: false },
                grid: { borderColor: '#e2e8f0' }
            }).render();

            new ApexCharts(document.querySelector('#chart-respel-by-unit'), {
                chart: { type: 'line', height: 320, toolbar: { show: false } },
                stroke: { curve: 'smooth', width: 3 },
                colors: ['#f43f5e'],
                series: [{ name: 'RESPEL', data: respelByUnitSeries }],
                xaxis: { categories: unitLabels, labels: { rotate: -45 } },
                dataLabels: { enabled: false },
                grid: { borderColor: '#e2e8f0' }
            }).render();
        }
    </script>
</x-layouts.app>
