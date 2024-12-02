<?php

namespace App\Notifications;

use App\Models\IssueReport;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class IssueResolvedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private IssueReport $issueReport;

    /**
     * Create a new notification instance.
     */
    public function __construct(IssueReport $issueReport)
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
            ->subject('Issue Resolved')
            ->line('The issue you reported has been resolved.')
            ->line('Issue: ' . $this->issueReport->issue)
            ->line('Resolved at: ' . $this->issueReport->updated_at?->format('Y-m-d H:i:s'))
            ->line('Thank you for your patience.')
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
            //
        ];
    }
}
