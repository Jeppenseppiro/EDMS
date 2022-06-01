<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\HtmlString;

class SendRequestEntry extends Notification
{
    use Queueable;
    private $requestEntryRequestor;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($requestEntryEmail)
    {
        $this->requestEntryEmail = $requestEntryEmail;
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
                    ->subject("Request Entry: ".$this->requestEntryEmail['dicr_no'])

                    ->line(new HtmlString
                        ("Request Entry: <b>".$this->requestEntryEmail['dicr_no']."</b>"))
                    ->line(new HtmlString
                        ("Tag: <b>".$this->requestEntryEmail['tag']."</b><br> 
                          DICR No: <b>".$this->requestEntryEmail['dicr_no']."</b><br> 
                          Title: <b>".$this->requestEntryEmail['title']."</b><br>
                          Request Type: <b>".$this->requestEntryEmail['type']."</b><br>
                          Status: <b>".$this->requestEntryEmail['status']."</b><br> 
                          Remarks: <b>".$this->requestEntryEmail['remarks']."</b>
                        "));

                    /* ->line("DICR No: ".$this->requestEntryEmail['dicr_no'])
                    ->line("Title: ".$this->requestEntryEmail['title'])
                    ->line("Status: ".$this->requestEntryEmail['status'])
                    ->line("Remarks: ".$this->requestEntryEmail['remarks']); */
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