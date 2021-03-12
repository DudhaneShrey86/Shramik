<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RejectedApplication extends Notification
{
  use Queueable;

  /**
  * Create a new notification instance.
  *
  * @return void
  */
  public function __construct()
  {
    //
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
  public function toMail($notifiable)
  {
    return (new MailMessage)
    ->greeting('Hello '.$notifiable->name)
    ->line('We are sorry to tell you that your account was rejected by our admins.')
    ->line('This means you will no longer be seen in our search list until you update your documents')
    ->line('You can go through our guidelines on how to rank high in our search list')
    ->line('If you genuinely think this was a mistake, please kindly resubmit your documents')
    ->line('Keep trying! You will succeed');
  }

  //////////////change text of db notification here/////////////////
  public function toDatabase(){
    return [
      "type" => "Rejected Application",
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
