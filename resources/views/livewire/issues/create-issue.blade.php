<div>
    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
        <!-- Modal header -->
        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                Add Issue
            </h3>
            <button type="button" wire:click="closeModal"
                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                data-modal-toggle="crud-modal">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="https://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
                <span class="sr-only">Close modal</span>
            </button>
        </div>
        <!-- Modal body -->
        <form class="p-4 md:p-5" wire:submit="createIssue">

            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">Error</strong>
                    <span class="block sm:inline">{{ session('error') }}</span>

                </div>
            @endif
            <div class="grid gap-4 mb-4 grid-cols-2">
                <div class="col-span-2 sm:col-span-2">
                    <label for="application"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Aplication</label>
                    <select id="application" wire:model='application'
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                        <option selected>Choose a application</option>
                        @foreach ($applications as $application)
                            <option value="{{ $application->id }}">{{ $application->name }}</option>
                        @endforeach
                    </select>
                    @error('application')
                        <span class="text-red-500 text-xs mt-3 block ">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-span-2 sm:col-span-2">
                    <label for="agent"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Agent</label>
                    <select id="agent" wire:model='agentId'
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                        <option selected>Choose an agent (optional)</option>
                        @foreach ($agents as $agent)
                            <option value="{{ $agent->id }}">
                                {{ $agent->first_name . ' ' . $agent->last_name . ' (' . $agent->phone . ')' }}</option>
                        @endforeach
                    </select>
                    @error('agent')
                        <span class="text-red-500 text-xs mt-3 block ">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-span-2 sm:col-span-2">
                    <label for="issue"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Issue</label>
                    <input type="text" name="issue" id="issue" wire:model='issue'
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        placeholder="Enter issue">
                    @error('issue')
                        <span class="text-red-500 text-xs mt-3 block ">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-span-2 sm:col-span-2">
                    <label for="description"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label>
                    <textarea name="description" id="description" wire:model='description'
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        placeholder="Enter description" rows="4"></textarea>
                    @error('description')
                        <span class="text-red-500 text-xs mt-3 block ">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Attachments -->
                <div class="mb-4">
                    <label for="attachments"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Attachments</label>
                    <input type="file" id="attachments" wire:model="attachments" accept="image/*,video/*" multiple
                        class="mt-1 block w-full text-sm text-gray-500 dark:text-gray-300 file:mr-4 file:py-2 file:px-4 file:border-0 file:rounded-full file:text-sm file:bg-primary-50 file:text-primary-700 dark:file:bg-gray-700 dark:file:text-gray-300 hover:file:bg-primary-100 dark:hover:file:bg-gray-600">
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
                            @endif
                        @endforeach
                    </div>
                @endif


            </div>
            <button type="submit" wire:loading.attr="disabled"
                class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                <svg class="h-5 w-5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z" />
                    <polyline points="17 21 17 13 7 13 7 21" />
                    <polyline points="7 3 7 8 15 8" />
                </svg>
                Save
            </button>
        </form>
    </div>
</div>
