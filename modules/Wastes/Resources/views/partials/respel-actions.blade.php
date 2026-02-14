<div class="flex items-center gap-2 justify-center">
    {{-- Editar: Aprendiz solo ve el boton si es su registro --}}
    @if(Auth::user()->hasRole('Aprendiz'))
        @if($waste->user_id === Auth::id())
            <a
                href="{{ route('hazardou-wastes.edit', $waste) }}"
                class="inline-flex items-center gap-1 px-3 py-2 rounded-lg bg-amber-100 text-amber-700 hover:bg-amber-200 transition"
                title="Editar"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Editar
            </a>
        @endif
    @elseif(Auth::user()->can('hazardou-wastes.edit'))
        <a
            href="{{ route('hazardou-wastes.edit', $waste) }}"
            class="inline-flex items-center gap-1 px-3 py-2 rounded-lg bg-amber-100 text-amber-700 hover:bg-amber-200 transition"
            title="Editar"
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>
            Editar
        </a>
    @endif

    {{-- Eliminar: solo roles con permiso (no Aprendiz) --}}
    @can('hazardou-wastes.destroy')
        <form
            action="{{ route('hazardou-wastes.destroy', $waste) }}"
            method="POST"
            class="inline-flex"
            onsubmit="return confirm('¿Seguro que deseas eliminar este registro?');"
        >
            @csrf
            @method('DELETE')
            <button
                type="submit"
                class="inline-flex items-center gap-1 px-3 py-2 rounded-lg bg-red-100 text-red-700 hover:bg-red-200 transition"
                title="Eliminar"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
                Eliminar
            </button>
        </form>
    @endcan
</div>
