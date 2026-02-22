@php
    $menuId = 'area-'.$area->id;
    $hasLinkedUnits = (int) ($area->productive_units_count ?? 0) > 0;

    $actions = [
        [
            'label' => 'Ver detalles',
            'href' => route('areas.show', $area),
            'variant' => 'info',
            'icon' => 'eye',
        ],
    ];

    if (auth()->user()?->can('areas.edit')) {
        $actions[] = [
            'label' => 'Editar',
            'href' => route('areas.edit', $area),
            'variant' => 'warning',
            'icon' => 'edit',
        ];
    }

    if (auth()->user()?->can('areas.destroy')) {
        if ($hasLinkedUnits) {
            $actions[] = [
                'label' => 'Eliminar',
                'variant' => 'danger',
                'icon' => 'trash',
                'eventName' => 'ui:confirm-modal.open',
                'eventDetail' => [
                    'title' => 'No se puede eliminar el área',
                    'message' => 'Esta área tiene '.$area->productive_units_count.' unidad(es) productiva(s) asociada(s). Debes eliminarlas o reasignarlas antes de continuar.',
                    'confirmButtonText' => 'Entendido',
                    'confirmVariant' => 'default',
                    'hideCancel' => true,
                ],
            ];
        } else {
            $actions[] = [
                'label' => 'Eliminar',
                'href' => route('areas.destroy', $area),
                'method' => 'DELETE',
                'variant' => 'danger',
                'icon' => 'trash',
                'confirm' => true,
                'confirmTitle' => 'Confirmar eliminación',
                'confirmMessage' => 'Esta acción eliminará el área seleccionada.',
                'confirmButtonText' => 'Eliminar',
            ];
        }
    }
@endphp

@include('partials.ui.actions-dropdown', [
    'id' => $menuId,
    'actions' => $actions,
])
