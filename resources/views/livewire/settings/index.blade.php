<div>
    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 mb-3 rounded relative" role="alert">
            <strong class="font-bold">Error</strong>
            <span class="block sm:inline">{{ session('error') }}</span>

        </div>
    @elseif (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 mb-3 rounded relative" role="alert">
            <strong class="font-bold">Success</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif


    <div class="flex mb-4">
        <div class="w-1/2 p-4 mr-4">
            @livewire('settings.application-list')
        </div>
        <div class="w-1/2 p-4">
            @livewire('settings.category-list')
        </div>
    </div>

    <div class="flex mb-4">
        <div class="w-full p-4">
            @livewire('settings.user-list')
        </div>
    </div>
</div>
