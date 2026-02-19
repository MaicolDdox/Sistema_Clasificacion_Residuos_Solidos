<?php

namespace Modules\Wastes\Http\Controllers;

use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Modules\ProductiveUnits\Models\ProductiveUnit;
use Modules\Wastes\Exports\WasteRowsExport;
use Modules\Wastes\Http\Requests\ExportRespelRequest;
use Modules\Wastes\Models\HazardouWaste;
use Modules\Wastes\Services\WasteExportQueryService;
use Modules\Wastes\Services\WasteExportRangeService;
use Throwable;

class HazardouWasteExportController extends Controller
{
    public function __construct(
        private readonly WasteExportRangeService $rangeService,
        private readonly WasteExportQueryService $queryService
    ) {}

    public function rangePdf(ExportRespelRequest $request, ProductiveUnit $unit)
    {
        try {
            $range = $this->rangeService->resolve($request->validated());
            $rows = $this->queryService
                ->respelRangeQuery($unit, $range['start_date'], $range['end_date'])
                ->get();

            $fileName = $this->buildFileName(
                module: 'respel',
                unitName: $unit->name,
                suffix: $range['range_slug'],
                extension: 'pdf'
            );

            $pdf = Pdf::loadView('wastes::exports.waste-export-pdf', [
                'title'       => 'Exportación RESPEL',
                'moduleLabel' => 'RESPEL',
                'unitName'    => $unit->name,
                'rangeLabel'  => $range['range_label'],
                'rows'        => $rows,
                'generatedAt' => now(),
            ])->setPaper('a4', 'landscape');

            return $this->downloadPdfResponse($pdf, $fileName);
        } catch (Throwable $exception) {
            return $this->handleExportFailure(
                $request,
                'No se pudo generar el PDF.',
                $exception
            );
        }
    }

    public function rangeExcel(ExportRespelRequest $request, ProductiveUnit $unit)
    {
        try {
            $range = $this->rangeService->resolve($request->validated());
            $query = $this->queryService
                ->respelRangeQuery($unit, $range['start_date'], $range['end_date']);

            $fileName = $this->buildFileName(
                module: 'respel',
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

    public function singlePdf(Request $request, HazardouWaste $hazardouWaste)
    {
        try {
            $hazardouWaste->loadMissing('productiveUnit');

            $rows = $this->queryService
                ->respelSingleQuery($hazardouWaste->id)
                ->get();

            $fileName = $this->buildFileName(
                module: 'respel',
                unitName: $hazardouWaste->productiveUnit->name ?? 'sin-unidad',
                suffix: "registro_{$hazardouWaste->id}",
                extension: 'pdf'
            );

            $pdf = Pdf::loadView('wastes::exports.waste-export-pdf', [
                'title'       => 'Exportación RESPEL',
                'moduleLabel' => 'RESPEL',
                'unitName'    => $hazardouWaste->productiveUnit->name ?? 'Sin unidad',
                'rangeLabel'  => "Registro individual #{$hazardouWaste->id}",
                'rows'        => $rows,
                'generatedAt' => now(),
            ])->setPaper('a4', 'landscape');

            return $this->downloadPdfResponse($pdf, $fileName);
        } catch (Throwable $exception) {
            return $this->handleExportFailure(
                $request,
                'No se pudo generar el PDF del registro.',
                $exception
            );
        }
    }

    public function singleExcel(Request $request, HazardouWaste $hazardouWaste)
    {
        try {
            $hazardouWaste->loadMissing('productiveUnit');

            $query = $this->queryService->respelSingleQuery($hazardouWaste->id);

            $fileName = $this->buildFileName(
                module: 'respel',
                unitName: $hazardouWaste->productiveUnit->name ?? 'sin-unidad',
                suffix: "registro_{$hazardouWaste->id}",
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
        $safeSuffix   = Str::slug($suffix, '_');

        return "{$module}_{$safeUnitName}_{$safeSuffix}.{$extension}";
    }

    private function downloadPdfResponse(\Barryvdh\DomPDF\PDF $pdf, string $fileName)
    {
        return response($pdf->output(), 200, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ]);
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
