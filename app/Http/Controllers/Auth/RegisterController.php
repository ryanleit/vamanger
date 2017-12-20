<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Menu;
use App\Package;
use App\UserPackage;
use App\Restaurant;
use App\Ultility\Constant;
use Illuminate\Http\Request;
use App\Events\ItemCreatedEvent;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Mail\AccountEmail;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        View::share ( 'page', 'register');
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {               
        if(isset($data['as_pro_user']) && $data['as_pro_user'] == 1){
            $validator_rules = [
                'name' => 'required|max:255',
                'email' => 'required|email|unique:users|max:255',
                'password' => 'required|min:6|confirmed',        
                'terms' =>'required'
            ];
            if(!empty($data['phone'])) $validator_rules['phone'] = 'regex:/^[\+]{1}[0-9]{9,20}$/|max:20';
            $validator_rules = array_merge($validator_rules, [
                                            'package' =>'required',
                                            'restaurant_name' => 'required|max:255',
                                            'restaurant_address' => 'required|max:255',
                                            'geocode' => 'required',
                                            'restaurant_phone'=>'required|max:20',
                                            'restaurant_phone'=>'regex:/^[\+]{1}[0-9]{9,20}$/|max:20'
                                        ]);                        
        }else{
            $validator_rules = [
                'email' => 'required|email|unique:users|max:255',
                'password' => 'required|min:6', 
                'terms' =>'required'
            ];          
         
        }     
        return Validator::make($data, $validator_rules);
    }
    protected function validRules() {
        
        $validator_rules = [
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|min:6', 
            'terms' =>'required'
        ];
         
        return $validator_rules;
    }
     /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showProRegistrationForm()
    {
        $packages  = Package::where('status','active')->get();
        
        return view('auth.pro_register',['packages'=>$packages]);
    }
    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function proRegister(Request $request)
    {
        $user_exist = $this->checkUserExist($request);
         
        if($user_exist) return redirect($this->redirectPath());
        
        $this->validator($request->all())->validate();
        $user = $this->create($request->all(),'pro');
        
        if($user){
            event(new Registered($user));                        
            
            //Send email confirm
            Mail::to($user->email)->send(new AccountEmail($user,[],'signup'));                        
            
            $request->session()->flash("success_message", "Please check email to confirm");
            
            return $this->registered($request, $user)
                        ?: redirect($this->redirectPath());
        
        }else{
            $request->session()->flash("fail_message", "Something went wrong. please try again");
            return redirect("register");
        }                          
    }
    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }
    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $user_exist = $this->checkUserExist($request);
        if($user_exist) return redirect('register');
        
        $validator = validator($request->all(), $this->validRules());        
        
        if (!$validator->fails()) {
            //$this->validator($request->all())->validate();
            $user = $this->create($request->all(),'normal');

            if($user){
                event(new Registered($user));

                //Send email confirm
                Mail::to($user->email)->send(new AccountEmail($user,[],'signup'));                        

                $request->session()->flash("success_message", "Please check email to confirm");

                return $this->registered($request, $user)
                            ?: redirect($this->redirectPath());

            }else{
                $request->session()->flash("fail_message", "Something went wrong. please try again");
                return redirect("register");
            }            
        }else{
            /*$errors = $validator->errors();
            if ($errors->has('email')) {
                $errors->get('email');
            }*/
            $request->session()->flash("fail_message", "Invalid! Please try again!");
        }
        
        return redirect('register')->withErrors($validator)->withInput();
        
        //$this->guard()->login($user);        
    }
     /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sendMailRegister(Request $request,$id)
    {        
        $userId = base64_decode($id);
        $user = User::find($userId);
        
        if($user && $user->status == Constant::PENDING_STATUS){                          
            //Send email confirm
            Mail::to($user->email)->send(new AccountEmail($user,[],'signup'));                        
            
            $request->session()->flash("success_message", "Please check email to confirm.");
                   
        }else{
            $request->session()->flash("fail_message", "User is not found!");
        }
        
        return redirect('login');
    }
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data,$type = 'normal')
    {
        $as_pro_user = isset($data['as_pro_user'])?$data['as_pro_user']:null;
        
        if($type == 'pro'){
            $user =  User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'password' => bcrypt($data['password']),
                //'country_id' => 1,
                'role_id' =>Constant::MANAGER_ROLE,
                'type' =>  Constant::OWNER_TYPE,
                'signup_type' => Constant::INTERNAL_SIGNUP_TYPE,
                'status'=> Constant::PENDING_STATUS,
                'confirm_code' =>  str_random(40)
            ]);
        }else{
             $user =  User::create([
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
                'role_id' =>Constant::USER_ROLE,
                'type' =>  Constant::USER_TYPE,
                'signup_type' => Constant::INTERNAL_SIGNUP_TYPE,
                'status'=> Constant::PENDING_STATUS,
                'confirm_code' =>  str_random(40)
            ]);
        }
        if($user){
            
            if($type == 'pro'){
                $create_res = $this->createRestaurant($user->id,$data);     
                
                //send email to admin for verifing restaurant
                if($create_res instanceof Restaurant){
                    event(new ItemCreatedEvent($create_res,new Menu()));  
                }
                $packageid = isset($data['package'])?$data['package']:null;
                if($packageid && Package::findOrFail($packageid))                
                    $userPackage = UserPackage::create(['user_id'=>$user->id,'package_id'=>$packageid,'status'=> Constant::PENDING_STATUS]);
            }
        }
        
        return $user;
    }
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function createRestaurant($user_id,array $data)
    {
        list($lat,$lng) = explode("_", $data['geocode']);
        
        return Restaurant::create([
            'name' => $data['restaurant_name'],
            'address' => $data['restaurant_address'],
            'phone' => $data['restaurant_phone'],    
            'type_id' => 1,
            'user_id' => $user_id,
            'lat' => $lat,
            'lng' => $lng,
            'status'=> Constant::ACTIVE_STATUS,
        ]);
    }
    /**
     * @Desc activate user confirm via email
     * @author Dzung Le
     * @param Request $request
     * @param type $confirm_code
     */
    public function userActivation(Request $request,$confirm_code) {
        
        if(!is_null($confirm_code)){
            $user = User::where('confirm_code', '=', $confirm_code)->first();
            
            if($user){
                
                $current = \Carbon\Carbon::now();
                
                $dateDiff = $current->diffInDays($user->updated_at);
                
                if($dateDiff === 0){
                    $user->status = "active";
                    $user->confirm_code = null;
                    $user->updated_at = \Carbon\Carbon::now();
                    
                    $user->save();
                    
                    $request->session()->flash("success_message", "Confirm is success.");
                    
                    
                }else{
                    $request->session()->flash("fail_message", "Link is exprired! Please try again!");
                }
            }else{
                $request->session()->flash("fail_message", "User is not found!");
            }
            
            return redirect('/login');
        }else{
            abort(404);
        }        
    }
    /**
     * 
     * @param type $request
     * @return boolean
     */
    public function checkUserExist($request) {
        $email = $request->get('email');
        $phone = $request->get('phone');
        
        $query = User::withTrashed()->where('email',$email);
        if(!empty($phone)){
            $query = $query->orWhere('phone',$phone);
        }
        $user = $query->first();
        
        if($user){
            if($user->trashed()){
        
                $user->status = Constant::PENDING_STATUS;
                $user->confirm_code = str_random(40);
                $user->deleted_at = null;
                
                $user->save();

                Mail::to($user->email)->send(new AccountEmail($user,[],'signup')); 
                
                $request->session()->flash("success_message", "Please check email to activation your account.");
            }else{
                if(empty($phone)){
                    $request->session()->flash("fail_message", 'Your email is already exist. Please <a href="login">Signin</a> or try again!'); 
                }else{
                    $request->session()->flash("fail_message", 'Your email or phone is already exist!'); 
                }                
            }
            
            return TRUE;
        }
        
        return FALSE;
    }
}
