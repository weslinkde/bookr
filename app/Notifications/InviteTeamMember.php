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
    public $url, $team, $member, $newMember, $password;

    /**
     * Create a notification instance.
     *
     * @param  string  $token
     * @return void
     */
    public function __construct($url, $team, $member, $newMember, $password)
    {
        $this->url = $url;
        $this->team = $team;
        $this->member = $member;
        $this->newMember = $newMember;
        $this->password = $password;
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
        if($this->newMember == null) {
            return (new MailMessage)
                ->subject(config('app.name') .' Invitation')
                ->greeting('Hey '. $notifiable->name .',')
                ->line('You have been invited by ' . User::where('id', $this->team->user_id)->first()->name . ' to join ' . $this->team->name . '.')
                ->line('By continuing you will be redirected to the '. config('app.name') .' app.')
                ->action('Join team', url($this->url));
        }
        else {
            return (new MailMessage)
                ->subject(config('app.name') .' Invitation')
                ->greeting('Hey,')
                ->line('You have been invited by ' . User::where('id', $this->team->user_id)->first()->name . ' to join ' . $this->team->name . '.')
                ->line("We have noticed you don't have an account yet, so we have created one for you!")
                ->line("Your new login credentials are: <br> Email: <strong> " . $this->newMember->email . " <br></strong> Password: <strong> ". $this->password . " </strong>")
                ->line('<strong>Please make sure you edit these credentials when you login.</strong>')
                ->action('Join team', url($this->url))
                ->line('By continuing you will be redirected to the '. config('app.name') .' app.');

        }
    }
}
