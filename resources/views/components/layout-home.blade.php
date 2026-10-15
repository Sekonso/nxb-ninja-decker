@props(['title'])

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>NxB Ninja Decker {{ $title ? "- $title" : ""}}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body data-theme="naruto" class="bg-base-100">
    <div class="max-w-xl h-dvh mx-auto bg-base-100 shadow-lg overflow-hidden">
        <main class="h-full">
            {{ $slot }}
        </main>
    </div>
</body>
</html>