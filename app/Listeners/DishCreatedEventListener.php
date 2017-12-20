<?php

namespace App\Listeners;

use App\Events\DishCreatedEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Carbon\Carbon;
use App\User;
use App\Ultility\Constant;
use App\Mail\RestaurantEmail;
use Illuminate\Support\Facades\Mail;
class DishCreatedEventListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Item Event  $event
     * @return void
     */
    public function handle(DishCreatedEvent $event)
    {
        //Send email to admin for active resto
        $admins = User::where('role_id',2)->get();
        if($admins){
            try {                
                $emails = array_map(
                            function($user) { return $user['email']; },
                            $admins->toArray()
                ); 
                            
                Mail::to($emails)->send(new RestaurantEmail($event->restaurant,$event->menu,[],'dish_created'));    
               
            } catch (Exception $exc) {
                //echo $exc->getTraceAsString();
            }
        }
    }
}
