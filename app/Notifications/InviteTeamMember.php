<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class InviteTeamMember extends Notification
{
    /**
     * The password reset token.
     *
     * @var string
     */
    public $url;
    public $team;

    /**
     * Create a notification instance.
     *
     * @param  string  $token
     * @return void
     */
    public function __construct($url, $team)
    {
        $this->url = $url;
        $this->team = $team;
    }

    /**
     * Get the notification's channels.
     *
     * @param  mixed  $notifiable
     * @return array|string
     */
    public function via($notifiable)
    {
        return [
            'mail'
        ];
    }

    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->greeting('Hey '.$notifiable->name)
            ->line('You have been invited by '.User::where('id', $this->team->user_id)->first()->name.' to join '.$this->team->name.'.')
            ->line('By continuing you will be redirected to the Bookr app.')
            ->action('Join team', url($this->url));
    }
}
