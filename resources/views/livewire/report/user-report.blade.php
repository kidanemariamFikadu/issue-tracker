<div class="relative bg-white rounded-lg shadow dark:bg-gray-700 p-4 mr-4">
    <form wire:submit.prevent="generateReport" class="flex items-end space-x-4">
        @if ($period == 'week')
            <div class="flex flex-col">
                <label for="weekDate" class="mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Date:</label>
                <input type="date" id="weekDate" wire:model="weekDate" class="p-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-300">
            </div>
        @elseif ($period == 'month')
            <div class="flex flex-col">
                <label for="month" class="mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Month:</label>
                <select id="month" wire:model="month" class="p-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-300">
                    @foreach (range(1, 12) as $m)
                        <option value="{{ $m }}" {{ $m == date('n') ? 'selected' : '' }}>{{ date('F', mktime(0, 0, 0, $m, 1)) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex flex-col">
                <label for="year" class="mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Year:</label>
                <select id="year" wire:model="monthYear" class="p-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-300">
                    @foreach (range(date('Y') - 10, date('Y')) as $y)
                        <option value="{{ $y }}" {{ $y == date('Y') ? 'selected' : '' }}>{{ $y }}</option>
                    @endforeach
                </select>
            </div>
        @elseif ($period == 'year')
            <div class="flex flex-col">
                <label for="year" class="mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Year:</label>
                <select id="year" wire:model="year" class="p-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-300">
                    @foreach (range(date('Y') - 10, date('Y')) as $y)
                        <option value="{{ $y }}" {{ $y == date('Y') ? 'selected' : '' }}>{{ $y }}</option>
                    @endforeach
                </select>
            </div>
        @endif
        <div class="flex flex-col">
            <label for="period" class="mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Period</label>
            <select id="period" wire:model="period" wire:change="dispatch('periodChanged')" class="p-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-300">
                <option value="week">Week</option>
                <option value="month">Month</option>
                <option value="year">Year</option>
            </select>
        </div>
        <div class="flex flex-col">
            <label for="user" class="mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">User:</label>
            <select id="user" wire:model="user" class="p-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-300">
                <option>Please select User</option>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex flex-col">
            <button type="submit" class="px-4 py-2 text-white bg-blue-500 dark:bg-blue-700 rounded-md hover:bg-blue-600 dark:hover:bg-blue-800">Generate Report</button>
        </div>
    </form>

    
        <div class="mt-6">
            <h2 class="mb-4 text-xl font-semibold text-gray-800 dark:text-gray-200">Report</h2>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-700 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th scope="col" class="px-4 py-3">Period</th>
                            <th scope="col" class="px-4 py-3">Total</th>
                            <th scope="col" class="px-4 py-3">Closed</th>
                            <th scope="col" class="px-4 py-3">Open</th>
                            <th scope="col" class="px-4 py-3">In progress</th>
                            <th scope="col" class="px-4 py-3">Resolved</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (empty($user))
                            <tr>
                                <td colspan="6" class="px-4 py-3 text-center text-gray-500 dark:text-gray-400">Please select a user</td>
                            </tr>
                        @elseif (empty($this->reportData))
                            <tr>
                                <td colspan="6" class="px-4 py-3 text-center text-gray-500 dark:text-gray-400">No data to show</td>
                            </tr>
                        @else
                            @foreach ($this->reportData as $item)
                                <tr class="border-b dark:border-gray-700">
                                    <td scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $item['period'] }}</td>
                                    <td class="px-4 py-3">{{ $item['total'] }}</td>
                                    <td class="px-4 py-3">{{ $item['closed'] }}</td>
                                    <td class="px-4 py-3">{{ $item['open'] }}</td>
                                    <td class="px-4 py-3">{{ $item['in_progress'] }}</td>
                                    <td class="px-4 py-3">{{ $item['resolved'] }}</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        
    @if ($this->reportData)
        <div class="mt-6">
            <h2 class="mb-4 text-xl font-semibold text-gray-800 dark:text-gray-200">Report Chart</h2>
            <canvas id="reportChart" width="400" height="400"></canvas>
        </div>

        <script>
            document.addEventListener('livewire:load', function() {
                var ctx = document.getElementById('reportChart').getContext('2d');
                var reportData = @json($this->reportData);
                var labels = reportData.map(item => item.period);
                var totalData = reportData.map(item => item.total);
                var closedData = reportData.map(item => item.closed);
                var openData = reportData.map(item => item.open);
                var inProgressData = reportData.map(item => item.in_progress);
                var resolvedData = reportData.map(item => item.resolved);

                new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: labels,
                        datasets: [{
                                label: 'Total',
                                data: totalData,
                                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 1
                            },
                            {
                                label: 'Closed',
                                data: closedData,
                                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                borderColor: 'rgba(75, 192, 192, 1)',
                                borderWidth: 1
                            },
                            {
                                label: 'Open',
                                data: openData,
                                backgroundColor: 'rgba(255, 206, 86, 0.2)',
                                borderColor: 'rgba(255, 206, 86, 1)',
                                borderWidth: 1
                            },
                            {
                                label: 'In Progress',
                                data: inProgressData,
                                backgroundColor: 'rgba(153, 102, 255, 0.2)',
                                borderColor: 'rgba(153, 102, 255, 1)',
                                borderWidth: 1
                            },
                            {
                                label: 'Resolved',
                                data: resolvedData,
                                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                borderColor: 'rgba(255, 99, 132, 1)',
                                borderWidth: 1
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                            title: {
                                display: true,
                                text: 'Report Data'
                            }
                        }
                    }
                });
            });
        </script>
    @endif
</div>
