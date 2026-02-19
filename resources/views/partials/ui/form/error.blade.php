@props([
    'name' => null,
    'message' => null,
])

@php
    $errorMessage = $message ?? ($name ? $errors->first($name) : null);
@endphp

@if ($errorMessage)
    <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span class="break-words">{{ $errorMessage }}</span>
    </p>
@endif
