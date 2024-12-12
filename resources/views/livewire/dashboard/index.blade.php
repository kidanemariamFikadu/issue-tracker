<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Issue Tracker Dashboard</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-green-100 p-4 rounded shadow">
            <h2 class="text-xl font-semibold mb-2">Open Issues</h2>
            <p class="text-gray-600 text-2xl font-bold">{{ $weeklyIssueStat->open }}</p>
        </div>
        <div class="bg-yellow-100 p-4 rounded shadow">
            <h2 class="text-xl font-semibold mb-2">In Progress</h2>
            <p class="text-gray-600 text-2xl font-bold">{{ $weeklyIssueStat->inprogress }}</p>
        </div>
        <div class="bg-red-100 p-4 rounded shadow">
            <h2 class="text-xl font-semibold mb-2">Closed Issues</h2>
            <p class="text-gray-600 text-2xl font-bold">{{ $weeklyIssueStat->closed }}</p>
        </div>
        <div class="bg-blue-100 p-4 rounded shadow">
            <h2 class="text-xl font-semibold mb-2">Resolved Issues</h2>
            <p class="text-gray-600 text-2xl font-bold">{{ $weeklyIssueStat->resolved }}</p>
        </div>
    </div>

    <section class="mt-10">
        <div >
            
            <!-- Start coding here -->
            <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                <div class="flex items-center justify-between d p-4">
                    <h2 class="text-2xl mb-3 text-gray-900 dark:text-gray-100">Issues List</h2>
                </div>
                <div class="overflow-x-auto">
                    {{-- <button wire:click="deleteSelected"
                        @click="if (confirm('Are you sure you want to delete selected records?')) $wire.deleteSelected()"
                        class="px-4 py-2 text-sm font-medium text-white bg-red-500 hover:bg-red-300 hover:text-white-700 ">
                        Delete Selected </button> --}}
                    <table class="w-full text-sm text-left text-gray-700 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="px-4 py-3">
                                    <span>Issue</span>
                                </th>
                                <th scope="col" class="px-4 py-3">
                                    <span>Application</span>
                                </th>
                                <th scope="col" class="px-4 py-3">
                                    <span>Category</span>
                                </th>
                                <th scope="col" class="px-4 py-3">
                                    <span>Status</span>
                                </th>
                                <th scope="col" class="px-4 py-3">
                                    <span>Priotrity</span>
                                </th>
                                <th scope="col" class="px-4 py-3">
                                    <span>Assigned To</span>
                                </th>
                                <th scope="col" class="px-4 py-3">
                                    <span>Created At</span>
                                </th>
                                <th scope="col" class="px-4 py-3">
                                    <span>Actions</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($recentIssues as $issue)
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
            </div>
        </div>
    </section>
</div>
