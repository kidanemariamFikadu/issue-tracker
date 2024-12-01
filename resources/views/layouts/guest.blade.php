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
    <div class="flex flex-col h-screen justify-between">
        <header>
            <nav class="bg-white border-gray-200 px-4 lg:px-6 py-2.5 dark:bg-gray-800">
                <div class="flex flex-wrap justify-between items-center mx-auto max-w-screen-xl">
                    <a href="/" class="flex items-center">
                        <img src="https://www.lersha.com/assets/vectors/logo_main.svg"
                            class="mr-3 h-6 sm:h-9 block dark:hidden" alt="Lersha Logo" />
                        <img src="https://www.lersha.com/assets/vectors/logo_main.svg"
                            class="mr-3 h-6 sm:h-9 hidden dark:block" alt="Lersha Logo" />
                        {{-- <span class="self-center text-xl font-semibold whitespace-nowrap dark:text-white">Lersha</span> --}}
                    </a>
                    <div class="flex items-center lg:order-2">
                        
                    </div>
                </div>
            </nav>
        </header>

        <main class="mt-2 p-5 mb-auto">
            {{ $slot }}
        </main>

        <footer class="p-4 bg-white md:p-8 lg:p-10 dark:bg-gray-800">
            <div class="mx-auto max-w-screen-xl text-center">
                <a href="https://www.lersha.com/" target="blank"
                    class="flex justify-center items-center text-2xl font-semibold text-gray-900 dark:text-white">
                    <img src="https://www.lersha.com/assets/vectors/logo_main.svg"
                        class="mr-3 h-6 sm:h-9 block dark:hidden" alt="Lersha Logo" />
                    <img src="https://www.lersha.com/assets/vectors/logo_main.svg"
                        class="mr-3 h-6 sm:h-9 hidden dark:block" alt="Lersha Logo" />
                    {{-- <span class="self-center">Lersha</span>     --}}
                </a>
                <span class="text-sm text-gray-500 sm:text-center dark:text-gray-400">© {{ date('Y') }} <a
                        href="#" class="hover:underline">Lersha™</a>. All Rights Reserved.</span>
            </div>
        </footer>
        @livewire('wire-elements-modal')
    </div>
</body>

</html>
