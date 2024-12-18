<div class="flex flex-col h-screen">

     <!-- Main Content -->
     <div class="flex flex-grow">
        <!-- Sidebar -->
        <div class="manual-list w-1/5 border-r overflow-y-auto">
            <ul class="list-group">
                @foreach ($userManuals as $userManual)
                <li class="list-group-item">
                    <a href="{{$userManual->url}}" target="manual-frame">
                        {{ $userManual->title }}
                    </a>
                </li>
                @endforeach
            </ul>
        </div>

        <!-- Content Area -->
        <div class="manual-content w-4/5 p-5 overflow-y-auto">
            <iframe name="manual-frame" src="" class="w-full h-full border-none"></iframe>
        </div>
</div>
