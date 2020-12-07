<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Provider;


class VerifyProvider extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Provider $provider){
      $this->provider = $provider;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
     public function toMail($notifiable)
     {
       $verification = $this->provider->verification()->first();
         return (new MailMessage)
         ->greeting('Hello '.$this->provider->name.'!')
         ->line('You recently registered to our application using this email address as a Provider.')
         ->line('Please complete the verification process by clicking on the button below.')
         ->action('Verify Registeration', url('/providers/verify?id='.$verification->provider_id.'&token='.$verification->token))
         ->line('In case you did not register to the application, no further actions are necessary.')
         ->line('Thank you for using our application!');
     }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
