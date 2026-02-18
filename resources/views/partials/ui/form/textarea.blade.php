@props([
    'name',
    'label',
    'value' => null,
    'required' => false,
    'placeholder' => null,
    'rows' => 3,
    'help' => null,
])

@php
    $fieldId = $attributes->get('id', $name);
    $errorMessage = $errors->first($name);
    $hasError = filled($errorMessage);
    $textareaClasses = 'w-full rounded-lg border px-3 py-2 text-sm bg-white transition focus:outline-none resize-none';
    $textareaClasses .= $hasError
        ? ' border-red-300 focus:ring-2 focus:ring-red-200 focus:border-red-400'
        : ' border-slate-200 focus:ring-2 focus:ring-emerald-200 focus:border-emerald-400';
@endphp

<div class="space-y-2">
    <label for="{{ $fieldId }}" class="text-sm font-medium text-slate-700">
        {{ $label }}
        @if ($required)
            <span class="text-red-500">*</span>
        @endif
    </label>

    <textarea
        id="{{ $fieldId }}"
        name="{{ $name }}"
        rows="{{ $rows }}"
        @if($required) required @endif
        placeholder="{{ $placeholder }}"
        {{ $attributes->class($textareaClasses) }}
    >{{ old($name, $value) }}</textarea>

    @if ($help)
        <p class="text-xs text-slate-400">{{ $help }}</p>
    @endif

    @include('partials.ui.form.error', ['name' => $name, 'message' => $errorMessage])
</div>
