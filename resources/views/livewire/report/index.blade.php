{{-- <div>
   @php print_r($data) @endphp
</div> --}}
<div>
    <form wire:submit.prevent="generateReport">
        <div>
            <label for="start_date">Start Date:</label>
            <input type="date" id="start_date" wire:model="start_date">
        </div>
        <div>
            <label for="end_date">End Date:</label>
            <input type="date" id="end_date" wire:model="end_date">
        </div>
        <div>
            <button type="submit">Generate Report</button>
        </div>
    </form>
</div>

@if($data)
    <div>
        <h2>Report</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Date</th>
                    <th>Details</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->date }}</td>
                        <td>{{ $item->details }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif
