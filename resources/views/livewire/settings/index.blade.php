<div x-data="{
    tab: 'settings',
    init() {
        const storedTab = localStorage.getItem('activeTab');
        this.tab = storedTab ? storedTab : 'settings';
        this.$watch('tab', value => localStorage.setItem('activeTab', value));
    }
}" class="">
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
            <a :class="{ 'bg-blue-500 text-white dark:bg-blue-700 dark:text-white': tab === 'settings', 'bg-gray-200 dark:bg-gray-700 dark:text-gray-300': tab !== 'settings' }"
                class="inline-block py-2 px-4 font-semibold cursor-pointer" href="#settings"
                @click="tab = 'settings'">Settings</a>
        </li>
        <li class="mr-1">
            <a :class="{ 'bg-blue-500 text-white dark:bg-blue-700 dark:text-white': tab === 'users', 'bg-gray-200 dark:bg-gray-700 dark:text-gray-300': tab !== 'users' }"
                class="inline-block py-2 px-4 font-semibold cursor-pointer" href="#users"
                @click="tab = 'users'">Users</a>
        </li>
        <li class="mr-1">
            <a :class="{ 'bg-blue-500 text-white dark:bg-blue-700 dark:text-white': tab === 'user-manual', 'bg-gray-200 dark:bg-gray-700 dark:text-gray-300': tab !== 'user-manual' }"
                class="inline-block py-2 px-4 font-semibold cursor-pointer" @click="tab = 'user-manual'">User manual</a>
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
        <div x-show="tab === 'users'" class="tab-pane" id="users">
            <div class="flex mb-4">
                <div class="w-full p-4">
                    @livewire('settings.user-list')
                </div>
            </div>
        </div>
        <div x-show="tab === 'user-manual'" class="tab-pane">
            <div class="flex mb-4">
                <div class="w-full p-4">
                    @livewire('user-manual.list-user-manual')
                </div>
            </div>
        </div>
    </div>
</div>
