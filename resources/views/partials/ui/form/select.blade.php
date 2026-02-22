@props([
    'name',
    'label',
    'options' => [],
    'value' => null,
    'required' => false,
    'placeholder' => 'Seleccione...',
    'help' => null,
    'useOptionKeys' => false,
])

@php
    $fieldId = $attributes->get('id', $name);
    $errorMessage = $errors->first($name);
    $hasError = filled($errorMessage);
    $selectClasses = 'w-full rounded-lg border px-3 py-2 text-sm bg-white transition focus:outline-none';
    $selectClasses .= $hasError
        ? ' border-red-300 focus:ring-2 focus:ring-red-200 focus:border-red-400'
        : ' border-slate-200 focus:ring-2 focus:ring-emerald-200 focus:border-emerald-400';
    $currentValue = old($name, $value);
@endphp

<div class="space-y-2">
    <label for="{{ $fieldId }}" class="text-sm font-medium text-slate-700">
        {{ $label }}
        @if ($required)
            <span class="text-red-500">*</span>
        @endif
    </label>

    <select
        id="{{ $fieldId }}"
        name="{{ $name }}"
        @if($required) required @endif
        {{ $attributes->class($selectClasses) }}
    >
        @if (! $attributes->has('multiple'))
            <option value="">{{ $placeholder }}</option>
        @endif

        @foreach ($options as $optionValue => $optionLabel)
            @php
                $resolvedValue = $useOptionKeys
                    ? $optionValue
                    : (is_int($optionValue) ? $optionLabel : $optionValue);
            @endphp
            <option value="{{ $resolvedValue }}" @selected((string) $currentValue === (string) $resolvedValue)>
                {{ $optionLabel }}
            </option>
        @endforeach
    </select>

    @if ($help)
        <p class="text-xs text-slate-400">{{ $help }}</p>
    @endif

    @include('partials.ui.form.error', ['name' => $name, 'message' => $errorMessage])
</div>
