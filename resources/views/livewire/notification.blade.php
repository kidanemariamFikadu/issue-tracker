<div class="container mx-auto p-6">
    <div class="max-w-4xl mx-auto bg-white border border-gray-200 rounded-lg shadow-md dark:bg-gray-800 dark:border-gray-700 p-6 overflow-y-auto">
        @if (count($notifications) <= 0)
            <p class="text-gray-700">No notifications available.</p>
        @else
            <ul class="divide-y divide-gray-200">
                @foreach ($notifications as $notification)
                    <li class="py-4">
                        <a href="#" wire:click.prevent="markAsReadAndRedirect('{{ $notification['id'] }}', '{{ $notification['data']['url'] }}')" class="flex justify-between items-center {{ $notification['read_at'] ? 'bg-gray-200' : 'bg-white' }} p-4 rounded-lg">
                            <div>
                                <h2 class="text-xl font-semibold">{{ $notification['data']['title'] }}</h2>
                                <div class="text-gray-700">{!! $notification['data']['message'] !!}</div>
                                <p class="text-gray-500 text-sm">{{ \Carbon\Carbon::parse($notification['created_at'])->format('F j, Y, g:i a') }}</p>
                            </div>
                        </a>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
    <div class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 p-4 shadow-md dark:bg-gray-800 dark:border-gray-700">
        <button wire:click="markAllAsRead" class="bg-blue-500 text-white px-4 py-2 rounded mt-4">Mark all as read</button>
    </div>
</div>
