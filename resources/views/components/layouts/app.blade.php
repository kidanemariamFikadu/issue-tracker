<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
            <nav class="bg-white border-gray-200 dark:bg-gray-900 dark:border-gray-700">
                <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
                    <a href="/" class="flex items-center space-x-3 rtl:space-x-reverse">
                        <img src="https://www.lersha.com/assets/vectors/logo_main.svg" class="h-8"
                            alt="Lersha Logo" />
                        <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">Lersha</span>
                    </a>
                    <button data-collapse-toggle="navbar-dropdown" type="button"
                        class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                        aria-controls="navbar-dropdown" aria-expanded="false">
                        <span class="sr-only">Open main menu</span>
                        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 17 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M1 1h15M1 7h15M1 13h15" />
                        </svg>
                    </button>
                    <div class="hidden w-full md:block md:w-auto" id="navbar-dropdown">
                        <ul
                            class="flex flex-col font-medium p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
                            <li>
                                <a href="/"
                                    class="block py-2 px-3 rounded md:border-0 md:hover:text-blue-700 md:p-0 {{ request()->route()->getName() == 'dashboard' ? 'text-blue-700 dark:text-blue-500' : 'text-gray-700 dark:text-white' }}">Dashboard</a>
                            </li>
                            <li>
                                <a href="/issues"
                                    class="block py-2 px-3 rounded md:border-0 md:hover:text-blue-700 md:p-0 {{ request()->route()->getName() == 'issues' || request()->route()->getName() == 'issue-detail' ? 'text-blue-700 dark:text-blue-500' : 'text-gray-700 dark:text-white' }}">Issues</a>
                            </li>
                            @role('admin')
                                <li>
                                    <a href="/reports"
                                        class="block py-2 px-3 rounded md:border-0 md:hover:text-blue-700 md:p-0 {{ request()->route()->getName() == 'reports' ? 'text-blue-700 dark:text-blue-500' : 'text-gray-700 dark:text-white' }}">Report</a>
                                </li>
                                <li>
                                    <a href="/settings"
                                        class="block py-2 px-3 rounded md:border-0 md:hover:text-blue-700 md:p-0 {{ request()->route()->getName() == 'setting' ? 'text-blue-700 dark:text-blue-500' : 'text-gray-700 dark:text-white' }}">Settings</a>
                                </li>
                            @endrole
                            <li>
                                <button id="dropdownNavbarLink" data-dropdown-toggle="dropdownNavbar"
                                    class="flex items-center justify-between w-full py-2 px-3 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 md:w-auto md:dark:hover:text-blue-500 dark:focus:text-white dark:border-gray-700 dark:hover:bg-gray-700 md:dark:hover:bg-transparent {{ request()->route()->getName() == 'my-profile' ? 'text-blue-700 dark:text-blue-500' : 'text-gray-700 dark:text-white' }}">
                                    {{ Auth::user()->name }}
                                    <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true"
                                        xmlns="https://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
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
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white {{ request()->route()->getName() == 'my-profile' ? 'bg-gray-100 dark:bg-gray-600 text-blue-500' : 'text-gray-700 dark:text-white' }}">Profile</a>
                                        </li>
                                    </ul>
                                    <div class="py-1">
                                        <form method="POST" action="{{ secure_url(route('logout', [], false)) }}"
                                            x-data>
                                            @csrf
                                            <a href="{{ route('logout') }}" @click.prevent="$root.submit();"
                                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Sign
                                                out</a>
                                        </form>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <button id="dropdownNavbarLink" data-dropdown-toggle="notification-bar"
                                    class="relative flex items-center justify-between w-full py-2 px-3 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 md:w-auto md:dark:hover:text-blue-500 dark:focus:text-white dark:border-gray-700 dark:hover:bg-gray-700 md:dark:hover:bg-transparent {{ request()->route()->getName() == 'notifications' ? 'text-blue-700 dark:text-blue-500' : 'text-gray-700 dark:text-white' }}">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V4a2 2 0 10-4 0v1.341C7.67 7.165 7 9.388 7 11v3.159c0 .538-.214 1.055-.595 1.436L5 17h5m5 0a3 3 0 11-6 0m6 0H9">
                                        </path>
                                    </svg>
                                    @if (Auth::user()->unreadNotifications->count() > 0)
                                        <span
                                            class="absolute top-0 right-0 transform translate-x-1/2 -translate-y-1/2 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 bg-red-600 rounded-full">
                                            {{ Auth::user()->unreadNotifications->count() }}
                                        </span>
                                    @endif
                                </button>
                                <!-- Dropdown menu -->
                                <div id="notification-bar"
                                    class="z-10 hidden font-normal bg-white divide-y divide-gray-100 rounded-lg shadow w-1/3 dark:bg-gray-700 dark:divide-gray-600">
                                    @livewire('notification-popup')
                                </div>
                            </li>
                            <li>
                                <a href="/user-manuals"
                                    class="block py-2 px-3 rounded md:border-0 md:hover:text-blue-700 md:p-0 {{ request()->route()->getName() == 'user-manuals' || request()->route()->getName() == 'user-manuals' ? 'text-blue-700 dark:text-blue-500' : 'text-gray-700 dark:text-white' }}">
                                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                        viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M9.529 9.988a2.502 2.502 0 1 1 5 .191A2.441 2.441 0 0 1 12 12.582V14m-.01 3.008H12M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>
                                </a>
                            </li>
                        </ul>
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
            console.log(data[0])
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

            const toastType = types[data[0].type] || types.info; // Default to 'info' if type not found

            // Create a new toast element
            const toast = document.createElement('div');
            toast.className =
                `flex items-center p-4 w-full max-w-xs rounded-lg shadow dark:text-gray-200 ${toastType.bg}`;
            toast.innerHTML = `
                <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 rounded-lg ${toastType.iconBg}">
                    ${toastType.icon}
                </div>
                <div class="ml-3 text-sm font-normal">${data[0].message}</div>
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</body>

</html>
