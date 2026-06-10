<x-layout title="Error">
    <h1 class="text-6xl font-bold">
        {{ $exception->getStatusCode() }}
    </h1>

    <p class="mt-4">
        {{ $exception->getMessage() ?: __('Whoops, something went wrong.') }}
    </p>
</x-layout>