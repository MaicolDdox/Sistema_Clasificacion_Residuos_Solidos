<x-layouts.auth>
    <div class="flex flex-col gap-6">
        <x-auth-header :title="__('Inicia sesión en tu cuenta')" :description="__('Ingrese su correo electrónico y contraseña a continuación para iniciar sesión')" />

        <!-- Session Status -->
        <x-auth-session-status class="text-center" :status="session('status')" />

        <form method="POST" action="{{ route('login.store') }}" class="flex flex-col gap-6">
            @csrf

            <!-- Email Address -->
            <flux:input
                name="email"
                :label="__('Direccion de Correo Electronico')"
                :value="old('email')"
                type="email"
                required
                autofocus
                autocomplete="email"
                placeholder="email@example.com"
            />

            <!-- Password -->
            <div class="relative">
                <flux:input
                    name="password"
                    :label="__('Contraseña')"
                    type="password"
                    required
                    autocomplete="current-password"
                    :placeholder="__('Password')"
                    viewable
                />

                @if (Route::has('password.request'))
                    <flux:link class="absolute top-0 text-sm end-0" :href="route('password.request')" wire:navigate>
                        {{ __('Olvidaste tu contraseña?') }}
                    </flux:link>
                @endif
            </div>

            <div class="flex items-center justify-end">
                <flux:button
                    type="submit"
                    class="w-full !bg-emerald-500/80 !text-white font-semibold
                    rounded-lg shadow-sm backdrop-blur-sm transition-all duration-200
                    hover:!bg-emerald-400/90 hover:shadow-lg hover:scale-[1.02]
                    focus-visible:outline-none focus-visible:ring-2
                    focus-visible:ring-emerald-300/80 focus-visible:ring-offset-2
                    focus-visible:ring-offset-white dark:focus-visible:ring-offset-zinc-900"
                    data-test="login-button">
                    {{ __('Entrar') }}
                </flux:button>
            </div>
        </form>

        @if (Route::has('register'))
            <div class="space-x-1 text-sm text-center rtl:space-x-reverse text-zinc-600 dark:text-zinc-400">
                <span>{{ __('No tienes cuenta?') }}</span>
                <flux:link :href="route('register')" wire:navigate>{{ __('Registrate') }}</flux:link>
            </div>
        @endif
    </div>
</x-layouts.auth>
