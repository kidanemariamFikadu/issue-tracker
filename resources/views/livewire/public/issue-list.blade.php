<div>
    <div class="flex justify-between items-center mb-4">
        <div>
            <input 
                type="text" 
                wire:model="search" 
                placeholder="Search issues..." 
                class="border p-2 rounded"
            />
        </div>
        <div>
            {{-- <a href="{{ route('issues.create-issue') }}" class="bg-blue-500 text-white px-4 py-2 rounded">
                Add New Issue
            </a> --}}
            @guest
            <a href="{{ route('login') }}" class="bg-gray-500 text-white px-4 py-2 rounded ml-2">
                Login
            </a>
            @endguest
        </div>
    </div>

    <table class="w-full border-collapse">
        <thead>
            <tr>
                <th class="border px-4 py-2">#</th>
                <th class="border px-4 py-2">Title</th>
                <th class="border px-4 py-2">Description</th>
                <th class="border px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($issues as $issue)
                <tr>
                    <td class="border px-4 py-2">{{ $issue->id }}</td>
                    <td class="border px-4 py-2">{{ $issue->title }}</td>
                    <td class="border px-4 py-2">{{ $issue->description }}</td>
                    <td class="border px-4 py-2">
                        {{-- <a href="{{ route('issues.edit', $issue) }}" class="text-blue-500">Edit</a>
                        <button wire:click="delete({{ $issue->id }})" class="text-red-500">Delete</button> --}}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="border px-4 py-2 text-center">No issues found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{ $issues->links() }}
    </div>
</div>
