<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\View;
use App\User;
//use App\Country;
use App\Setting;
use App\Restaurant;
use App\UserPackage;
use App\Ultility\Constant;
use App\Ultility\UltiFunc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
//use App\Ultility\CropAvatar;
class UserController extends Controller
{
    public $active_tab;
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->active_tab = 'user';
        View::share ( 'active_tab', $this->active_tab );
        View::share ( 'page', 'user' );      
    }
    
    /**
     * 
     * @return string
     */
    public static function get_defined_valid_rule() {
        
       $validator_rules = [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'phone' => 'phone:AUTO,MOBILE',            
        ];        
                    
        return $validator_rules;
    }
   

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return void
     */
    public function profileDetail()
    {
        $user = User::find(auth()->id());
        
        $timezone_list = UltiFunc::tz_list(); 
        
        return view('admin.user.profile_detail', ['user'=>$user,'timezone_list'=>$timezone_list]);
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return void
     */
    public function profileEdit()
    {        
        $user = User::find(auth()->id());
        
        $timezone_list = UltiFunc::tz_list(); 
        
        return view('admin.user.profile', ['user'=>$user,'timezone_list'=>$timezone_list]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     *
     * @return void
     */
    public function profileUpdate(Request $request)
    {
        $user = User::findOrFail(auth()->id());
        
        $validation = validator($request->all(), $this->get_defined_valid_rule());
        
        if($validation->fails()){
                  
            $data = $request->all();
          
            $user = User::updateUser(auth()->id(), $data);
            
            $del_account = $request->get('del_account');
            
            if($del_account === 'yes'){
                $restaurants = Restaurant::where('user_id',auth()->id())->get();
                if($restaurants){
                    foreach ($restaurants as $restaurant) {
                        $delMenus = Menu::where('restaurant_id',$restaurant->id)->delete();
                        $restaurant->delete();
                    }                            
                }
                $delUserPackage = UserPackage::where('user_id',auth()->id())->delete();                  
                $user->delete();
            }
            
            if($user instanceof User){          
                $request->session()->flash("success_message", "User is updated.");
                
                return redirect()->route('profile_detail');
            }else{
                $request->session()->flash("fail_message", "Please try again!");
            }   
        }
        
        return redirect()->route('profile');
    }  
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return void
     */
    public function settingDetail($id=null)
    {        
        if(empty($id)) {
            $setting = auth()->user()->setting;
            $id = $setting['id'];
        }
        
        $setting = Setting::find($id);
        
        if(!$setting) $setting = new Setting ();
        return view('admin.setting.view', ['setting'=>$setting]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return void
     */
   /* public function editSetting($id=null)
    {
        if(empty($id)) {
            $setting = auth()->user()->setting;
            $id = $setting['id'];
        }
        
        $setting = Setting::find($id);
        if(!$setting) $setting = new Setting ();
        return view('admin.setting.edit', ['setting'=>$setting]);
    }
    */
    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     *
     * @return void
     */
    /*
    public function updateSetting(Request $request, $id=null)
    {
        if(empty($id)) {
            $setting = auth()->user()->setting;
            $id = $setting['id'];
        }
                
        $validation = validator($request->all(), ['distance_unit' => 'required', 'currency' => 'required', 'lanuage' => 'required']);
        
        if($validation->fails()){
            
            $data = $request->all();
            $data['user_id'] = auth()->id();
            $setting = Setting::updateOrCreate(['id'=>$id], $data);
                     
            if($setting instanceof Setting){          
                $request->session()->flash("success_message", "Setting is updated.");
                
                return redirect()->route('setting_detail');
            }else{
                $request->session()->flash("fail_message", "Please try again!");
            }   
        }                
        return redirect()->route('setting_edit');
    }
    */
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return void
     */
    public function editPassword()
    {        
        return view('admin.user.password');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     *
     * @return void
     */
    public function updatePassword(Request $request)
    {   
        $validation = validator($request->all(), ['old_password' => 'required', 'password' => 'required|confirmed']);
        
        if(!$validation->fails()){
            
            $data = $request->all();
            $user = User::find(auth()->id());
            if($user){
                if(Hash::check($data['old_password'], $user->password)){
                
                    $user->password = bcrypt($data['password']);
                    $user->save();
                    
                    $request->session()->flash("success_message", "Password is updated.");
                    return redirect()->route('profile_detail');
                }else{
                    $request->session()->flash("fail_message", "Wrong password. Please try again!");
                }
            }else{   
                $request->session()->flash("fail_message", "User is not found!");
            }
        }else{
            $request->session()->flash("fail_message", "Fomr is invalid!");
        }               
        return redirect()->route('password_edit')->withInput()->withErrors($validation);
    }
    /**
     * 
     * @param Request $request
     */
    public function imageUpload(Request $request) {
        /*$crop = new CropAvatar(
            isset($_POST['avatar_src']) ? $_POST['avatar_src'] : null,
            isset($_POST['avatar_data']) ? $_POST['avatar_data'] : null,
            isset($_FILES['avatar_file']) ? $_FILES['avatar_file'] : null
        );
        $avatar_src = $request->get('avatar_src');*/
        
        $avatar_data = $request->get('avatar_data');
        $avatar_file = $request->file('avatar_file');
        $crop = new \App\Ultility\CropImage($avatar_data, $avatar_file);
        
        if($crop->moveFile() && !empty($crop->getResult())){           
           $user = User::find(auth()->id());
           if(!empty($user->avatar) && is_file(storage_path()."/app/public".Constant::AVATAR_PATH.$user->avatar)){
                $delete = UltiFunc::deleteImage(Constant::AVATAR_PATH.$user->avatar);
           }
           $user->avatar = $crop->getResult();
           $user->save();
        
        }       
        
        $response = array(
          'state'  => 200,
          'message' => $crop -> getMsg(),
          'result' => $crop -> getResult()
        );

        echo json_encode($response);
    }
}
