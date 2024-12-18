<?php

namespace App\Notifications\Issue;

use App\Models\IssueReport;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class IssueAssignedToYou extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */

    private IssueReport $issueReport;
    public function __construct($issueReport)
    {
        $this->issueReport = $issueReport;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('You have been assigned a new issue.')
            ->line('You have been assigned new issue.')
            ->line('Issue: ' . $this->issueReport->issue)
            ->line('Assigned at: ' . $this->issueReport->updated_at?->format('Y-m-d H:i:s'))
            ->action('View Issue', route('issue-detail', ['issue' => $this->issueReport->id]));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            
        ];
    }
}
