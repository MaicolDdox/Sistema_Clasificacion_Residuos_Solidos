@php
    $menuId = 'roles-'.$user->id;

    $actions = [
        [
            'label' => 'Editar',
            'href' => route('roles.edit', $user->id),
            'variant' => 'warning',
        ],
        [
            'label' => 'Eliminar',
            'href' => route('roles.destroy', $user->id),
            'method' => 'DELETE',
            'variant' => 'danger',
            'confirm' => true,
            'confirmTitle' => 'Confirmar eliminación',
            'confirmMessage' => '¿Seguro que deseas remover todos los roles de este usuario?',
            'confirmButtonText' => 'Eliminar',
        ],
    ];
@endphp

@include('partials.ui.actions-dropdown', [
    'id' => $menuId,
    'actions' => $actions,
])
