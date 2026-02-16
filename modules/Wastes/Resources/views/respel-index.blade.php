<x-layouts.app :title="__('Residuos peligrosos de la unidad '.$unit->name)">
    <div
        class="max-w-7xl mx-auto space-y-6"
        x-data="hazardousListingPage({
            exportPdfUrl: @js(route('hazardou-wastes.export.range.pdf', $unit)),
            exportExcelUrl: @js(route('hazardou-wastes.export.range.excel', $unit)),
            hasValidationErrors: @js($errors->any()),
            minEntryDate: @js($minEntryDate ?? null),
            maxEntryDate: @js($maxEntryDate ?? null),
            hasRecords: @js($hasRecords ?? false),
            availableYears: @js($availableYears ?? []),
            initialRangeType: @js(old('range_type', 'annual')),
            initialForm: {
                year: @js((string) old('year', now()->year)),
                semester: @js((string) old('semester', '1')),
                quarter: @js((string) old('quarter', '1')),
                month: @js((string) old('month', now()->month)),
                start_date: @js(old('start_date', '')),
                end_date: @js(old('end_date', '')),
            },
        })"
        x-init="init()"
    >
        <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <p class="text-xs uppercase tracking-[0.2em] text-rose-600 font-semibold">RESPEL</p>
                    <h1 class="text-2xl font-bold text-slate-900">Residuos peligrosos - {{ $unit->name }}</h1>
                    <p class="text-sm text-slate-500">Agrupados por semanas (lunes a domingo).</p>
                </div>

                <div class="flex items-center gap-2">
                    <div class="relative" @keydown.escape.window="headerMenuOpen = false">
                        <button
                            type="button"
                            class="inline-flex items-center justify-center w-11 h-11 rounded-xl border border-slate-200 bg-slate-100 text-slate-600 hover:bg-slate-200 transition"
                            title="Menú de acciones"
                            @click="toggleHeaderMenu()"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7h16M4 12h16M4 17h16" />
                            </svg>
                        </button>

                        <div
                            x-cloak
                            x-show="headerMenuOpen"
                            x-transition
                            @click.outside="headerMenuOpen = false"
                            class="absolute left-0 sm:left-auto sm:right-0 mt-2 w-64 max-w-[calc(100vw-1rem)] max-h-[70vh] overflow-y-auto origin-top-left sm:origin-top-right rounded-xl border border-slate-200 bg-white shadow-xl z-[70] py-1"
                        >
                            <a href="{{ route('wastes.report.respel', $unit) }}" class="flex items-center gap-2 px-3 py-2 text-sm text-slate-700 hover:bg-slate-50 transition">
                                <svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M11 3a1 1 0 011 1v14a1 1 0 11-2 0V4a1 1 0 011-1zm5 4a1 1 0 011 1v10a1 1 0 11-2 0V8a1 1 0 011-1zm-10 6a1 1 0 011 1v4a1 1 0 11-2 0v-4a1 1 0 011-1z"/>
                                </svg>
                                Reporte gráfico
                            </a>
                            <a href="{{ route('hazardou-wastes.create', ['unit' => $unit->id]) }}" class="flex items-center gap-2 px-3 py-2 text-sm text-slate-700 hover:bg-slate-50 transition">
                                <svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v12m6-6H6"/>
                                </svg>
                                Nuevo RESPEL
                            </a>

                            @can('wastes.report.respel')
                                <div class="my-1 border-t border-slate-100"></div>
                                <button type="button" class="w-full flex items-center gap-2 px-3 py-2 text-sm text-slate-700 hover:bg-slate-50 transition" @click="openExportModal('pdf')">
                                    <svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h10v10H7z"/>
                                    </svg>
                                    Exportar en PDF
                                </button>
                                <button type="button" class="w-full flex items-center gap-2 px-3 py-2 text-sm text-slate-700 hover:bg-slate-50 transition" @click="openExportModal('excel')">
                                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4h16v16H4zM8 8l8 8M16 8l-8 8"/>
                                    </svg>
                                    Exportar en Excel
                                </button>
                            @endcan
                        </div>
                    </div>

                    <a href="{{ route('wastes.units.byArea', ['area' => $unit->area_id]) }}" class="px-4 py-2 rounded-lg border border-slate-200 text-slate-600 hover:bg-slate-50 transition text-sm">
                        Volver a unidades
                    </a>
                </div>
            </div>
            @include('partials.session-message')
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-4">
            <div class="md:hidden mb-4">
                <div class="relative">
                    <input
                        id="respelMobileSearch"
                        type="search"
                        placeholder="Buscar en registros RESPEL..."
                        class="w-full pl-10 pr-4 py-2.5 rounded-lg border border-slate-200 bg-white text-sm text-slate-700 focus:ring-2 focus:ring-rose-200 focus:border-rose-400 shadow-sm"
                    >
                    <svg class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M11 18a7 7 0 100-14 7 7 0 000 14z" />
                    </svg>
                </div>
            </div>

            <div class="w-full max-w-full overflow-x-auto border border-slate-100 rounded-xl hidden md:block">
                <table id="respelTable" class="w-full min-w-[640px] table-auto text-sm text-left">
                    <thead class="bg-slate-50 text-slate-600 uppercase text-xs tracking-wide">
                        <tr>
                            <th class="px-4 py-3 font-semibold whitespace-nowrap">Fecha entrada</th>
                            <th class="px-4 py-3 font-semibold whitespace-nowrap">Tipo</th>
                            <th class="px-4 py-3 font-semibold whitespace-nowrap">Cantidad</th>
                            <th class="px-4 py-3 font-semibold">Observaciones</th>
                            <th class="px-4 py-3 font-semibold whitespace-nowrap">Usuario</th>
                            <th class="px-4 py-3 font-semibold text-center whitespace-nowrap">Acciones</th>
                        </tr>
                    </thead>
                </table>
            </div>

            <div id="respelMobileCards" class="space-y-3 md:hidden"></div>
            <div id="respelMobilePagination" class="mt-4 md:hidden"></div>
        </div>

        @can('wastes.report.respel')
            <div
                x-cloak
                x-show="showExportModal"
                x-transition.opacity
                class="fixed inset-0 z-[70] bg-slate-900/60 flex items-center justify-center px-4"
            >
                <div
                    class="bg-white rounded-2xl shadow-2xl w-full max-w-lg border border-slate-200"
                    x-show="showExportModal"
                    x-transition.scale.origin-center
                    @click.outside="closeExportModal()"
                >
                    <div class="p-6 space-y-4">
                        <div class="flex items-start justify-between">
                            <div>
                                <h3 class="text-xl font-bold text-slate-900">Exportar registros</h3>
                                <p class="text-sm text-slate-500">Selecciona el rango de exportación para la unidad {{ $unit->name }}.</p>
                            </div>
                            <button type="button" class="text-slate-400 hover:text-slate-600" @click="closeExportModal()">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        @if($errors->any())
                            <div class="rounded-lg border border-red-200 bg-red-50 px-3 py-2 text-sm text-red-700">
                                <ul class="list-disc pl-5">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="space-y-2">
                            <label class="text-sm font-medium text-slate-700">Tipo de rango</label>
                            <select x-model="rangeType" @change="handleRangeTypeChange()" class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-rose-200 focus:border-rose-400">
                                <option value="annual">Anual</option>
                                <option value="semiannual">Semestral</option>
                                <option value="quarterly">Trimestral</option>
                                <option value="monthly">Mensual</option>
                                <option value="weekly">Semanal</option>
                                <option value="custom">Personalizado</option>
                            </select>
                        </div>

                        <div x-show="requiresYear()" class="space-y-2">
                            <label class="text-sm font-medium text-slate-700">Año</label>
                            <select
                                x-model="form.year"
                                :disabled="!hasRecords || availableYears.length === 0"
                                class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-rose-200 focus:border-rose-400 disabled:bg-slate-100 disabled:text-slate-500"
                            >
                                <option value="">Selecciona un año</option>
                                <template x-for="year in availableYears" :key="year">
                                    <option :value="year.toString()" x-text="year"></option>
                                </template>
                            </select>
                            <p x-show="!hasRecords" class="text-xs text-amber-600">
                                No hay registros para exportar.
                            </p>
                            <p x-show="hasRecords && availableYears.length === 0" class="text-xs text-amber-600">
                                No hay años con registros disponibles.
                            </p>
                        </div>

                        <div x-show="rangeType === 'semiannual'" class="space-y-2">
                            <label class="text-sm font-medium text-slate-700">Semestre</label>
                            <select x-model="form.semester" class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-rose-200 focus:border-rose-400">
                                <option value="1">Semestre 1 (enero - junio)</option>
                                <option value="2">Semestre 2 (julio - diciembre)</option>
                            </select>
                        </div>

                        <div x-show="rangeType === 'quarterly'" class="space-y-2">
                            <label class="text-sm font-medium text-slate-700">Trimestre</label>
                            <select x-model="form.quarter" class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-rose-200 focus:border-rose-400">
                                <option value="1">Trimestre 1</option>
                                <option value="2">Trimestre 2</option>
                                <option value="3">Trimestre 3</option>
                                <option value="4">Trimestre 4</option>
                            </select>
                        </div>

                        <div x-show="rangeType === 'monthly'" class="space-y-2">
                            <label class="text-sm font-medium text-slate-700">Mes</label>
                            <select x-model="form.month" class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-rose-200 focus:border-rose-400">
                                <option value="1">Enero</option>
                                <option value="2">Febrero</option>
                                <option value="3">Marzo</option>
                                <option value="4">Abril</option>
                                <option value="5">Mayo</option>
                                <option value="6">Junio</option>
                                <option value="7">Julio</option>
                                <option value="8">Agosto</option>
                                <option value="9">Septiembre</option>
                                <option value="10">Octubre</option>
                                <option value="11">Noviembre</option>
                                <option value="12">Diciembre</option>
                            </select>
                        </div>

                        <div x-show="rangeType === 'weekly'" class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            <div class="space-y-2">
                                <label class="text-sm font-medium text-slate-700">Inicio (lunes)</label>
                                <input type="date" x-model="form.start_date" :max="todayDate" class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-rose-200 focus:border-rose-400">
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-medium text-slate-700">Fin (domingo)</label>
                                <input type="date" x-model="form.end_date" :max="todayDate" class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-rose-200 focus:border-rose-400">
                            </div>
                        </div>

                        <div x-show="rangeType === 'custom'" class="space-y-3">
                            <p class="text-xs text-slate-500" x-text="customRangeDescription()"></p>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                <div class="space-y-2">
                                    <label class="text-sm font-medium text-slate-700">Fecha inicio</label>
                                    <input
                                        type="date"
                                        x-model="form.start_date"
                                        :min="minSelectableDate"
                                        :max="todayDate"
                                        class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-rose-200 focus:border-rose-400"
                                    >
                                </div>
                                <div class="space-y-2">
                                    <label class="text-sm font-medium text-slate-700">Fecha fin</label>
                                    <input
                                        type="date"
                                        x-model="form.end_date"
                                        :min="minSelectableDate"
                                        :max="todayDate"
                                        class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-rose-200 focus:border-rose-400"
                                    >
                                </div>
                            </div>
                        </div>

                        <div x-show="modalError" class="rounded-lg border border-red-200 bg-red-50 px-3 py-2 text-sm text-red-700" x-text="modalError"></div>

                        <div class="flex items-center justify-end gap-3 pt-3">
                            <button type="button" class="px-4 py-2 rounded-lg border border-slate-200 text-slate-700 hover:bg-slate-50 transition" @click="closeExportModal()">
                                Cancelar
                            </button>
                            <button
                                type="button"
                                class="px-4 py-2 rounded-lg bg-rose-500 text-white hover:bg-rose-400 transition disabled:opacity-60 disabled:cursor-not-allowed"
                                :disabled="isSubmitting || !canSubmitExport()"
                                @click="submitExport()"
                            >
                                <span x-text="exportFormat === 'pdf' ? 'Exportar PDF' : 'Exportar Excel'"></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endcan

        <div
            x-cloak
            x-show="rowMenu.open"
            x-transition.opacity
            class="fixed inset-0 z-[80]"
            @click="closeRowMenu()"
        >
            <div class="absolute inset-0"></div>
            <div
                x-ref="rowActionsPanel"
                data-row-actions-panel
                class="fixed z-[85] w-[calc(100vw-1.5rem)] max-w-56 sm:w-56 rounded-xl border border-slate-200 bg-white shadow-xl py-1 text-left"
                :style="`left:${rowMenu.left}px;top:${rowMenu.top}px;`"
                @click.stop
            >
                <a :href="rowMenu.links.show" class="flex items-center gap-2 px-3 py-2 text-sm text-slate-700 hover:bg-slate-50 transition" @click="closeRowMenu()">
                    <svg class="w-4 h-4 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    Ver detalles
                </a>

                <template x-if="rowMenu.links.edit">
                    <a :href="rowMenu.links.edit" class="flex items-center gap-2 px-3 py-2 text-sm text-slate-700 hover:bg-slate-50 transition" @click="closeRowMenu()">
                        <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Editar
                    </a>
                </template>

                <template x-if="rowMenu.links.delete">
                    <button
                        type="button"
                        class="w-full flex items-center gap-2 px-3 py-2 text-sm text-red-700 hover:bg-red-50 transition"
                        @click="openDeleteFromRowMenu()"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Eliminar
                    </button>
                </template>

                <template x-if="rowMenu.links.pdf || rowMenu.links.excel">
                    <div class="my-1 border-t border-slate-100"></div>
                </template>
                <template x-if="rowMenu.links.pdf">
                    <a :href="rowMenu.links.pdf" class="flex items-center gap-2 px-3 py-2 text-sm text-slate-700 hover:bg-slate-50 transition" @click="closeRowMenu()">
                        <svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h10v10H7z" />
                        </svg>
                        Exportar PDF
                    </a>
                </template>
                <template x-if="rowMenu.links.excel">
                    <a :href="rowMenu.links.excel" class="flex items-center gap-2 px-3 py-2 text-sm text-slate-700 hover:bg-slate-50 transition" @click="closeRowMenu()">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4h16v16H4zM8 8l8 8M16 8l-8 8" />
                        </svg>
                        Exportar Excel
                    </a>
                </template>
            </div>
        </div>

        <div
            x-cloak
            x-show="showDeleteModal"
            x-transition.opacity
            class="fixed inset-0 z-[75] bg-slate-900/60 flex items-center justify-center px-4"
        >
            <div
                class="bg-white rounded-2xl shadow-2xl w-full max-w-md border border-slate-200"
                x-show="showDeleteModal"
                x-transition.scale.origin-center
            >
                <div class="p-6 space-y-4">
                    <div>
                        <h3 class="text-lg font-bold text-slate-900">Confirmar eliminación</h3>
                        <p class="text-sm text-slate-500 mt-1">Esta acción eliminará el registro seleccionado de RESPEL.</p>
                    </div>
                    <div class="flex items-center justify-end gap-3">
                        <button type="button" class="px-4 py-2 rounded-lg border border-slate-200 text-slate-700 hover:bg-slate-50 transition" @click="closeDeleteModal()">
                            Cancelar
                        </button>
                        <form method="POST" :action="deleteAction">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-4 py-2 rounded-lg bg-red-600 text-white hover:bg-red-500 transition">
                                Eliminar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('partials.footer-script-cdn')
    <link rel="stylesheet" href="https://cdn.datatables.net/rowgroup/1.5.0/css/rowGroup.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.2/css/responsive.dataTables.min.css">
    <script src="https://cdn.datatables.net/rowgroup/1.5.0/js/dataTables.rowGroup.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.2/js/dataTables.responsive.min.js"></script>
    <script>
        function hazardousListingPage(config) {
            return {
                exportPdfUrl: config.exportPdfUrl,
                exportExcelUrl: config.exportExcelUrl,
                hasValidationErrors: config.hasValidationErrors,
                hasRecords: Boolean(config.hasRecords),
                availableYears: Array.isArray(config.availableYears)
                    ? config.availableYears
                        .map((year) => Number(year))
                        .filter((year) => Number.isInteger(year))
                        .sort((firstYear, secondYear) => secondYear - firstYear)
                    : [],
                minEntryDate: config.minEntryDate || null,
                maxEntryDate: config.maxEntryDate || null,
                todayDate: '',
                minSelectableDate: '',
                headerMenuOpen: false,
                showExportModal: false,
                exportFormat: 'pdf',
                rangeType: config.initialRangeType || 'annual',
                modalError: '',
                isSubmitting: false,
                rowMenu: {
                    open: false,
                    left: 0,
                    top: 0,
                    triggerId: null,
                    links: {
                        show: '',
                        edit: '',
                        delete: '',
                        pdf: '',
                        excel: '',
                    },
                },
                showDeleteModal: false,
                deleteAction: '',
                listenersBound: false,
                listeners: {
                    onDocumentClick: null,
                    onDocumentKeydown: null,
                    onDatatableDrawn: null,
                    onWindowResize: null,
                    onWindowScroll: null,
                },
                form: {
                    year: config.initialForm.year || new Date().getFullYear().toString(),
                    semester: config.initialForm.semester || '1',
                    quarter: config.initialForm.quarter || '1',
                    month: config.initialForm.month || (new Date().getMonth() + 1).toString(),
                    start_date: config.initialForm.start_date || '',
                    end_date: config.initialForm.end_date || '',
                },
                init() {
                    this.todayDate = this.formatDate(new Date());
                    this.minSelectableDate = this.minEntryDate || this.todayDate;
                    this.initializeWeekDefaults();
                    this.initializeAnnualDefaults();
                    this.initializeCustomDefaults();

                    if (this.hasValidationErrors) {
                        this.showExportModal = true;
                    }

                    this.bindEventListeners();
                },
                destroy() {
                    this.unbindEventListeners();
                },
                bindEventListeners() {
                    if (this.listenersBound) {
                        return;
                    }

                    this.listeners.onDocumentClick = (event) => this.handleDocumentClick(event);
                    this.listeners.onDocumentKeydown = (event) => {
                        if (event.key === 'Escape') {
                            this.closeRowMenu();
                        }
                    };
                    this.listeners.onDatatableDrawn = () => this.closeRowMenu();
                    this.listeners.onWindowResize = () => this.closeRowMenu();
                    this.listeners.onWindowScroll = () => this.closeRowMenu();

                    document.addEventListener('click', this.listeners.onDocumentClick);
                    document.addEventListener('keydown', this.listeners.onDocumentKeydown);
                    document.addEventListener('datatable:drawn', this.listeners.onDatatableDrawn);
                    window.addEventListener('resize', this.listeners.onWindowResize);
                    window.addEventListener('scroll', this.listeners.onWindowScroll, true);

                    this.listenersBound = true;
                },
                unbindEventListeners() {
                    if (!this.listenersBound) {
                        return;
                    }

                    document.removeEventListener('click', this.listeners.onDocumentClick);
                    document.removeEventListener('keydown', this.listeners.onDocumentKeydown);
                    document.removeEventListener('datatable:drawn', this.listeners.onDatatableDrawn);
                    window.removeEventListener('resize', this.listeners.onWindowResize);
                    window.removeEventListener('scroll', this.listeners.onWindowScroll, true);

                    this.listenersBound = false;
                },
                toggleHeaderMenu() {
                    this.headerMenuOpen = !this.headerMenuOpen;
                    if (this.headerMenuOpen) {
                        this.closeRowMenu();
                    }
                },
                openExportModal(format) {
                    this.exportFormat = format;
                    this.headerMenuOpen = false;
                    this.closeRowMenu();
                    this.modalError = '';
                    this.showExportModal = true;
                },
                closeExportModal() {
                    this.showExportModal = false;
                    this.modalError = '';
                },
                openDeleteModal(action) {
                    this.deleteAction = action;
                    this.showDeleteModal = true;
                },
                closeDeleteModal() {
                    this.showDeleteModal = false;
                    this.deleteAction = '';
                },
                requiresYear() {
                    return ['annual', 'semiannual', 'quarterly', 'monthly'].includes(this.rangeType);
                },
                canSubmitExport() {
                    if (!this.hasRecords) {
                        return false;
                    }

                    if (this.requiresYear()) {
                        if (!this.form.year) {
                            return false;
                        }

                        const selectedYear = Number(this.form.year);
                        if (!Number.isInteger(selectedYear) || !this.availableYears.includes(selectedYear)) {
                            return false;
                        }
                    }

                    if (this.rangeType === 'semiannual' && !this.form.semester) {
                        return false;
                    }

                    if (this.rangeType === 'quarterly' && !this.form.quarter) {
                        return false;
                    }

                    if (this.rangeType === 'monthly' && !this.form.month) {
                        return false;
                    }

                    if (this.rangeType === 'weekly' || this.rangeType === 'custom') {
                        if (!this.form.start_date || !this.form.end_date) {
                            return false;
                        }

                        if (this.form.start_date > this.form.end_date) {
                            return false;
                        }

                        if (this.form.end_date > this.todayDate || this.form.start_date > this.todayDate) {
                            return false;
                        }
                    }

                    return true;
                },
                customRangeDescription() {
                    if (!this.hasRecords || !this.minEntryDate) {
                        return 'No hay registros para exportar.';
                    }

                    return `Disponible desde ${this.minEntryDate} hasta ${this.todayDate}.`;
                },
                buildExportUrl() {
                    const baseUrl = this.exportFormat === 'pdf' ? this.exportPdfUrl : this.exportExcelUrl;
                    const url = new URL(baseUrl, window.location.origin);

                    url.searchParams.set('range_type', this.rangeType);

                    if (this.requiresYear()) {
                        url.searchParams.set('year', this.form.year);
                    }

                    if (this.rangeType === 'semiannual') {
                        url.searchParams.set('semester', this.form.semester);
                    }

                    if (this.rangeType === 'quarterly') {
                        url.searchParams.set('quarter', this.form.quarter);
                    }

                    if (this.rangeType === 'monthly') {
                        url.searchParams.set('month', this.form.month);
                    }

                    if (this.rangeType === 'weekly' || this.rangeType === 'custom') {
                        url.searchParams.set('start_date', this.form.start_date);
                        url.searchParams.set('end_date', this.form.end_date);
                    }

                    return url;
                },
                async submitExport() {
                    this.applyCustomDateBounds();

                    if (!this.canSubmitExport() || this.isSubmitting) {
                        return;
                    }

                    this.modalError = '';
                    this.isSubmitting = true;

                    const url = this.buildExportUrl();

                    try {
                        const response = await fetch(url.toString(), {
                            method: 'GET',
                            credentials: 'same-origin',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                Accept: 'application/json, application/octet-stream',
                            },
                        });

                        const contentType = response.headers.get('content-type') || '';

                        if (!response.ok) {
                            if (contentType.includes('application/json')) {
                                const payload = await response.json();
                                this.modalError = this.getFirstValidationError(payload.errors)
                                    || payload.message
                                    || 'No se pudo exportar los registros.';
                            } else {
                                this.modalError = 'No se pudo exportar los registros.';
                            }

                            return;
                        }

                        const blob = await response.blob();
                        const disposition = response.headers.get('content-disposition') || '';
                        const fileName = this.extractFileName(disposition, this.defaultFileName());
                        const blobUrl = window.URL.createObjectURL(blob);
                        const anchor = document.createElement('a');

                        anchor.href = blobUrl;
                        anchor.download = fileName;
                        document.body.appendChild(anchor);
                        anchor.click();
                        anchor.remove();
                        window.URL.revokeObjectURL(blobUrl);

                        this.closeExportModal();
                    } catch (error) {
                        this.modalError = 'No se pudo exportar los registros.';
                    } finally {
                        this.isSubmitting = false;
                    }
                },
                getFirstValidationError(errors) {
                    if (!errors || typeof errors !== 'object') {
                        return null;
                    }

                    const orderedFields = ['year', 'range_type', 'semester', 'quarter', 'month', 'start_date', 'end_date'];

                    for (const field of orderedFields) {
                        if (Array.isArray(errors[field]) && errors[field].length > 0) {
                            return errors[field][0];
                        }
                    }

                    const firstField = Object.keys(errors)[0];
                    if (firstField && Array.isArray(errors[firstField]) && errors[firstField].length > 0) {
                        return errors[firstField][0];
                    }

                    return null;
                },
                defaultFileName() {
                    const extension = this.exportFormat === 'pdf' ? 'pdf' : 'xlsx';
                    return `respel_export.${extension}`;
                },
                extractFileName(disposition, fallback) {
                    if (!disposition) {
                        return fallback;
                    }

                    const utfMatch = disposition.match(/filename\*=UTF-8''([^;]+)/i);
                    if (utfMatch && utfMatch[1]) {
                        return decodeURIComponent(utfMatch[1]);
                    }

                    const asciiMatch = disposition.match(/filename=\"?([^\";]+)\"?/i);
                    if (asciiMatch && asciiMatch[1]) {
                        return asciiMatch[1];
                    }

                    return fallback;
                },
                handleDocumentClick(event) {
                    if (!this.$root || !document.body.contains(this.$root)) {
                        this.unbindEventListeners();
                        return;
                    }

                    const toggleButton = event.target.closest('[data-row-actions-trigger]');
                    if (toggleButton) {
                        if (!this.$root.contains(toggleButton)) {
                            return;
                        }

                        event.preventDefault();
                        event.stopPropagation();
                        this.toggleRowMenu(toggleButton);
                        return;
                    }

                    if (this.rowMenu.open && !event.target.closest('[data-row-actions-panel]')) {
                        this.closeRowMenu();
                        return;
                    }
                },
                toggleRowMenu(triggerButton) {
                    const triggerId = triggerButton.getAttribute('data-menu-id');

                    if (this.rowMenu.open && this.rowMenu.triggerId === triggerId) {
                        this.closeRowMenu();
                        return;
                    }

                    this.rowMenu.triggerId = triggerId;
                    this.rowMenu.links = {
                        show: triggerButton.getAttribute('data-show-url') || '',
                        edit: triggerButton.getAttribute('data-edit-url') || '',
                        delete: triggerButton.getAttribute('data-delete-url') || '',
                        pdf: triggerButton.getAttribute('data-export-pdf-url') || '',
                        excel: triggerButton.getAttribute('data-export-excel-url') || '',
                    };
                    this.rowMenu.open = true;

                    this.$nextTick(() => {
                        this.positionRowMenu(triggerButton);
                    });
                },
                positionRowMenu(triggerButton) {
                    const panel = this.$refs.rowActionsPanel;
                    if (!panel) {
                        return;
                    }

                    const triggerRect = triggerButton.getBoundingClientRect();
                    const panelRect = panel.getBoundingClientRect();
                    const margin = 8;
                    const viewportPadding = 12;

                    let left = triggerRect.right - panelRect.width;
                    let top = triggerRect.bottom + margin;

                    if (left < viewportPadding) {
                        left = viewportPadding;
                    }

                    if ((left + panelRect.width) > (window.innerWidth - viewportPadding)) {
                        left = Math.max(viewportPadding, window.innerWidth - panelRect.width - viewportPadding);
                    }

                    if ((top + panelRect.height) > (window.innerHeight - viewportPadding)) {
                        top = Math.max(viewportPadding, triggerRect.top - panelRect.height - margin);
                    }

                    this.rowMenu.left = Math.round(left);
                    this.rowMenu.top = Math.round(top);
                },
                closeRowMenu() {
                    this.rowMenu.open = false;
                    this.rowMenu.triggerId = null;
                },
                openDeleteFromRowMenu() {
                    const deleteUrl = this.rowMenu.links.delete;
                    this.closeRowMenu();

                    if (deleteUrl) {
                        this.openDeleteModal(deleteUrl);
                    }
                },
                initializeWeekDefaults() {
                    if (this.form.start_date && this.form.end_date) {
                        return;
                    }

                    const today = new Date();
                    const dayOfWeek = today.getDay();
                    const diffToMonday = dayOfWeek === 0 ? -6 : 1 - dayOfWeek;

                    const monday = new Date(today);
                    monday.setDate(today.getDate() + diffToMonday);

                    const sunday = new Date(monday);
                    sunday.setDate(monday.getDate() + 6);

                    this.form.start_date = this.formatDate(monday);
                    this.form.end_date = this.formatDate(sunday);
                },
                initializeCustomDefaults() {
                    if (this.rangeType !== 'custom') {
                        return;
                    }

                    if (!this.form.start_date && this.minSelectableDate) {
                        this.form.start_date = this.minSelectableDate;
                    }

                    if (!this.form.end_date) {
                        this.form.end_date = this.todayDate;
                    }

                    this.applyCustomDateBounds();
                },
                initializeAnnualDefaults() {
                    if (this.availableYears.length === 0) {
                        this.form.year = '';
                        return;
                    }

                    const selectedYear = Number(this.form.year);
                    if (!Number.isInteger(selectedYear) || !this.availableYears.includes(selectedYear)) {
                        this.form.year = this.availableYears[0].toString();
                    }
                },
                handleRangeTypeChange() {
                    this.modalError = '';

                    if (this.rangeType === 'custom') {
                        this.initializeCustomDefaults();
                    }

                    if (this.requiresYear()) {
                        this.initializeAnnualDefaults();
                    }
                },
                applyCustomDateBounds() {
                    if (this.rangeType !== 'custom' || !this.minSelectableDate) {
                        return;
                    }

                    if (!this.form.start_date || this.form.start_date < this.minSelectableDate) {
                        this.form.start_date = this.minSelectableDate;
                    }

                    if (!this.form.end_date || this.form.end_date > this.todayDate) {
                        this.form.end_date = this.todayDate;
                    }

                    if (this.form.start_date > this.form.end_date) {
                        this.form.end_date = this.form.start_date;
                    }
                },
                formatDate(date) {
                    const year = date.getFullYear();
                    const month = String(date.getMonth() + 1).padStart(2, '0');
                    const day = String(date.getDate()).padStart(2, '0');

                    return `${year}-${month}-${day}`;
                },
            };
        }

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
                const container = $('#respelMobilePagination');

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
                const container = $('#respelMobileCards');
                const totalRows = mobileState.filteredRows.length;

                if (!totalRows) {
                    container.html('<div class="text-center text-slate-400 py-8 text-sm">No hay registros RESPEL para mostrar.</div>');
                    $('#respelMobilePagination').empty();
                    document.dispatchEvent(new CustomEvent('datatable:drawn'));
                    return;
                }

                const totalPages = Math.ceil(totalRows / mobileState.pageSize);
                mobileState.currentPage = Math.min(Math.max(mobileState.currentPage, 1), totalPages);

                const start = (mobileState.currentPage - 1) * mobileState.pageSize;
                const pageRows = mobileState.filteredRows.slice(start, start + mobileState.pageSize);

                container.empty();

                let activeGroup = null;
                pageRows.forEach(function(row) {
                    const groupLabel = stripHtml(row.grupo_semana) || 'Semana sin fecha';
                    if (groupLabel !== activeGroup) {
                        activeGroup = groupLabel;
                        container.append(`
                            <div class="px-3 py-2 rounded-lg bg-rose-50 border border-rose-100 text-rose-700 text-xs font-semibold uppercase tracking-wide">
                                ${groupLabel}
                            </div>
                        `);
                    }

                    const observations = stripHtml(row.observations) || 'Sin observaciones';
                    const card = `
                        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4 space-y-3">
                            <div class="flex items-center justify-between gap-2">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-rose-100 text-rose-700">
                                    ${stripHtml(row.waste_type) || 'N/D'}
                                </span>
                                <span class="text-xs text-slate-500">${stripHtml(row.entry_date)}</span>
                            </div>
                            <div class="space-y-2 text-xs text-slate-500">
                                <p><span class="font-medium text-slate-700">Cantidad:</span> ${stripHtml(row.amount)}</p>
                                <p><span class="font-medium text-slate-700">Usuario:</span> ${stripHtml(row.usuario)}</p>
                                <p><span class="font-medium text-slate-700">Observaciones:</span> ${observations}</p>
                            </div>
                            <div class="pt-2 border-t border-slate-100">
                                ${row.acciones ?? ''}
                            </div>
                        </div>
                    `;
                    container.append(card);
                });

                renderMobilePagination();
                document.dispatchEvent(new CustomEvent('datatable:drawn'));
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
                        return normalize(row.entry_date).includes(term)
                            || normalize(row.waste_type).includes(term)
                            || normalize(row.amount).includes(term)
                            || normalize(row.observations).includes(term)
                            || normalize(row.usuario).includes(term)
                            || normalize(row.grupo_semana).includes(term);
                    });
                }
                mobileState.currentPage = 1;
                renderMobileCards();
            }

            $('#respelMobilePagination').on('click', 'button[data-page]', function() {
                const requestedPage = Number($(this).attr('data-page'));
                if (!Number.isInteger(requestedPage)) {
                    return;
                }

                const maxPage = Math.max(1, Math.ceil(mobileState.filteredRows.length / mobileState.pageSize));
                mobileState.currentPage = Math.min(Math.max(requestedPage, 1), maxPage);
                renderMobileCards();
            });

            $('#respelMobileSearch').on('keyup', function() {
                filterMobileRows(this.value);
            });

            $('#respelTable').DataTable({
                processing: true,
                serverSide: false,
                ajax: {
                    url: '{{ route("hazardou-wastes.byUnit", $unit) }}',
                    dataSrc: function(json) {
                        const rows = Array.isArray(json.data) ? json.data : [];
                        setMobileRows(rows);
                        return rows;
                    }
                },
                dom: 'lfrtip',
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
                columnDefs: [
                    { targets: 0, responsivePriority: 1, className: 'wastes-nowrap-cell' },
                    { targets: 1, responsivePriority: 2, className: 'wastes-nowrap-cell' },
                    { targets: 2, responsivePriority: 1, className: 'wastes-nowrap-cell' },
                    { targets: 3, responsivePriority: 5, className: 'wastes-observations-cell' },
                    { targets: 4, responsivePriority: 4, className: 'wastes-nowrap-cell' },
                    { targets: 5, responsivePriority: 1, className: 'wastes-actions-cell' },
                ],
                drawCallback: function () {
                    document.dispatchEvent(new CustomEvent('datatable:drawn'));
                },
                language: { url: '/i18n/es-ES.json' },
                pageLength: 10,
                autoWidth: false,
                responsive: {
                    details: {
                        type: 'inline',
                        target: 'tr',
                    },
                },
            });
        });
    </script>
</x-layouts.app>
