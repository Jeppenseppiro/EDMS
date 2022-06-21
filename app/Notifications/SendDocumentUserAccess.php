<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\HtmlString;

class SendDocumentUserAccess extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($documentUserAccessEmail)
    {
        $this->documentUserAccessEmail = $documentUserAccessEmail;
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
                    ->subject("Document Access: ".$this->documentUserAccessEmail['documentLibrary_Series'])
                    ->line(new HtmlString
                        ("You now have access to the Document Library <b>".$this->documentUserAccessEmail['documentLibrary_Series']."</b>"))
                    ->line(new HtmlString
                        ("Access User: <b>".$this->documentUserAccessEmail['documentLibrary_AccessUser']."</b><br> 
                          Document Code: <b>".$this->documentUserAccessEmail['documentLibrary_Series']."</b><br> 
                          Revision: <b>".$this->documentUserAccessEmail['documentRevision_Revision']."</b>
                        "));
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