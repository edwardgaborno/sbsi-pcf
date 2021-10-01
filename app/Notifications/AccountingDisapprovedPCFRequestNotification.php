<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class AccountingDisapprovedPCFRequestNotification extends Notification
{
    use Queueable;

    private $salesAsst, $name, $institution, $supplier, $psr;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($salesAsst, $name, $institution, $supplier, $psr)
    {
        $this->salesAsst = $salesAsst;
        $this->acct = $name;
        $this->institution = $institution;
        $this->supplier = $supplier;
        $this->psr = $psr;
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
                    ->cc($this->salesAsst)
                    ->subject('PCF Request Status')
                    ->greeting(new HtmlString('<center>Heads up, PCF-RFQ has been declined</center>'))
                    ->line(new HtmlString('Just letting you know that ' . $this->acct . ' has copied you on <q>PCF NO._' . $this->institution . '_' . $this->supplier . '_' . $this->psr .'</q>'))
                    ->line(new HtmlString('<i>Your request is below profit limit, please have it approved by Sir Roberto Manaois/CEO.</i>'))
                    ->line('We\'ll email you again once we received your approved PCF-RFQ.')
                    ->line(new HtmlString('<strong>Thank you!</strong>'));
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
