@props([
    'title' => ''
])

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NxB Ninja Decker {{ $title ? "- $title" :  ""}}</title>
    @vite('resources/css/app.css', 'resources/js/app.js')

</head>

<body data-theme="naruto" class="bg-base-100">
    <div class="max-w-3xl mx-auto bg-base-100 shadow-md">
        <x-nav></x-nav>

        <main class="p-5">
            {{ $slot }}
        </main>
    </div>
</body>

</html>