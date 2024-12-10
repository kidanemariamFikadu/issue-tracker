<div x-data="{ tab: 'settings' }" class="dark:bg-gray-800 dark:text-gray-200">
    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 mb-3 rounded relative dark:bg-red-200 dark:text-red-900" role="alert">
            <strong class="font-bold">Error</strong>
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @elseif (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 mb-3 rounded relative dark:bg-green-200 dark:text-green-900" role="alert">
            <strong class="font-bold">Success</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <ul class="flex border-b dark:border-gray-700">
        <li class="mr-1">
            <a :class="{ 'bg-white dark:bg-gray-900 dark:text-white': tab === 'settings', 'bg-gray-200 dark:bg-gray-700 dark:text-gray-300': tab !== 'settings' }" 
               class="inline-block py-2 px-4 font-semibold cursor-pointer" 
               @click="tab = 'settings'">Settings</a>
        </li>
        <li class="mr-1">
            <a :class="{ 'bg-white dark:bg-gray-900 dark:text-white': tab === 'users', 'bg-gray-200 dark:bg-gray-700 dark:text-gray-300': tab !== 'users' }" 
               class="inline-block py-2 px-4 font-semibold cursor-pointer" 
               @click="tab = 'users'">Users</a>
        </li>
    </ul>

    <div class="tab-content mt-4">
        <div x-show="tab === 'settings'" class="tab-pane">
            <div class="flex mb-4">
                <div class="w-1/2 p-4 mr-4">
                    @livewire('settings.application-list')
                </div>
                <div class="w-1/2 p-4">
                    @livewire('settings.category-list')
                </div>
            </div>
        </div>
        <div x-show="tab === 'users'" class="tab-pane">
            <div class="flex mb-4">
                <div class="w-full p-4">
                    @livewire('settings.user-list')
                </div>
            </div>
        </div>
    </div>
</div>

<script src="//unpkg.com/alpinejs" defer></script>
