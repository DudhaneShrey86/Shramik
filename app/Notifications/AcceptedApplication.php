<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AcceptedApplication extends Notification
{
  use Queueable;

  /**
  * Create a new notification instance.
  *
  * @return void
  */
  public function __construct()
  {

  }

  /**
  * Get the notification's delivery channels.
  *
  * @param  mixed  $notifiable
  * @return array
  */
  public function via($notifiable)
  {
    // return ['mail', 'database'];
    return ['database'];
  }

  /**
  * Get the mail representation of the notification.
  *
  * @param  mixed  $notifiable
  * @return \Illuminate\Notifications\Messages\MailMessage
  */
  public function toMail($notifiable){
    return (new MailMessage)
    ->greeting('Greetings '.$notifiable->name.'!')
    ->line('We are glad to inform you that your account was approved by the admins!')
    ->line('Getting an approved account is an important factor for ranking higher in searches and thus getting more opportunities to grow.')
    ->line('You can go through our guidelines on how to rank high in our search list')
    ->line('We wish you all the best for your future!')
    ->line('Thank you for using our application!');
  }

  //////////////change text of db notification here/////////////////
  public function toDatabase(){
    return [
      "type" => "Accepted Application",
    ];
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
