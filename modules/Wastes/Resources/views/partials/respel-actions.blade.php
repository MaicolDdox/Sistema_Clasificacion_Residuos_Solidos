@php
    $isOwnerAprendiz = Auth::user()->hasRole('Aprendiz') && $waste->user_id === Auth::id();
    $canEdit = $isOwnerAprendiz || (! Auth::user()->hasRole('Aprendiz') && Auth::user()->can('hazardou-wastes.edit'));
    $canDelete = Auth::user()->can('hazardou-wastes.destroy');
    $canExport = Auth::user()->can('wastes.report.respel');
    $menuId = 'respel-'.$waste->id;
@endphp

<div class="inline-flex justify-center w-full">
    <button
        type="button"
        class="inline-flex items-center justify-center w-9 h-9 rounded-lg border border-slate-200 bg-white text-slate-600 hover:bg-slate-50 transition"
        title="Acciones"
        data-row-actions-trigger
        data-menu-id="{{ $menuId }}"
        data-show-url="{{ route('hazardou-wastes.show', $waste) }}"
        data-edit-url="{{ $canEdit ? route('hazardou-wastes.edit', $waste) : '' }}"
        data-delete-url="{{ $canDelete ? route('hazardou-wastes.destroy', $waste) : '' }}"
        data-export-pdf-url="{{ $canExport ? route('hazardou-wastes.export.single.pdf', $waste) : '' }}"
        data-export-excel-url="{{ $canExport ? route('hazardou-wastes.export.single.excel', $waste) : '' }}"
        aria-haspopup="true"
        aria-expanded="false"
    >
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5h.01M12 12h.01M12 19h.01" />
        </svg>
    </button>
</div>
