<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\User;

class AccountEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $type;
    public $user;
    public $params;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $account,array $parmas, $type='')
    {
        $this->user = $account;
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
            case 'signup':
                
                $data["action_text"] = "Confirm Link";
                $data["action_link"] = url("user/confirm",$this->user->confirm_code);

                return $this->subject("Email Confirm Signup")
                        ->view('auth.emails.confirm_signup',$data);
                break;
            case 'created_account':
                $data["action_text"] = "Login";
                $data["action_link"] = url("login");
                $data['password'] = $this->params['password_text'];
                return $this->subject("Created Account")
                        ->view('emails.account_created',$data);
                break;
            case 'notification':
                
                //return $this->view('auth.emails.confirm_signup');
                break;
            case 'schedule_report':
                $data["name"] = $this->params['name'];
                $data["content"] = $this->params['content'];

                return $this->subject($this->params['subject'])
                        ->view('emails.schedule_report',$data)
                        ->attach($this->params['attachment']);
                break;
            default:
                break;
        }
        
        return true;
    }
}
