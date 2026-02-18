@php
    $isOwnerAprendiz = auth()->user()->hasRole('Aprendiz') && $waste->user_id === auth()->id();
    $canEdit = $isOwnerAprendiz || (! auth()->user()->hasRole('Aprendiz') && auth()->user()->can('hazardou-wastes.edit'));
    $canDelete = auth()->user()->can('hazardou-wastes.destroy');
    $canExport = auth()->user()->can('wastes.report.respel');
    $menuId = 'respel-'.$waste->id;

    $actions = [
        [
            'label' => 'Ver detalles',
            'href' => route('hazardou-wastes.show', $waste),
            'variant' => 'info',
        ],
    ];

    if ($canEdit) {
        $actions[] = [
            'label' => 'Editar',
            'href' => route('hazardou-wastes.edit', $waste),
            'variant' => 'warning',
        ];
    }

    if ($canDelete) {
        $actions[] = [
            'label' => 'Eliminar',
            'href' => route('hazardou-wastes.destroy', $waste),
            'method' => 'DELETE',
            'variant' => 'danger',
            'confirm' => true,
            'confirmTitle' => 'Confirmar eliminación',
            'confirmMessage' => 'Esta acción eliminará el registro seleccionado de RESPEL.',
            'confirmButtonText' => 'Eliminar',
        ];
    }

    if ($canExport) {
        $actions[] = [
            'label' => 'Exportar PDF',
            'href' => route('hazardou-wastes.export.single.pdf', $waste),
            'variant' => 'default',
        ];
        $actions[] = [
            'label' => 'Exportar Excel',
            'href' => route('hazardou-wastes.export.single.excel', $waste),
            'variant' => 'default',
        ];
    }
@endphp

@include('partials.ui.actions-dropdown', [
    'id' => $menuId,
    'actions' => $actions,
])
