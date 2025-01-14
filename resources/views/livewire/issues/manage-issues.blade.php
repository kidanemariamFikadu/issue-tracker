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
        <form class="p-4 md:p-5" wire:submit="updateIssue">

            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">Error</strong>
                    <span class="block sm:inline">{{ session('error') }}</span>

                </div>
            @endif
            <div class="grid gap-4 mb-4 grid-cols-2">
                <div class="col-span-2 sm:col-span-1">
                    <label for="application"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Aplication</label>
                    <select id="application" wire:model='application'
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                        <option value="" {{ empty($issue->application_id) ? 'selected' : '' }}>Choose an
                            application</option>
                        @foreach ($applications as $applicationOption)
                            <option value="{{ $applicationOption->id }}"
                                {{ $applicationOption->id == $issue->application_id ? 'selected' : '' }}>
                                {{ $applicationOption->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('application')
                        <span class="text-red-500 text-xs mt-3 block ">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-span-2 sm:col-span-1">
                    <label for="category"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Category</label>
                    <select id="category" wire:model='category' {{ empty($issue->application_id) ? 'selected' : '' }}
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                        <option selected>Choose a category</option>
                        @foreach ($categories as $categoryOption)
                            <option value="{{ $categoryOption->id }}"
                                {{ $categoryOption->id == $issue->category_id ? 'selected' : '' }}>
                                {{ $categoryOption->name }}</option>
                        @endforeach
                    </select>
                    @error('category')
                        <span class="text-red-500 text-xs mt-3 block ">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-span-2 sm:col-span-1">
                    <label for="priority"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Priority</label>
                    <select id="priority" wire:model='priority'
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                        <option selected>Choose a priority</option>
                        <option value="Not set" {{ $issue->priority == 'Not set' ? 'selected' : '' }}>Not set</option>
                        <option value="Low" {{ $issue->priority == 'Low' ? 'selected' : '' }}>Low</option>
                        <option value="Medium" {{ $issue->priority == 'Medium' ? 'selected' : '' }}>Medium</option>
                        <option value="High" {{ $issue->priority == 'High' ? 'selected' : '' }}>High</option>
                    </select>
                    @error('priority')
                        <span class="text-red-500 text-xs mt-3 block ">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-span-2 sm:col-span-1">
                    <label for="status"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status</label>
                    <select id="status" wire:model='status' {{ empty($issue->application_id) ? 'selected' : '' }}
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                        <option selected>Choose a status</option>
                        <option value="Open" {{ $issue->status == 'Open' ? 'selected' : '' }}>Open</option>
                        <option value="In Progress" {{ $issue->status == 'In Progress' ? 'selected' : '' }}>In
                            Progress</option>
                        <option value="Resolved" {{ $issue->status == 'Resolved' ? 'selected' : '' }}>Resolved</option>
                        <option value="Closed" {{ $issue->status == 'Closed' ? 'selected' : '' }}>Closed</option>
                    </select>
                    @error('status')
                        <span class="text-red-500 text-xs mt-3 block ">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-span-2 sm:col-span-2">
                    <label for="issue"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Issue</label>
                    <input type="text" name="issue" id="issue" wire:model='issue' value="{{ $issue->issue }}"
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
                        placeholder="Enter description" rows="4">{{ $issue->description }}</textarea>
                    @error('description')
                        <span class="text-red-500 text-xs mt-3 block ">{{ $message }}</span>
                    @enderror
                </div>
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
