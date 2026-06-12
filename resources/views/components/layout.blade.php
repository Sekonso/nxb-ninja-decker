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
    <div class="max-w-xl  min-h-screen mx-auto bg-base-100 shadow-lg">
        <x-nav></x-nav>

        <main class="p-5 ">
            {{ $slot }}
        </main>
    </div>
</body>
</html>

{{-- pre-submit styling (general) --}}
<script>
    function beforeSubmit(event, buttonId = 'submit') {
        event.preventDefault();

        const form = event.target;
        const submitBtn = document.getElementById(buttonId);

        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="loading loading-bars loading-md"></span>';

        setTimeout(() => {
            form.submit();
        }, 1000);
    }
</script>