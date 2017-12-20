<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Ultility\Constant;
use App\Restaurant;
use App\Menu;
class RestaurantEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $type;
    public $restaurant;
    public $menu;
    public $params;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Restaurant $restaurant,$menu, array $parmas, $type='')
    {
        $this->restaurant = $restaurant;
        $this->menu = $menu;
        $this->params = $parmas;
        $this->type = $type;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        switch ($this->type) {           
            case 'item_created':
                $data["action_text"] = "Validate Restaurant";
                $code = base64_encode($this->restaurant->id."_".Constant::SECRET_CODE);
                $data["action_link"] = url()->route("verify_restaurant",['code'=>$code]);
                
                return $this->subject("Created Restaurant")
                        ->view('emails.restaurant_created',$data);
                break;
            case 'item_verified':
                $data["action_text"] = "Restaurant Edit";
                $data["action_link"] = url()->route("my_restaurant_edit",['id'=>$this->restaurant->id]);
                
                return $this->subject("Restaurant Edit")
                        ->view('emails.restaurant_verified',$data);
                
                break;
            case 'item_closed':
                $data["action_text"] = "Restaurant has been closed.";
                $data["action_link"] = url()->route("my_restaurant_edit",['id'=>$this->restaurant->id]);
                
                return $this->subject("Restaurant has been closed.")
                        ->view('emails.restaurant_closed',$data);
                break;
            case 'dish_created':
                $data["action_text"] = "Validate Dish";
                $code = base64_encode($this->menu->id."_".Constant::SECRET_CODE);
                $data["action_link"] = url()->route("verify_menu",['code'=>$code]);
                
                return $this->subject("Validate Dish")
                        ->view('emails.restaurant_restore',$data);
                break;
            default:
                break;
        }
        
        return true;
    }
}
