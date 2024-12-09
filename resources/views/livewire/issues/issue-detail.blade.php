<div
    class="max-w-4xl mx-auto bg-white border border-gray-200 rounded-lg shadow-md dark:bg-gray-800 dark:border-gray-700 p-6">
    <!-- Issue Details Section -->
    <div class="mb-6">
        <button onclick="window.location.href='{{ route('issues') }}'"
            class="px-4 py-2 bg-gray-200 text-blue-600 text-sm font-medium rounded-lg hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-200">
            <svg class="w-6 h-6 text-gray-800 dark:text-blue-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M5 12h14M5 12l4-4m-4 4 4 4" />
            </svg>
        </button>
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Issue Details</h2>
            <div>
            @role('admin')
                @if ($issue->status != 'Closed' && $issue->status != 'Resolved')
                <button
                    wire:click="$dispatch('openModal', { component: 'issues.assign-issue', arguments: { issueId: {{ $issue->id }} }})"
                    class="px-4 py-2 border border-blue-600 text-blue-600 text-sm font-medium rounded-lg hover:bg-blue-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Assign Issue
                </button>
                @endif
            @endrole
            @role('admin|dev')
                <button
                wire:click="$dispatch('openModal', { component: 'issues.manage-issues', arguments: { issueId: {{ $issue->id }} }})"
                class="px-4 py-2 border border-blue-600 text-blue-600 text-sm font-medium rounded-lg hover:bg-blue-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                Manage Issue
                </button>
            @endrole
            @if ($issue->status != 'Closed' && $issue->status != 'Resolved' && auth()->user()->id == $issue->created_by)
                <button
                wire:click="$dispatch('openModal', { component: 'issues.create-issue', arguments: { issueId: {{ $issue->id }} }})"
                class="px-4 py-2 border border-blue-600 text-blue-600 text-sm font-medium rounded-lg hover:bg-blue-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                Edit Issue
                </button>
            @endif
            </div>
        </div>
        <div class="mt-4">
            <table class="w-full mt-2 text-sm text-gray-700 dark:text-gray-300">
                <tr class="px-4 py-3">
                    <td class="font-medium">Application:</td>
                    <td>{{ $issue->application?->name }}</td>
                </tr>
                <tr class="px-4 py-3">
                    <td class="font-medium">Category:</td>
                    <td>{{ $issue->category_id ? $issue->category->name : 'Category not selected' }}</td>
                </tr>
                <tr class="px-4 py-3">
                    <td class="font-medium">Issue:</td>
                    <td>{{ $issue->issue }}</td>
                </tr>
                <tr class="px-4 py-3">
                    <td class="font-medium">Description:</td>
                    <td>{{ $issue->description }}</td>
                </tr>
                <tr class="px-4 py-3">
                    <td class="font-medium">Status:</td>
                    <td>
                        <span
                            class="px-2 py-1 rounded-lg {{ $issue->status === 'Open' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ $issue->status }}
                        </span>
                    </td>
                </tr>
                <tr class="px-4 py-3">
                    <td class="font-medium">Priority:</td>
                    <td>
                        <span
                            class="px-2 py-1 rounded-lg {{ $issue->priority === 'Low' ? 'bg-blue-100 text-blue-700' : ($issue->priority === 'Medium' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
                            {{ $issue->priority }}
                        </span>
                    </td>
                </tr>
                <tr class="px-4 py-3">
                    <td class="font-medium">Created By:</td>
                    <td>{{ $issue->createdBy ? $issue->createdBy->name : 'Guest' }}</td>
                </tr>
                <tr class="px-4 py-3">
                    <td class="font-medium">Created At:</td>
                    <td>{{ $issue->created_at->format('F j, Y g:i A') }}</td>
                </tr>
                <tr class="px-4 py-3">
                    <td class="font-medium">Assigned To:</td>
                    <td>{{ $issue->assignedTo ? $issue->assignedTo->name : 'Not Assigned' }}</td>
                </tr>
            </table>
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

        <!-- Media Modal -->
        <div id="mediaModal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black bg-opacity-75"
            onclick="closeMediaModal()">
            <div class="relative" onclick="event.stopPropagation();">
                <img id="modalImage" src="" alt="Attachment" class="max-w-full max-h-full">
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
                        <div class="flex items-center">
                            <svg class="w-4 h-4 text-gray-900 dark:text-white mr-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                            </svg>
                            <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $comment->createdBy?->name }}</p>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $comment->created_at->diffForHumans() }}</p>
                    </div>
                    <p class="text-sm text-gray-700 dark:text-gray-300">{{ $comment->comment }}</p>
                    @if ($comment->attachments->isNotEmpty())
                        <div class="mt-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Attachments</h3>
                            <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                                @foreach ($comment->attachments as $attachment)
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
                                        @else
                                            <div class="relative">
                                                <div class="w-24 h-24 flex items-center justify-center bg-gray-200 rounded-lg cursor-pointer"
                                                    onclick="window.location.href='{{ asset('storage/' . $attachment->url) }}'">
                                                    <svg class="w-6 h-6 text-gray-800 dark:text-white"
                                                        aria-hidden="true" xmlns="https://www.w3.org/2000/svg"
                                                        width="24" height="24" fill="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path
                                                            d="M6 16v-3h.375a.626.626 0 0 1 .625.626v1.749a.626.626 0 0 1-.626.625H6Zm6-2.5a.5.5 0 1 1 1 0v2a.5.5 0 0 1-1 0v-2Z" />
                                                        <path fill-rule="evenodd"
                                                            d="M11 7V2h7a2 2 0 0 1 2 2v5h1a1 1 0 0 1 1 1v9a1 1 0 0 1-1 1h-1a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2H3a1 1 0 0 1-1-1v-9a1 1 0 0 1 1-1h6a2 2 0 0 0 2-2Zm7.683 6.006 1.335-.024-.037-2-1.327.024a2.647 2.647 0 0 0-2.636 2.647v1.706a2.647 2.647 0 0 0 2.647 2.647H20v-2h-1.335a.647.647 0 0 1-.647-.647v-1.706a.647.647 0 0 1 .647-.647h.018ZM5 11a1 1 0 0 0-1 1v5a1 1 0 0 0 1 1h1.376A2.626 2.626 0 0 0 9 15.375v-1.75A2.626 2.626 0 0 0 6.375 11H5Zm7.5 0a2.5 2.5 0 0 0-2.5 2.5v2a2.5 2.5 0 0 0 5 0v-2a2.5 2.5 0 0 0-2.5-2.5Z"
                                                            clip-rule="evenodd" />
                                                        <path
                                                            d="M9 7V2.221a2 2 0 0 0-.5.365L4.586 6.5a2 2 0 0 0-.365.5H9Z" />
                                                    </svg>
                                                </div>
                                                <a href="{{ asset('storage/' . $attachment->url) }}" download
                                                    class="absolute inset-0"></a>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            @empty
                <p class="text-sm text-gray-500 dark:text-gray-400">No comments yet.</p>
            @endforelse
        </div>

        <!-- Add Comment Section -->
        @if ($issue->status != 'Closed' && $issue->status != 'Resolved')
            <div class="mt-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Add a Comment</h3>
                <form wire:submit.prevent="addComment" class="mt-4">
                    <textarea wire:model="newComment" rows="3"
                        class="block w-full p-2.5 text-sm bg-gray-50 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                        placeholder="Write your comment..."></textarea>
                    @error('newComment')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror

                    <!-- Attachments -->
                    <div class="mb-4">
                        <label for="attachments"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Attachments</label>
                        <input type="file" id="attachments" wire:model="attachments" multiple
                            class="mt-1 block w-full text-sm text-gray-500 dark:text-gray-300 file:mr-4 file:py-2 file:px-4 file:border-0 file:rounded-full file:text-sm file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100">
                        @error('attachments.*')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Preview Section -->
                    {{-- {{ count($uploadedImages) }} --}}
                    @if (!empty($uploadedImages) && count($uploadedImages) > 0)
                        <div class="mt-4 flex flex-wrap gap-4">
                            @foreach ($uploadedImages as $index => $image)
                                @php
                                    $mimeType = explode('/', $image->getMimeType());
                                @endphp
                                @if (str_starts_with($mimeType[0], 'image'))
                                    <div class="relative">
                                        <img src="{{ $image->temporaryUrl() }}" alt="Preview"
                                            class="w-24 h-24 object-cover rounded-lg">
                                        <button type="button" wire:click="removeAttachment({{ $index }})"
                                            class="absolute top-0 right-0 bg-red-500 text-white rounded-full p-1 text-xs hover:bg-red-600">
                                            ✕
                                        </button>
                                    </div>
                                @elseif(str_starts_with($mimeType[0], 'video'))
                                    <div class="relative">
                                        <video src="{{ $image->temporaryUrl() }}" alt="Preview"
                                            class="w-24 h-24 object-cover rounded-lg" controls>
                                        </video>
                                        <button type="button" wire:click="removeAttachment({{ $index }})"
                                            class="absolute top-0 right-0 bg-red-500 text-white rounded-full p-1 text-xs hover:bg-red-600">
                                            ✕
                                        </button>
                                    </div>
                                @else
                                    <div class="relative">
                                        <div class="w-24 h-24 flex items-center justify-center bg-gray-200 rounded-lg">
                                            <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                                xmlns="https://www.w3.org/2000/svg" width="24" height="24"
                                                fill="currentColor" viewBox="0 0 24 24">
                                                <path
                                                    d="M6 16v-3h.375a.626.626 0 0 1 .625.626v1.749a.626.626 0 0 1-.626.625H6Zm6-2.5a.5.5 0 1 1 1 0v2a.5.5 0 0 1-1 0v-2Z" />
                                                <path fill-rule="evenodd"
                                                    d="M11 7V2h7a2 2 0 0 1 2 2v5h1a1 1 0 0 1 1 1v9a1 1 0 0 1-1 1h-1a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2H3a1 1 0 0 1-1-1v-9a1 1 0 0 1 1-1h6a2 2 0 0 0 2-2Zm7.683 6.006 1.335-.024-.037-2-1.327.024a2.647 2.647 0 0 0-2.636 2.647v1.706a2.647 2.647 0 0 0 2.647 2.647H20v-2h-1.335a.647.647 0 0 1-.647-.647v-1.706a.647.647 0 0 1 .647-.647h.018ZM5 11a1 1 0 0 0-1 1v5a1 1 0 0 0 1 1h1.376A2.626 2.626 0 0 0 9 15.375v-1.75A2.626 2.626 0 0 0 6.375 11H5Zm7.5 0a2.5 2.5 0 0 0-2.5 2.5v2a2.5 2.5 0 0 0 5 0v-2a2.5 2.5 0 0 0-2.5-2.5Z"
                                                    clip-rule="evenodd" />
                                                <path d="M9 7V2.221a2 2 0 0 0-.5.365L4.586 6.5a2 2 0 0 0-.365.5H9Z" />
                                            </svg>

                                        </div>
                                        <p class="text-xs text-gray-700 dark:text-gray-300 mt-1">
                                            {{ $image->getClientOriginalName() }}</p>
                                        <button type="button" wire:click="removeAttachment({{ $index }})"
                                            class="absolute top-0 right-0 bg-red-500 text-white rounded-full p-1 text-xs hover:bg-red-600">
                                            ✕
                                        </button>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endif

                    <button type="submit"
                        class="mt-4 px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        Submit
                    </button>
                </form>
            </div>
        @endif
    </div>
</div>
