<div>
    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700 p-4 mr-4">
        <!-- Modal header -->
        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                Users
            </h3>
        </div>
        <!-- Modal body -->
        <div>
            <button wire:click="$dispatch('openModal', { component: 'settings.edit-user' })"
                class="px-3 py-1 bg-teal-500 text-white  mb-4 mt-2">+ Add User</button>
        </div>
        <div class="overflow-x-auto">
            {{-- <button wire:click="deleteSelected"
                @click="if (confirm('Are you sure you want to delete selected records?')) $wire.deleteSelected()"
                class="px-4 py-2 text-sm font-medium text-white bg-red-500 hover:bg-red-300 hover:text-white-700 ">
                Delete Selected </button> --}}
            <table class="w-full text-sm text-left text-gray-700 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        @include('livewire.includes.table-sortable-th', [
                            'name' => 'name',
                            'displayName' => 'Name',
                        ])
                        <th scope="col" class="px-4 py-3">Email</th>
                        <th scope="col" class="px-4 py-3">Role</th>
                        <th scope="col" class="px-4 py-3">
                            <span class="sr-only">Actions</span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr wire:key="{{ $user->id }}" class="border-b dark:border-gray-700">
                            <th scope="row"
                                class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $user->name }}</th>
                            <td class="px-4 py-3">{{ $user->email }}</td>
                            <td class="px-4 py-3">{{ $user->getRoleNames()->implode(', ') }}</td>
                            {{-- <td class="px-4 py-3">{{ $issue->status }}</td> --}}
                            <td class="px-4 py-3 flex items-center justify-end">
                                <button title="edit user"
                                    class="px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-blue-500 dark:focus:text-white"
                                    wire:click="$dispatch('openModal', { component: 'settings.edit-user', arguments: { userId: {{ $user->id }} }})">
                                    <svg class="h-5 w-5 text-teal-500" viewBox="0 0 24 24" stroke-width="2"
                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" />
                                        <path d="M9 7 h-3a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-3" />
                                        <path d="M9 15h3l8.5 -8.5a1.5 1.5 0 0 0 -3 -3l-8.5 8.5v3" />
                                        <line x1="16" y1="5" x2="19" y2="8" />
                                    </svg>
                                </button>
                                <button title="edit user"
                                    class="px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-blue-500 dark:focus:text-white"
                                    wire:click="resetPassword({{$user->id}})">
                                    Reset Password
                                </button>
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
            {{ $users->links() }}
        </div>
    </div>
</div>
