@props([
    'message' => __('Por favor corrige los errores e inténtalo de nuevo.'),
])

@if ($errors->any())
    <div class="flex items-start gap-3 rounded-radius border border-danger/40 bg-danger/10 px-4 py-3 text-sm text-danger">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4m0 4h.01m-6.938 0h13.856c1.54 0 2.502-1.667 1.732-3L13.732 5c-.77-1.333-2.694-1.333-3.464 0L4.34 14c-.77 1.333.192 3 1.732 3z" />
        </svg>
        <p class="leading-5">{{ $message }}</p>
    </div>
@endif
