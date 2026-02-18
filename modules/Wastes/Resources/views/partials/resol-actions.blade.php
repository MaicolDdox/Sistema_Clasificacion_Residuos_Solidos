@php
    $isOwnerAprendiz = auth()->user()->hasRole('Aprendiz') && $waste->user_id === auth()->id();
    $canEdit = $isOwnerAprendiz || (! auth()->user()->hasRole('Aprendiz') && auth()->user()->can('wastes.edit'));
    $canDelete = auth()->user()->can('wastes.destroy');
    $canExport = auth()->user()->can('wastes.report.resol');
    $menuId = 'resol-'.$waste->id;

    $actions = [
        [
            'label' => 'Ver detalles',
            'href' => route('wastes.show', $waste),
            'variant' => 'info',
        ],
    ];

    if ($canEdit) {
        $actions[] = [
            'label' => 'Editar',
            'href' => route('wastes.edit', $waste),
            'variant' => 'warning',
        ];
    }

    if ($canDelete) {
        $actions[] = [
            'label' => 'Eliminar',
            'href' => route('wastes.destroy', $waste),
            'method' => 'DELETE',
            'variant' => 'danger',
            'confirm' => true,
            'confirmTitle' => 'Confirmar eliminación',
            'confirmMessage' => 'Esta acción eliminará el registro seleccionado de RESOL.',
            'confirmButtonText' => 'Eliminar',
        ];
    }

    if ($canExport) {
        $actions[] = [
            'label' => 'Exportar PDF',
            'href' => route('wastes.export.single.pdf', $waste),
            'variant' => 'default',
        ];
        $actions[] = [
            'label' => 'Exportar Excel',
            'href' => route('wastes.export.single.excel', $waste),
            'variant' => 'default',
        ];
    }
@endphp

@include('partials.ui.actions-dropdown', [
    'id' => $menuId,
    'actions' => $actions,
])
