<?php

namespace App\Notifications\Issue;

use App\Models\IssueReport;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class IssueCommentedNotification extends Notification
{
    use Queueable;

    protected IssueReport $issue;

    /**
     * Create a new notification instance.
     */
    public function __construct($issue)
    {
        $this->issue = $issue;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'New Comment Added',
            'message' =>
            "A new comment has been added to the issue titled <b>{$this->issue->issue}</b> by {$this->issue->comments->last()->createdBy->name} on {$this->issue->application->name}.",
            'url' => route('issue-detail', ['issue' => $this->issue->id]),
        ];
    }
}
