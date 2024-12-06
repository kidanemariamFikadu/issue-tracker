<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/datepicker.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


    <style>
        .dark-mode .light-image {
            display: none;
        }

        .dark-mode .dark-image {
            display: block;
        }

        .light-mode .light-image {
            display: block;
        }

        .light-mode .dark-image {
            display: none;
        }
    </style>
</head>

<body class="antialised">
    <div class="flex flex-col h-s

        <main class="mt-2 p-5 mb-auto">
            {{ $slot }}
        </main>
    </div>
</body>

</html>
