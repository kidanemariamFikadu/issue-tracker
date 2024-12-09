<div x-data="{ open: false }">
    <div :class="open ? 'translate-x-0' : 'translate-x-full'"
        class="fixed top-0 right-0 h-full w-64 bg-white shadow-lg transform transition-transform duration-300 ease-in-out z-50">
        <div class="p-4 flex justify-between items-center bg-blue-500 text-white">
            <h2 class="text-lg font-bold">Notifications</h2>
            <button @click="open = false" class="text-xl font-semibold">&times;</button>
        </div>
        <div class="p-4 space-y-4">
            <p class="text-gray-600">You have 3 new messages.</p>
            <p class="text-gray-600">Your subscription expires in 5 days.</p>
            <p class="text-gray-600">Reminder: Meeting at 3 PM.</p>
        </div>
    </div>
</div>
