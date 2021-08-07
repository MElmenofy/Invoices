<?php

namespace App\Notifications;

use App\Invoices;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use App\User;

class InvoiceAdded extends Notification
{
    use Queueable;
    private $invoice_id;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($invoice_id)
    {
        //
        $this->invoice_id = $invoice_id;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
//    public function toArray($notifiable)
//    {
//        return [
//            //
//        ];
//    }

    public function toDatabase($notifiable)
    {
        return [
            'id'=> $this->invoice_id->id,
            'title'=>'تم اضافة فاتورة جديد بواسطة :',
            'user'=> Auth::user()->name,
        ];
    }
}
