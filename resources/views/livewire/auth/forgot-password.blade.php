<x-layouts.auth>
    <div class="flex flex-col gap-6">
        <x-auth-header :title="__('Has olvidado tu contraseña')" :description="__('Ingrese su correo electrónico para recibir un enlace de restablecimiento de contraseña')" />

        <!-- Session Status -->
        <x-auth-session-status class="text-center" :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}" class="flex flex-col gap-6">
            @csrf

            <!-- Email Address -->
            <flux:input
                name="email"
                :label="__('Direccion De Correo Electronico')"
                type="email"
                required
                autofocus
                placeholder="email@example.com"
            />

            <flux:button
                variant="primary"
                type="submit"
                class="w-full !bg-emerald-500/80 !text-white font-semibold
                    rounded-lg shadow-sm backdrop-blur-sm transition-all duration-200
                    hover:!bg-emerald-400/90 hover:shadow-lg hover:scale-[1.02]
                    focus-visible:outline-none focus-visible:ring-2
                    focus-visible:ring-emerald-300/80 focus-visible:ring-offset-2
                    focus-visible:ring-offset-white dark:focus-visible:ring-offset-zinc-900"
                data-test="email-password-reset-link-button">
                {{ __('Email password reset link') }}
            </flux:button>
        </form>

        <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-400">
            <span>{{ __('Or, return to') }}</span>
            <flux:link :href="route('login')" wire:navigate>{{ __('log in') }}</flux:link>
        </div>
    </div>
</x-layouts.auth>
