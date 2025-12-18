<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserCreatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $user;
    protected $password;

    /**
     * Create a new notification instance.
     */
    public function __construct($user, $password)
    {
        $this->user = $user;
        $this->password = $password;
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
            ->subject('Welcome to the System - Account Created')
            ->greeting('Hello ' . $this->user->name . '!')
            ->line('Your account has been successfully created in our system.')
            ->line('**Account Details:**')
            ->line('Email: ' . $this->user->email)
            ->line('Role: ' . ucfirst($this->user->role))
            ->line('Temporary Password: ' . $this->password)
            ->action('Login to Your Account', url('/login'))
            ->line('Please change your password after first login for security purposes.')
            ->line('Thank you for joining our platform!')
            ->salutation('Best regards, System Administrator');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'user_id' => $this->user->id,
            'user_name' => $this->user->name,
            'user_email' => $this->user->email,
            'user_role' => $this->user->role,
        ];
    }
}
