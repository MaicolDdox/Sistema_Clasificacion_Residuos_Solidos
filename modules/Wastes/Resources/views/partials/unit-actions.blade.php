@php
    $menuId = 'unit-'.$unit->id;

    $actions = [
        [
            'label' => 'Registrar residuo',
            'variant' => 'success',
            'eventName' => 'wastes:unit-register-modal.open',
            'eventDetail' => [
                'unitName' => $unit->name,
                'resolCreateUrl' => route('wastes.create', ['unit' => $unit->id]),
                'respelCreateUrl' => route('hazardou-wastes.create', ['unit' => $unit->id]),
            ],
        ],
        [
            'label' => 'Ver residuos',
            'variant' => 'info',
            'eventName' => 'wastes:unit-view-modal.open',
            'eventDetail' => [
                'unitName' => $unit->name,
                'resolUrl' => route('wastes.byUnit', ['unit' => $unit->id]),
                'respelUrl' => route('hazardou-wastes.byUnit', ['unit' => $unit->id]),
            ],
        ],
    ];
@endphp

@include('partials.ui.actions-dropdown', [
    'id' => $menuId,
    'actions' => $actions,
])
