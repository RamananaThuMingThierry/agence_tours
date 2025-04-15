<?php

namespace App\Listeners;

use App\Events\ReservationCreated;
use App\Mail\ReservationAdminMail;
use Illuminate\Support\Facades\Mail;

class SendReservationNotification
{
    public function handle(ReservationCreated $event)
    {
        $adminEmail = 'ramananathumingthierry@gmail.com';

        Mail::to($adminEmail)->send(new ReservationAdminMail($event->reservation));
    }
}

