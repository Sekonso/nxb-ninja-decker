@props([
    'name'
])
@error($name)
    <p {{ $attributes->merge(['class' => 'text-error']) }}>
            {{ $message }}
        </p>
@enderror
