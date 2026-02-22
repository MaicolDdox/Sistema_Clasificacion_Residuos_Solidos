@php
    $menuId = 'productive-unit-'.$unit->id;
    $wastesCount = (int) ($unit->wastes_count ?? 0);
    $hazardouWastesCount = (int) ($unit->hazardou_wastes_count ?? 0);
    $totalRelatedRecords = $wastesCount + $hazardouWastesCount;
    $hasLinkedRecords = $totalRelatedRecords > 0;

    $actions = [];

    if (auth()->user()?->can('productive-units.show')) {
        $actions[] = [
            'label' => 'Ver detalles',
            'href' => route('productive-units.show', $unit),
            'variant' => 'info',
            'icon' => 'eye',
        ];
    }

    if (auth()->user()?->can('productive-units.edit')) {
        $actions[] = [
            'label' => 'Editar',
            'href' => route('productive-units.edit', $unit),
            'variant' => 'warning',
            'icon' => 'edit',
        ];
    }

    if (auth()->user()?->can('productive-units.destroy')) {
        if ($hasLinkedRecords) {
            $actions[] = [
                'label' => 'Eliminar',
                'variant' => 'danger',
                'icon' => 'trash',
                'eventName' => 'ui:confirm-modal.open',
                'eventDetail' => [
                    'title' => 'No se puede eliminar la unidad',
                    'message' => 'Esta unidad tiene '.$totalRelatedRecords.' registro(s) asociado(s): '.$wastesCount.' RESOL y '.$hazardouWastesCount.' RESPEL. Debes eliminarlos antes de continuar.',
                    'confirmButtonText' => 'Entendido',
                    'confirmVariant' => 'default',
                    'hideCancel' => true,
                ],
            ];
        } else {
            $actions[] = [
                'label' => 'Eliminar',
                'href' => route('productive-units.destroy', $unit),
                'method' => 'DELETE',
                'variant' => 'danger',
                'icon' => 'trash',
                'confirm' => true,
                'confirmTitle' => 'Confirmar eliminación',
                'confirmMessage' => 'Esta acción eliminará la unidad productiva seleccionada.',
                'confirmButtonText' => 'Eliminar',
            ];
        }
    }
@endphp

@include('partials.ui.actions-dropdown', [
    'id' => $menuId,
    'actions' => $actions,
])
