<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ContactUsNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->name = $data['name'];
        $this->email = $data['email'];
        $this->phone = $data['phone'];
        $this->pet_size = $data['pet_size'];
        $this->pet_type = $data['pet_type'];
        $this->pet_gender = $data['pet_gender'];
        $this->message = $data['message'];
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->view('notifications.contact',
                [
                    'admin'=>$notifiable->name,
                    'name' =>  $this->name,
                    'email' =>  $this->email,
                    'phone' =>  $this->phone,
                    'pet_size' =>  $this->pet_size,
                    'pet_type' =>  $this->pet_type,
                    'pet_gender' =>  $this->pet_gender,
                    'content' =>' <pre>'. $this->message. '</pre>',
                ])
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
