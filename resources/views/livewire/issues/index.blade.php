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
            <div class="flex justify-between mb-4">
                <button wire:click="$dispatch('openModal', { component: 'issues.create-issue' })"
                    class="px-3 py-1 bg-teal-500 text-white rounded">+ Add issue</button>
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
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                <div class="flex items-center justify-between d p-4">
                    <div class="flex">
                        <div class="relative w-full">
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
                    <button wire:click="$dispatch('openModal', { component: 'issues.filter-issues' })"
                        class="px-3 py-1 bg-blue-500 text-white rounded">Filter Issues</button>
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
                                    'displayName' => 'RPIORITY',
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
                                                <svg class="h-5 w-5 dark:text-teal-300 text-teal-600" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
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
