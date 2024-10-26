<?php

namespace App\Listeners;

use App\Events\OrderPlaced;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendAdminNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderPlaced $event)
    {
       $admins = User::where('role', 'admin')->get();
       $orderDetails = 'Order ID: ' . $event->order->id;

       Log::info('Order', ['Order' => $orderDetails]);
        if ($admins->isNotEmpty()) {
            foreach ($admins as $admin) {
                Mail::raw('A new order has been placed! #'. $orderDetails, function ($message) use ($admin) {
                    $message->to($admin->email)
                        ->subject('New Order Notification');
                });
            }
        }
    }
}
