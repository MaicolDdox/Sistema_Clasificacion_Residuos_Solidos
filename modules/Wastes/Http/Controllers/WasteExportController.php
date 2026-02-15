<?php

namespace Modules\Wastes\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Modules\ProductiveUnits\Models\ProductiveUnit;
use Modules\Wastes\Exports\WasteRowsExport;
use Modules\Wastes\Http\Requests\ExportResolRequest;
use Modules\Wastes\Models\Waste;
use Modules\Wastes\Services\WasteExportQueryService;
use Modules\Wastes\Services\WasteExportRangeService;
use Spatie\Browsershot\Browsershot;
use Spatie\LaravelPdf\Facades\Pdf;
use Spatie\LaravelPdf\PdfBuilder;
use RuntimeException;
use Throwable;

class WasteExportController extends Controller
{
    public function __construct(
        private readonly WasteExportRangeService $rangeService,
        private readonly WasteExportQueryService $queryService
    ) {}

    public function rangePdf(ExportResolRequest $request, ProductiveUnit $unit)
    {
        try {
            $range = $this->rangeService->resolve($request->validated());
            $rows = $this->queryService
                ->resolRangeQuery($unit, $range['start_date'], $range['end_date'])
                ->get();

            $fileName = $this->buildFileName(
                module: 'resol',
                unitName: $unit->name,
                suffix: $range['range_slug'],
                extension: 'pdf'
            );

            $pdfBuilder = Pdf::view('wastes::exports.waste-export-pdf', [
                'title' => 'Exportación RESOL',
                'moduleLabel' => 'RESOL',
                'unitName' => $unit->name,
                'rangeLabel' => $range['range_label'],
                'rows' => $rows,
                'generatedAt' => now(),
            ])->withBrowsershot(function (Browsershot $browsershot): void {
                $this->configureBrowsershot($browsershot);
            })
                ->format('a4');

            $pdfBuilder->landscape();

            return $this->downloadPdfResponse($pdfBuilder, $fileName);
        } catch (Throwable $exception) {
            return $this->handleExportFailure(
                $request,
                'No se pudo generar el PDF. Verifica la configuración de Node/Puppeteer.',
                $exception
            );
        }
    }

    public function rangeExcel(ExportResolRequest $request, ProductiveUnit $unit)
    {
        try {
            $range = $this->rangeService->resolve($request->validated());
            $query = $this->queryService
                ->resolRangeQuery($unit, $range['start_date'], $range['end_date']);

            $fileName = $this->buildFileName(
                module: 'resol',
                unitName: $unit->name,
                suffix: $range['range_slug'],
                extension: 'xlsx'
            );

            return Excel::download(new WasteRowsExport($query), $fileName);
        } catch (Throwable $exception) {
            return $this->handleExportFailure(
                $request,
                'No se pudo generar el archivo Excel.',
                $exception
            );
        }
    }

    public function singlePdf(Request $request, Waste $waste)
    {
        try {
            $waste->loadMissing('productiveUnit');

            $rows = $this->queryService
                ->resolSingleQuery($waste->id)
                ->get();

            $fileName = $this->buildFileName(
                module: 'resol',
                unitName: $waste->productiveUnit->name ?? 'sin-unidad',
                suffix: "registro_{$waste->id}",
                extension: 'pdf'
            );

            $pdfBuilder = Pdf::view('wastes::exports.waste-export-pdf', [
                'title' => 'Exportación RESOL',
                'moduleLabel' => 'RESOL',
                'unitName' => $waste->productiveUnit->name ?? 'Sin unidad',
                'rangeLabel' => "Registro individual #{$waste->id}",
                'rows' => $rows,
                'generatedAt' => now(),
            ])->withBrowsershot(function (Browsershot $browsershot): void {
                $this->configureBrowsershot($browsershot);
            })
                ->format('a4');

            $pdfBuilder->landscape();

            return $this->downloadPdfResponse($pdfBuilder, $fileName);
        } catch (Throwable $exception) {
            return $this->handleExportFailure(
                $request,
                'No se pudo generar el PDF del registro.',
                $exception
            );
        }
    }

    public function singleExcel(Request $request, Waste $waste)
    {
        try {
            $waste->loadMissing('productiveUnit');

            $query = $this->queryService
                ->resolSingleQuery($waste->id);

            $fileName = $this->buildFileName(
                module: 'resol',
                unitName: $waste->productiveUnit->name ?? 'sin-unidad',
                suffix: "registro_{$waste->id}",
                extension: 'xlsx'
            );

            return Excel::download(new WasteRowsExport($query), $fileName);
        } catch (Throwable $exception) {
            return $this->handleExportFailure(
                $request,
                'No se pudo generar el Excel del registro.',
                $exception
            );
        }
    }

    private function buildFileName(string $module, string $unitName, string $suffix, string $extension): string
    {
        $safeUnitName = Str::slug($unitName, '_');
        $safeSuffix = Str::slug($suffix, '_');

        return "{$module}_{$safeUnitName}_{$safeSuffix}.{$extension}";
    }

    private function configureBrowsershot(Browsershot $browsershot): void
    {
        $nodeBinary = config('laravel-pdf.browsershot.node_binary');
        $npmBinary = config('laravel-pdf.browsershot.npm_binary');
        $nodeModulesPath = config('laravel-pdf.browsershot.node_modules_path') ?: base_path('node_modules');
        $includePath = config('laravel-pdf.browsershot.include_path');
        $chromePath = config('laravel-pdf.browsershot.chrome_path');
        $binPath = config('laravel-pdf.browsershot.bin_path');
        $noSandbox = (bool) config('laravel-pdf.browsershot.no_sandbox', false);

        if (is_string($nodeBinary) && $nodeBinary !== '') {
            $browsershot->setNodeBinary($nodeBinary);
        }

        if (is_string($npmBinary) && $npmBinary !== '') {
            $browsershot->setNpmBinary($npmBinary);
        }

        if (is_string($nodeModulesPath) && $nodeModulesPath !== '') {
            $browsershot->setNodeModulePath($nodeModulesPath);
        }

        if (is_string($includePath) && $includePath !== '' && method_exists($browsershot, 'setIncludePath')) {
            $browsershot->setIncludePath($includePath);
        }

        if (is_string($chromePath) && $chromePath !== '') {
            $browsershot->setChromePath($chromePath);
        }

        if (is_string($binPath) && $binPath !== '' && method_exists($browsershot, 'setBinPath')) {
            $browsershot->setBinPath($binPath);
        }

        if ($noSandbox) {
            $browsershot->noSandbox();
        }
    }

    private function downloadPdfResponse(PdfBuilder $pdfBuilder, string $fileName)
    {
        $this->ensurePuppeteerInstalled();

        $base64Pdf = $pdfBuilder->base64();
        $pdfContent = base64_decode($base64Pdf, true);

        if ($pdfContent === false) {
            throw new RuntimeException('No se pudo decodificar el contenido PDF generado.');
        }

        return response($pdfContent, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="'.$fileName.'"',
        ]);
    }

    private function ensurePuppeteerInstalled(): void
    {
        $nodeModulesPath = config('laravel-pdf.browsershot.node_modules_path') ?: base_path('node_modules');
        $puppeteerPath = rtrim($nodeModulesPath, '\\/').DIRECTORY_SEPARATOR.'puppeteer';

        if (! is_dir($puppeteerPath)) {
            throw new RuntimeException('No se encontró la dependencia Puppeteer en node_modules.');
        }
    }

    private function handleExportFailure(Request $request, string $message, Throwable $exception): JsonResponse|RedirectResponse
    {
        report($exception);

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'message' => $message,
            ], 422);
        }

        return redirect()->back()->withErrors([
            'export' => $message,
        ]);
    }
}
