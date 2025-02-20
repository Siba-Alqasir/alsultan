<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BookNotification extends Notification
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
        $this->size = $data['size'];
        $this->pet = $data['pet'];
        $this->services = $data['services'];
        $this->message = $data['message'];
        $this->bookId = $data['id'];
        $this->total_amount = $data['total_amount'];
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
        return (new MailMessage)
            ->view('notifications.book',
                [
                    'admin'=>$notifiable->name,
                    'name' =>  $this->name,
                    'email' =>  $this->email,
                    'phone' =>  $this->phone,
                    'pet_size' =>  $this->size ? $this->size->title : '-',
                    'pet_type' =>  $this->pet->title,
                    'services' =>  $this->services,
                    'total_amount' => $this->total_amount,
                    'bookId' => $this->bookId,
                    'pet_image' => $this->pet->getFirstMediaUrl('image'),
                    'content' =>' <pre>'. $this->message. '</pre>',
                ])
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
