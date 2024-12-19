<div class="h-screen">
    <div class="flex flex-col h-screen">
        <!-- Main Content -->
        <div class="flex flex-grow">
            <!-- Sidebar -->
            <div class="manual-list w-1/5 h-full border-r overflow-y-auto">
                <ul class="list-group">
                    @foreach ($userManuals as $userManual)
                    <li class="list-group-item">
                        <a href="{{$userManual->url}}" target="manual-frame" class="manual-link">
                            {{ $userManual->title }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>

            <!-- Content Area -->
            <div class="manual-content w-4/5 h-4/5 p-5 overflow-y-auto relative">
                <iframe name="manual-frame" src="" class="w-full h-full border-none"></iframe>
                <div class="select-message absolute inset-0 flex items-center justify-center bg-gray-100 text-gray-600">
                    Select one
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const iframe = document.querySelector('iframe[name="manual-frame"]');
            const contentArea = document.querySelector('.manual-content');
            const message = contentArea.querySelector('.select-message');

            function toggleMessage() {
                if (!iframe.src || iframe.src === 'about:blank') {
                    message.classList.remove('hidden');
                } else {
                    message.classList.add('hidden');
                }
            }

            document.querySelectorAll('.manual-list a').forEach(link => {
                link.addEventListener('click', function (e) {
                    e.preventDefault(); // Prevent default behavior to control iframe loading.
                    iframe.src = this.href; // Update the iframe src.
                });
            });

            iframe.addEventListener('load', toggleMessage);

            // Initial check to show the message if no content is loaded.
            toggleMessage();
        });
    </script>

    <style>
        .select-message.hidden {
            display: none;
        }
    </style>
</div>
