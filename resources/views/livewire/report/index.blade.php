<div x-data="{ tab: window.location.hash ? window.location.hash.substring(1) : (localStorage.getItem('activeTab') || 'settings') }" x-init="$watch('tab', value => { localStorage.setItem('activeTab', value);
    window.history.pushState(null, null, '#' + value); })" class="dark:bg-gray-800 dark:text-gray-200">
    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 mb-3 rounded relative dark:bg-red-200 dark:text-red-900"
            role="alert">
            <strong class="font-bold">Error</strong>
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @elseif (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 mb-3 rounded relative dark:bg-green-200 dark:text-green-900"
            role="alert">
            <strong class="font-bold">Success</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <ul class="flex border-b dark:border-gray-700">
        <li class="mr-1">
            <a :class="{ 'bg-blue-500 text-white dark:bg-blue-700 dark:text-white': tab === 'general-report', 'bg-gray-200 dark:bg-gray-700 dark:text-gray-300': tab !== 'general-report' }"
                class="inline-block py-2 px-4 font-semibold cursor-pointer" @click="tab = 'general-report'">General
                Report</a>
        </li>
        <li class="mr-1">
            <a :class="{ 'bg-blue-500 text-white dark:bg-blue-700 dark:text-white': tab === 'user-report', 'bg-gray-200 dark:bg-gray-700 dark:text-gray-300': tab !== 'user-report' }"
                class="inline-block py-2 px-4 font-semibold cursor-pointer" @click="tab = 'user-report'">User Report</a>
        </li>
    </ul>

    <div class="tab-content mt-4">
        <div x-show="tab === 'general-report'" class="tab-pane">
            <div class="flex mb-4">
                <div class="w-full p-4">
                    @livewire('report.general-report')
                </div>
            </div>
        </div>
        <div x-show="tab === 'user-report'" class="tab-pane">
            <div class="flex mb-4">
                <div class="w-full p-4">
                    @livewire('report.user-report')
                </div>
            </div>
        </div>
    </div>
</div>
