<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Provider;
use App\Models\Consumer;
// use App\Models\Task;
// use App\Models\Payment;
// use App\Models\Review;

class ReviewedProvider extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Provider $provider, Consumer $consumer)
    {
      $this->provider = $provider;
      $this->consumer = $consumer;
      // $this->task = $task;
      // $this->payment = $payment;
      // $this->review = $review;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
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
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    public function toDatabase(){
      return [
        "type" => "Reviewed Provider",
        "provider_id" => $this->provider->id,
        "consumer_id" => $this->consumer->id,
        // "task_id" => $this->task->id,
        // "payment_id" => $this->payment->id,
        // "review_id" => $this->review->id
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
