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

    <section class="mt-10">
        <div class="mx-auto max-w-screen-xl px-4 lg:px-12">
            <h2 class="text-2xl mb-3">Issues List</h2>
            <!-- Start coding here -->
            <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                <div class="flex items-center justify-between d p-4">
                    <div class="flex">
                        <div class="relative w-full mr-2">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400"
                                    fill="currentColor" viewbox="0 0 20 20" xmlns="https://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input wire:model.live.debounce.300ms="search" type="text"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2 "
                                placeholder="Search" required="">
                        </div>
                        <button wire:click="$dispatch('openModal', { component: 'issues.filter-issues' })"
                            class="px-3 py-1 bg-gray-200 text-blue-500 rounded"><svg
                                class="w-6 h-6 text-blue-500 dark:text-blue" aria-hidden="true"
                                xmlns="https://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                viewBox="0 0 24 24">
                                <path
                                    d="M5.05 3C3.291 3 2.352 5.024 3.51 6.317l5.422 6.059v4.874c0 .472.227.917.613 1.2l3.069 2.25c1.01.742 2.454.036 2.454-1.2v-7.124l5.422-6.059C21.647 5.024 20.708 3 18.95 3H5.05Z" />
                            </svg></button>
                    </div>
                    {{-- <div class="flex space-x-3">
                        <div class="flex space-x-3 items-center">
                            <label class="w-40 text-sm font-medium text-gray-900 dark:text-gray-300">
                                Application:</label>
                            <select wire:model.live="application"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ">
                                <option value="">All</option>
                                @foreach ($this->applicationList as $application)
                                    <option value="{{ $application->id }}">{{ $application->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div> --}}
                    <div class="flex justify-between mb-4">
                        <button wire:click="$dispatch('openModal', { component: 'issues.create-issue' })"
                            class="px-3 py-1 bg-blue-500 text-white rounded mr-2">+ Add issue</button>
                        <div class="flex space-x-2">
                            <button wire:click="toggleMyIssues"
                                class="px-3 py-1 rounded 
                            {{ $this->myIssues ? 'bg-blue-500 text-white' : 'bg-gray-200 text-black' }}">
                                My Issues
                            </button>

                            @role('dev')
                                <button wire:click="toggleAssignedToMe"
                                    class="px-3 py-1 rounded 
                            {{ $this->assignedToMe ? 'bg-blue-500 text-white' : 'bg-gray-200 text-black' }}">
                                    Assigned to me
                                </button>
                            @endrole

                            @role('admin')
                                <div class="flex flex-col">
                                    <button wire:click="exportIssues"
                                        class="px-3 py-1 rounded bg-gray-200 text-black' }}">
                                        <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                            width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M19 10V4a1 1 0 0 0-1-1H9.914a1 1 0 0 0-.707.293L5.293 7.207A1 1 0 0 0 5 7.914V20a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2M10 3v4a1 1 0 0 1-1 1H5m5 6h9m0 0-2-2m2 2-2 2" />
                                        </svg>
                                    </button>
                                </div>
                            @endrole
                        </div>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    {{-- <button wire:click="deleteSelected"
                        @click="if (confirm('Are you sure you want to delete selected records?')) $wire.deleteSelected()"
                        class="px-4 py-2 text-sm font-medium text-white bg-red-500 hover:bg-red-300 hover:text-white-700 ">
                        Delete Selected </button> --}}
                    <table class="w-full text-sm text-left text-gray-700 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                {{-- <th><input type="checkbox" wire:click="toggleSelectAll" 
                                        {{ count($selectedStudents) === $students->count() ? 'checked' : '' }}></th> --}}
                                @include('livewire.includes.table-sortable-th', [
                                    'name' => 'issue',
                                    'displayName' => 'ISSUE',
                                ])
                                <th scope="col" class="px-4 py-3">Application</th>
                                @include('livewire.includes.table-sortable-th', [
                                    'name' => 'category',
                                    'displayName' => 'CATEGORY',
                                ])
                                @include('livewire.includes.table-sortable-th', [
                                    'name' => 'status',
                                    'displayName' => 'STATUS',
                                ])
                                @include('livewire.includes.table-sortable-th', [
                                    'name' => 'priority',
                                    'displayName' => 'PRIORITY',
                                ])
                                <th scope="col" class="px-4 py-3">Assigned to</th>
                                @include('livewire.includes.table-sortable-th', [
                                    'name' => 'created_at',
                                    'displayName' => 'CREATED AT',
                                ])
                                <th scope="col" class="px-4 py-3">
                                    <span class="sr-only">Actions</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($this->issueList as $issue)
                                <tr wire:key="{{ $issue->id }}" class="border-b dark:border-gray-700">
                                    {{-- <td>
                                        <input type="checkbox" wire:model="selectedStudents"
                                            value="{{ $student->id }}">
                                    </td> --}}
                                    <th scope="row"
                                        class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $issue->issue }}</th>
                                    <td class="px-4 py-3">{{ $issue->application?->name }}</td>
                                    <td class="px-4 py-3">{{ $issue->category?->name }}</td>
                                    <td class="px-4 py-3">
                                        <span
                                            class="px-2 py-1 rounded-full text-xs font-semibold 
                                            {{ $issue->status == 'Open' ? 'bg-green-200 text-green-800' : '' }}
                                            {{ $issue->status == 'Closed' ? 'bg-red-200 text-red-800' : '' }}
                                            {{ $issue->status == 'In Progress' ? 'bg-yellow-200 text-yellow-800' : '' }}
                                            {{ $issue->status == 'Resolved' ? 'bg-red-200 text-red-800' : '' }}">
                                            {{ $issue->status }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span
                                            class="px-2 py-1 rounded-full text-xs font-semibold 
                                            {{ $issue->priority == 'High' ? 'bg-red-200 text-red-800' : '' }}
                                            {{ $issue->priority == 'Medium' ? 'bg-yellow-200 text-yellow-800' : '' }}
                                            {{ $issue->priority == 'Not set' ? 'bg-blue-200 text-blue-800' : '' }}
                                            {{ $issue->priority == 'Low' ? 'bg-green-200 text-green-800' : '' }}">
                                            {{ $issue->priority }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">
                                        {{ $issue->assignedTo ? $issue->assignedTo->name : 'Not Assigned' }}</td>
                                    <td class="px-4 py-3">{{ $issue->created_at->diffForHumans() }}</td>
                                    <td class="px-4 py-3 flex items-center justify-end">
                                        <div class="inline-flex rounded-md shadow-sm" role="group">
                                            <a href="issue-detail/{{ $issue->id }}" title="Show issue details"
                                                class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-800 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-primary-500 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:hover:bg-gray-600 dark:focus:ring-primary-500">
                                                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    fill="currentColor" viewBox="0 0 24 24">
                                                    <path fill-rule="evenodd"
                                                        d="M4.998 7.78C6.729 6.345 9.198 5 12 5c2.802 0 5.27 1.345 7.002 2.78a12.713 12.713 0 0 1 2.096 2.183c.253.344.465.682.618.997.14.286.284.658.284 1.04s-.145.754-.284 1.04a6.6 6.6 0 0 1-.618.997 12.712 12.712 0 0 1-2.096 2.183C17.271 17.655 14.802 19 12 19c-2.802 0-5.27-1.345-7.002-2.78a12.712 12.712 0 0 1-2.096-2.183 6.6 6.6 0 0 1-.618-.997C2.144 12.754 2 12.382 2 12s.145-.754.284-1.04c.153-.315.365-.653.618-.997A12.714 12.714 0 0 1 4.998 7.78ZM12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"
                                                        clip-rule="evenodd" />
                                                </svg>

                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="py-4 px-3">
                    <div class="flex ">
                        <div class="flex space-x-4 items-center mb-3">
                            <label class="w-32 text-sm font-medium text-gray-900 dark:text-gray-300">Per Page</label>
                            <select wire:model.live='perPage'
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ">
                                <option value="5">5</option>
                                <option value="7">7</option>
                                <option value="10">10</option>
                                <option value="20">20</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>
                    </div>
                    {{ $this->issueList->links() }}
                </div>
            </div>
        </div>
    </section>
</div>
