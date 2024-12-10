<div
    class="max-w-4xl mx-auto bg-white border border-gray-200 rounded-lg shadow-md dark:bg-gray-800 dark:border-gray-700 p-6">
    @if (count($notifications) <= 0)
        <p class="text-gray-700">No notifications available.</p>
    @else
        <button wire:click="markAllAsRead" class="bg-blue-500 text-white px-4 py-2 rounded mb-4">Mark all as read</button>
        @foreach ($notifications as $notification)
            <a href="#" wire:click.prevent="markAsReadAndRedirect('{{ $notification['id'] }}', '{{ $notification['data']['url'] }}')" class="block notification {{ $notification['read_at'] ? 'bg-gray-200' : 'bg-white' }} shadow-md rounded-lg p-4 mb-4">
                <h2 class="text-xl font-semibold mb-2">{{ $notification['data']['title'] }}</h2>
                <div class="text-gray-700 mb-4">{!! $notification['data']['message'] !!}</div>
                <p class="text-gray-500 text-sm mb-2">{{ \Carbon\Carbon::parse($notification['created_at'])->format('F j, Y, g:i a') }}</p>
                <span class="text-blue-500 hover:underline">Read more</span>
            </a>
        @endforeach
    @endif
</div>
