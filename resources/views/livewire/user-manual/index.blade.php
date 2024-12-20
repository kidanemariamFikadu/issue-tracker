<div>
    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700 p-4 mr-4">
        <div class="flex flex-col h-screen">
            <!-- Main Content -->
            <div class="flex flex-grow">
                <!-- Sidebar -->
                <div class="manual-list w-1/5 h-full border-r overflow-y-auto">
                    <ul class="list-none p-0">
                        @foreach ($userManuals as $userManual)
                            <li
                                class="manual-item px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 cursor-pointer transition duration-200">
                                <a href="{{ $userManual->url }}" target="manual-frame"
                                    class="block text-gray-700 dark:text-gray-200">
                                    {{ $userManual->title }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Content Area -->
                <div class="manual-content w-4/5 h-4/5 p-5 overflow-y-auto relative">
                    <iframe name="manual-frame" src="" class="w-full h-full border-none"></iframe>
                    <div
                        class="select-message absolute inset-0 flex items-center justify-center bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 hidden">
                        Please select one item
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const iframe = document.querySelector('iframe[name="manual-frame"]');
                const contentArea = document.querySelector('.manual-content');
                const message = contentArea.querySelector('.select-message');
                const listItems = document.querySelectorAll('.manual-item');

                // Function to toggle the visibility of the "Please select one item" message
                function toggleMessage() {
                    if (!iframe.src || iframe.src.endsWith('about:blank')) {
                        message.classList.remove('hidden'); // Show the message
                    } else {
                        message.classList.add('hidden'); // Hide the message
                    }
                }

                // Add click event listeners to all manual list items
                listItems.forEach(item => {
                    item.addEventListener('click', function(e) {
                        e.preventDefault(); // Prevent default link behavior

                        // Update iframe src
                        iframe.src = this.querySelector('a').href;

                        // Remove selection styling from all items
                        listItems.forEach(i => i.classList.remove('bg-blue-600', 'text-white'));

                        // Add selection styling to the current item
                        this.classList.add('bg-blue-600', 'text-white');
                    });
                });

                // Add a load event listener to the iframe to check its content
                iframe.addEventListener('load', toggleMessage);

                // Initial check to show the message if no content is loaded
                toggleMessage();
            });
        </script>

    </div>
</div>
