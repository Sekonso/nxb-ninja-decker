@props([
    'title' => 'nxb ultimate ninja fortune'
])

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    @vite('resources/css/app.css', 'resources/js/app.js')

</head>

<body data-theme="naruto">
    <main class="bg-primary flex items-center justify-center min-h-screen">
        {{ $slot }}
    </main>
</body>

</html>