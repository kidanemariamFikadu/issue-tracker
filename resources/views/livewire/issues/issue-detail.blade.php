<div
    class="max-w-4xl mx-auto bg-white border border-gray-200 rounded-lg shadow-md dark:bg-gray-800 dark:border-gray-700 p-6">
    <!-- Issue Details Section -->
    <div class="mb-6">
        <a href="{{ route('issues') }}"
            class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">Back</a>
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Issue Details</h2>
            <div>
                @role('admin')
                    @if ($issue->status != 'Closed')
                        <button
                            wire:click="$dispatch('openModal', { component: 'issues.assign-issue', arguments: { issueId: {{ $issue->id }} }})"
                            class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            Assign Issue
                        </button>
                    @endif
                @endrole
                @role('admin|dev')
                    <button
                        wire:click="$dispatch('openModal', { component: 'issues.manage-issues', arguments: { issueId: {{ $issue->id }} }})"
                        class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        Manage Issue
                    </button>
                @endrole
                @if ($issue->status != 'Closed' && auth()->user()->id == $issue->created_by)
                    <button
                        wire:click="$dispatch('openModal', { component: 'issues.create-issue', arguments: { issueId: {{ $issue->id }} }})"
                        class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        Edit Issue
                    </button>
                @endif
            </div>
        </div>
        <div class="mt-4">
            <p class="mt-2 text-sm text-gray-700 dark:text-gray-300"><span class="font-medium">Application:</span>
                {{ $issue->application?->name }}</p>
            <p class="mt-2 text-sm text-gray-700 dark:text-gray-300"><span class="font-medium">category:</span>
                {{ $issue->category_id ? $issue->category->name : 'Category not selected' }}</p>
            <p class="mt-2 text-sm text-gray-700 dark:text-gray-300"><span class="font-medium">Isseue:</span>
                {{ $issue->issue }}</p>
            <p class="mt-2 text-sm text-gray-700 dark:text-gray-300 mt-2"><span class="font-medium">Description:</span>
            </p>
            <p class="mt-2 text-sm text-gray-700 dark:text-gray-300 mt-1">{{ $issue->description }}</p>
            <p class="mt-2 text-sm text-gray-700 dark:text-gray-300"><span class="font-medium">Application:</span>
                {{ $issue->application?->name }}</p>
            <p class="mt-2 text-sm text-gray-700 dark:text-gray-300 mt-2"><span class="font-medium">Status:</span>
                <span
                    class="px-2 py-1 rounded-lg {{ $issue->status === 'Open' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                    {{ $issue->status }}
                </span>
            </p>
            <p class="mt-2 text-sm text-gray-700 dark:text-gray-300 mt-1"><span class="font-medium">Priority:</span>
                <span
                    class="px-2 py-1 rounded-lg {{ $issue->priority === 'Low' ? 'bg-blue-100 text-blue-700' : ($issue->priority === 'Medium' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
                    {{ $issue->priority }}
                </span>
            <p class="mt-2 text-sm text-gray-700 dark:text-gray-300 mt-2"><span class="font-medium">Created By:</span>
                {{ $issue->createdBy ? $issue->createdBy->name : 'Guest' }}</p>
            <p class="mt-2 text-sm text-gray-700 dark:text-gray-300 mt-1"><span class="font-medium">Created At:</span>
                {{ $issue->created_at->format('F j, Y g:i A') }}</p>
            <p class="mt-2 text-sm text-gray-700 dark:text-gray-300 mt-1"><span class="font-medium">Assigned To:</span>
                {{ $issue->assignedTo ? $issue->assignedTo->name : 'Not Assigned' }}</p>
        </div>

        <!-- Attachments Section -->
        @if ($issue->attachments->isNotEmpty())
            <div class="mt-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Attachments</h3>
                <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                    @foreach ($issue->attachments as $attachment)
                        <div class="border border-gray-200 rounded-lg overflow-hidden">
                            @if (in_array(pathinfo($attachment->url, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif']))
                                <img src="{{ asset('storage/' . $attachment->url) }}" alt="Attachment"
                                    class="w-full h-48 object-cover cursor-pointer"
                                    onclick="openMediaModal('{{ asset('storage/' . $attachment->url) }}', 'image')">
                            @elseif (in_array(pathinfo($attachment->url, PATHINFO_EXTENSION), ['mp4', 'webm', 'ogg']))
                                <video controls class="w-full h-48 object-cover cursor-pointer"
                                    onclick="openMediaModal('{{ asset('storage/' . $attachment->url) }}', 'video')">
                                    <source src="{{ asset('storage/' . $attachment->url) }}"
                                        type="video/{{ pathinfo($attachment->url, PATHINFO_EXTENSION) }}">
                                    Your browser does not support the video tag.
                                </video>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <script>
            function openMediaModal(url, type) {
                const modal = document.getElementById('mediaModal');
                const modalImage = document.getElementById('modalImage');
                const modalVideo = document.getElementById('modalVideo');

                // Reset the visibility of both elements
                modalImage.classList.add('hidden');
                modalVideo.classList.add('hidden');

                if (type === 'image') {
                    modalImage.src = url;
                    modalImage.classList.remove('hidden');
                } else if (type === 'video') {
                    modalVideo.src = url;
                    modalVideo.classList.remove('hidden');
                }

                modal.classList.remove('hidden');
            }

            function closeMediaModal() {
                const modal = document.getElementById('mediaModal');
                const modalImage = document.getElementById('modalImage');
                const modalVideo = document.getElementById('modalVideo');

                // Clear the content to avoid unnecessary data loading
                modalImage.src = '';
                modalVideo.src = '';

                modal.classList.add('hidden');
            }
        </script>


        <!-- Image Modal -->
        <div id="imageModal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black bg-opacity-75"
            onclick="closeImageModal()">
            <div class="relative" onclick="event.stopPropagation();">
                <img id="modalImage" src="" alt="Attachment" class="max-w-full max-h-full">
                <button onclick="closeImageModal()"
                    class="absolute top-0 right-0 mt-2 mr-2 text-white text-2xl">&times;</button>
            </div>
        </div>

        <!-- Media Modal -->
        <div id="mediaModal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black bg-opacity-75"
            onclick="closeMediaModal()">
            <div class="relative" onclick="event.stopPropagation();">
                <video id="modalVideo" controls class="max-w-full max-h-full hidden">
                    <source src="" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
            <button onclick="closeMediaModal()"
                class="absolute top-0 right-0 mt-4 mr-4 text-white text-2xl">&times;</button>
        </div>
    </div>

    <!-- Comments Section -->
    <div>
        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Comments</h2>
        <div class="mt-4 space-y-4">
            @forelse ($issue->comments as $comment)
                <div class="p-4 border border-gray-200 rounded-lg bg-gray-50 dark:bg-gray-700 dark:border-gray-600">
                    <div class="flex justify-between items-center mb-2">
                        <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $comment->createdBy?->name }}
                        </p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $comment->created_at->diffForHumans() }}
                        </p>
                    </div>
                    <p class="text-sm text-gray-700 dark:text-gray-300">{{ $comment->comment }}</p>
                </div>
            @empty
                <p class="text-sm text-gray-500 dark:text-gray-400">No comments yet.</p>
            @endforelse
        </div>

        <!-- Add Comment Section -->
        @if ($issue->status != 'Closed')
            <div class="mt-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-black">Add a Comment</h3>
                <form wire:submit.prevent="addComment" class="mt-4">
                    <textarea wire:model="newComment" rows="3"
                        class="block w-full p-2.5 text-sm bg-gray-50 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                        placeholder="Write your comment..."></textarea>
                    @error('newComment')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                    <button type="submit"
                        class="mt-4 px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        Submit
                    </button>
                </form>
            </div>
        @endif
    </div>
</div>
