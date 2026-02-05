<div class="flex items-center space-x-2">

    {{-- Boton Editar Rol --}}
    <a
        href="{{ route('roles.edit', $user->id) }}"
        title="Editar Rol del Usuario"
        class="bg-amber-100 hover:bg-amber-200 text-amber-700 p-2
        rounded-lg transition-colors duration-200 group">

        <svg
            class="w-4 h-4 group-hover:scale-110
            transition-transform duration-200"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24">

            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M11 5H6a2 2 0 00-2 2v11a2 2 0
                002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2
                0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
        </svg>
    </a>

    {{-- Boton Eliminar Roles --}}
    <form
        action="{{ route('roles.destroy', $user->id) }}"
        method="POST"
        class="inline"
        onsubmit="return confirm('¿Seguro que deseas remover todos los roles de este usuario?');">
        @csrf @method('DELETE')

        <button
            type="submit"
            title="Remover Roles del Usuario"
            class="bg-red-100 hover:bg-red-200 text-red-700
            p-2 rounded-lg transition-colors duration-200 group">

            <svg
                class="w-4 h-4 group-hover:scale-110
                transition-transform duration-200"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24">

                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M19 7l-.867 12.142A2 2 0 0116.138
                    21H7.862a2 2 0 01-1.995-1.858L5 7m5
                    4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
            </svg>
        </button>
    </form>
</div>
