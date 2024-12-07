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
                        <div class="hidden justify-between items-center w-full lg:flex lg:w-auto lg:order-2"
                            id="mobile-menu-2">
                            <ul class="flex flex-col mt-4 font-medium lg:flex-row lg:space-x-8 lg:mt-0">
                                <li>
                                    <a href="/issues"
                                        class="block py-2 pr-4 pl-3 text-gray-700 rounded bg-primary-700 lg:bg-transparent lg:text-primary-700 lg:p-0 dark:text-white">Issues</a>
                                </li>
                            </ul>
                        </div>
                        <button id="dropdownNavbarLink" data-dropdown-toggle="dropdownNavbar"
                            class="flex items-center justify-between w-full py-2 px-3 text-gray-900 hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 md:w-auto dark:text-white md:dark:hover:text-blue-500 dark:focus:text-white dark:hover:bg-gray-700 md:dark:hover:bg-transparent">
                            <span class="ml-4">
                                <svg class="h-6 w-6 text-gray-800 dark:text-gray-200" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </span>
                            {{ Auth::user()->name }}
                            <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="https://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 4 4 4-4" />
                            </svg></button>
                        <!-- Dropdown menu -->
                        <div id="dropdownNavbar"
                            class="z-10 hidden font-normal bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                            <ul class="py-2 text-sm text-gray-700 dark:text-gray-200"
                                aria-labelledby="dropdownLargeButton">
                                <li>
                                    <a href="{{ route('my-profile') }}"
                                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Profile</a>
                                </li>
                                {{-- <div class="border-t border-gray-200"></div> --}}
                            </ul>
                            <div class="py-1">
                                <form method="POST" action="{{ secure_url(route('logout', [], false)) }}" x-data>
                                    @csrf
                                    <a href="{{ route('logout') }}" @click.prevent="$root.submit();"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Sign
                                        out</a>
                                </form>
                            </div>
                        </div>
                        @role('admin')
                            <a href="/settings"
                                class="text-gray-700 dark:text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-4 lg:px-5 py-2 lg:py-2.5 mr-2 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800">
                                Settings
                            </a>
                        @endrole
                        <button data-collapse-toggle="mobile-menu-2" type="button"
                            class="inline-flex items-center p-2 ml-1 text-sm text-gray-500 rounded-lg lg:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                            aria-controls="mobile-menu-2" aria-expanded="false">
                            <span class="sr-only">Open main menu</span>
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="https://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <svg class="hidden w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="https://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </nav>
        </header>

        <main class="mt-2 p-5 mb-auto">
            {{ $slot }}
        </main>

        <footer class="p-4 bg-white md:p-8 lg:p-10 dark:bg-gray-800">
            <div class="mx-auto max-w-screen-xl text-center">
                {{-- Globale Toast Container --}}
                <div id="toast-container" class="fixed buttom-4 space-y-4 z50">
                    {{-- Toasts will be dynamically append here --}}
                </div>
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

    @livewireScripts
    <script>
        // Listen for the Livewire 'show-toast' event
        Livewire.on('show-toast', (data) => {
            console.log(data)
            const container = document.getElementById('toast-container');

            // Determine type-specific styles and icons
            const types = {
                success: {
                    bg: "bg-green-100 dark:bg-green-800",
                    iconBg: "text-green-500 dark:text-green-200",
                    icon: `
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="https://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M16.707 4.293a1 1 0 010 1.414L9 13.414l-3.293-3.293a1 1 0 011.414-1.414L9 10.586l6.293-6.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                    `
                },
                error: {
                    bg: "bg-red-100 dark:bg-red-800",
                    iconBg: "text-red-500 dark:text-red-200",
                    icon: `
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="https://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.682-1.36 3.446 0l6.01 10.68c.764 1.36-.191 3.041-1.723 3.041H3.97c-1.533 0-2.487-1.681-1.723-3.041l6.01-10.68zM11 13a1 1 0 10-2 0 1 1 0 002 0zm-1-7a1 1 0 00-.707.293l-1 1a1 1 0 101.414 1.414L10 7.414l.293.293a1 1 0 001.414-1.414l-1-1A1 1 0 0010 6z" clip-rule="evenodd"></path>
                        </svg>
                    `
                },
                info: {
                    bg: "bg-blue-100 dark:bg-blue-800",
                    iconBg: "text-blue-500 dark:text-blue-200",
                    icon: `
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="https://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M18 10c0 4.418-3.582 8-8 8s-8-3.582-8-8 3.582-8 8-8 8 3.582 8 8zm-9-3a1 1 0 112 0v4a1 1 0 01-2 0V7zm0 6a1 1 0 100 2h.01a1 1 0 000-2H9z" clip-rule="evenodd"></path>
                        </svg>
                    `
                }
            };

            const toastType = types[data.type] || types.info; // Default to 'info' if type not found

            // Create a new toast element
            const toast = document.createElement('div');
            toast.className =
                `flex items-center p-4 w-full max-w-xs rounded-lg shadow dark:text-gray-200 ${toastType.bg}`;
            toast.innerHTML = `
                <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 rounded-lg ${toastType.iconBg}">
                    ${toastType.icon}
                </div>
                <div class="ml-3 text-sm font-normal">${data.message}</div>
                <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700" aria-label="Close" onclick="this.parentElement.remove();">
                    <span class="sr-only">Close</span>
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="https://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 011.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            `;

            // Append the toast to the container
            container.appendChild(toast);

            // Automatically remove the toast after 5 seconds
            setTimeout(() => {
                toast.remove();
            }, 5000);
        });
    </script>

</body>

</html>
