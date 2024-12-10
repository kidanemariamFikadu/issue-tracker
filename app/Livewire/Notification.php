<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class Notification extends Component
{

    function markAsRead($notificationId)
    {
        $notification = Auth::user()->notifications->where('id', $notificationId)->first();
        if ($notification) {
            $notification->markAsRead();
        }
        $this->dispatch('notification-read');
    }

    function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        $this->dispatch('notification-read');
    }

    #[On('notification-read')]
    public function notificationRead()
    {
        
    }

    function markAsReadAndRedirect($notificationId, $redirectUrl)
    {
        $notification = Auth::user()->notifications->where('id', $notificationId)->first();
        if ($notification) {
            $notification->markAsRead();
        }
        $this->dispatch('notification-read');
        return redirect($redirectUrl);
    }
    
    public function render()
    {
        return view('livewire.notification', [
            'notifications' => Auth::user()->notifications->toArray(),
        ]);
    }
}
