<div class="relative">
    <!-- Notification Bar -->
    <div class="absolute right-0 top-0 w-96 bg-white dark:bg-gray-800 shadow-lg rounded-lg">
        <!-- Header -->
        <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Notifications</h2>
        </div>

        <!-- Tabs -->
        {{-- <div class="flex items-center px-4 py-2 space-x-4 border-b border-gray-200 dark:border-gray-700">
            <button class="text-sm font-medium text-blue-600 dark:text-blue-400 border-b-2 border-blue-600 dark:border-blue-400">View all</button>
            <button class="text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300">Mentions</button>
        </div> --}}

        <!-- Notifications List -->
        <ul class="divide-y divide-gray-200 dark:divide-gray-700 overflow-auto max-h-[66vh]">
            @foreach ($notifications as $notification)
                <li class="px-4 py-3 flex items-start cursor-pointer" wire:click.prevent="markAsReadAndRedirect('{{ $notification['id'] }}', '{{ $notification['data']['url'] }}')">
                    <div>
                        <p class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $notification['data']['title'] }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{!! $notification['data']['message'] !!}</p>
                        <span class="text-xs text-gray-400 dark:text-gray-500">{{ \Carbon\Carbon::parse($notification['created_at'])->format('F j, Y, g:i a') }}</span>
                    </div>
                    @if (is_null($notification['read_at']))
                        <span class="ml-auto h-2 w-2 bg-blue-500 rounded-full" style="border-radius: 50%;"></span>
                    @endif
                </li>
            @endforeach
        </ul>

        <!-- Footer -->
        <div class="px-4 py-3 flex justify-between items-center border-t border-gray-200 dark:border-gray-700">
            <button wire:click="markAllAsRead" class="text-sm font-medium text-blue-600 dark:text-blue-400 hover:underline">Mark all as read</button>
            <a href="{{ route('notifications') }}" class="text-sm font-medium text-blue-600 dark:text-blue-400 hover:underline">View all notifications</a>
        </div>
    </div>
</div>
