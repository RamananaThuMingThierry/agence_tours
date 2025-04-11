<?php

namespace App\Listeners;

use App\Mail\NewUserNotification;
use App\Events\UserRegisteredEvent;
use App\Mail\WelcomeEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendNewUserNotification
{
    public function handle(UserRegisteredEvent $event)
    {
        Mail::to('ramananathumingthierry@gmail.com')->send(new WelcomeEmail($event->user));
        Mail::to('ramananathumingthierry@gmail.com')->send(new NewUserNotification($event->user));
    }
}
