<li data-aos="fade-right" data-aos-duration="600" data-aos-delay="350" x-data="{ open: false }">
    <button @click="open = !open"
        class="w-full group flex items-center justify-between gap-3 px-3 py-2.5 rounded-xl text-slate-600 hover:bg-emerald-50/60 hover:text-emerald-700 transition-all duration-300">
        <div class="flex items-center gap-3">
            <span
                class="w-9 h-9 rounded-lg bg-slate-100/80 group-hover:bg-emerald-100/80 flex items-center justify-center transition-all duration-300">
                <svg class="w-[18px] h-[18px] text-slate-500 group-hover:text-emerald-600 transition-colors duration-300"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
            </span>
            <span class="text-sm font-medium">Roles</span>
        </div>
        <svg class="w-4 h-4 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none"
            stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
    </button>

    <div x-show="open"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 transform -translate-y-2"
         x-transition:enter-end="opacity-100 transform translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 transform translate-y-0"
         x-transition:leave-end="opacity-0 transform -translate-y-2"
         class="mt-1 ml-12 space-y-1">
        <a href="{{ route('roles.index') }}"
            class="block px-3 py-2 text-sm text-slate-600 hover:text-emerald-600 hover:bg-emerald-50/40 rounded-lg transition-colors">
            Gestionar Roles
        </a>
        <a href="{{ route('roles.create') }}"
            class="block px-3 py-2 text-sm text-slate-600 hover:text-emerald-600 hover:bg-emerald-50/40 rounded-lg transition-colors">
            Asignar Rol
        </a>
    </div>
</li>
