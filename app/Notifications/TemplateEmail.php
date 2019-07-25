<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class TemplateEmail extends Notification
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
        ->subject('Wildfoods') // it will use this class name if you don't specify
       // ->greeting('') // example: Dear Sir, Hello Madam, etc ...
        ->level('info')// It is kind of email. Available options: info, success, error. Default: info
        ->line('ID Pedido: 1234567890ASDF')
        ->action('Ver pedido', url('/'))
        ->line('Gracias por realizar su pedido')
        ->line('Felipe')
        ->salutation('gerente comercial Wildfoods');  // example: best regards, thanks, etc ...


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
