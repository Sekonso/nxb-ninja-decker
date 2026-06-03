@props([
    'name'
])
@error ($name)
    <p class="text-error"> {{ $message }} </p>
@enderror
