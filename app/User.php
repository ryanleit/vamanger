<?php

namespace App;

use App\Restaurant;
use App\Ultility\Constant;
use App\Ultility\UltiFunc;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Foundation\Auth\User as Authenticatable;

use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, SoftDeletes;
    
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email','phone','address','timezone', 'password','avatar','role_id','type','signup_type','status','country_id','confirm_code'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    /**
     * 
     * @return type
     */
    public function role() {
        
        return $this->belongsTo(\App\Models\Role::class);
    }
    /**
     * Get the setting record associated with the user.
     */
    public function setting()
    {
        return $this->hasOne('App\Setting');
    }
    /**
     * @author Dzung Le <john.doe@example.com>
     * @param type $role
     * @return boolean
     */
    public static function hasRole($roles){
        $role = \Auth::user()->role()->first();
        if(!$role){ return false; }
        
        if(is_array($roles)){
            return in_array($role->id,$role);
        }
        
        return intval($roles) == $role->id;        
    }
    /**
     * @author Dzung Le <john.doe@example.com>
     * @param type $role
     * @return boolean
     */
    public static function hasRoleLevel($roles_level){
       
        $role = \Auth::user()->role()->first();
        
        if(!$role){ return false; }
        
        if(is_array($roles_level)){
            return in_array($role->role_level,$roles_level);
        }
        
        return strval($roles_level) == $role->role_level;        
    }
     /**
     * Update a user instance after a valid registration.
     * @author Dzung Le <john.doe@example.com>
     * @param  array  $data
     * @return User
     */
    public static function updateUser($id,$data)
    {                
        $dataUpdate = ['name' => $data['name'],
                'email' => $data['email'],   
                'phone' => isset($data['phone'])?$data['phone']:null,
                'timezone' => isset($data['timezone'])?$data['timezone']:null,
        ];
        
        /* end check */       
        if(isset($data['status'])){
            $dataUpdate['status'] = $data['status'];
        }        
               
        if(isset($data['password']) && !empty($data['password'])){
            $dataUpdate['password'] = bcrypt($data['password']);
        }
        
        /*$avatar = self::uploadAvatar($request);
        
        if(($avatar != '') || ($request->input('deleted_avatar','false') == 'true')){
            $dataUpdate['avatar'] = $avatar;
        }*/
        
        return User::updateOrCreate(['id'=>$id], $dataUpdate);
    }
     /**
     * 
     * @param Object $request
     * @return string name of file
     */
    public static function uploadAvatar($request){
        
        $avatar = '';
        
        if($request->hasfile('avatar')){
            
            $file = $request->file('avatar');
            $extentsion = $file->getClientOriginalExtension();
            $fileName = date('Y-d-m-H-i-s')."-avatar.".$extentsion;
            
            $upload = UltiFunc::storeImage($file,  Constant::AVATAR_PATH, $fileName);
            if($upload){
                $avatar = $fileName;                                
            }            
        }
        
            
        $deleteAvatar = $request->input('deleted_avatar','false');
        $oldAvatar = $request->input('old_avatar','');
        
        if(!empty($avatar) || ($deleteAvatar === 'true')){
            /* deleted old avatar */
            $oldAvatar = $request->input('old_avatar','');
            if(!empty($oldAvatar) && is_file(storage_path()."/app/public".Constant::AVATAR_PATH.$oldAvatar))
                    
                $delete = UltiFunc::deleteImage(Constant::AVATAR_PATH.$oldAvatar);
        }                  
        
        return $avatar;
    }
    /**
     * 
     * @return string
     */
    public static function getOwnerRestauant() {

        $restaurant = Restaurant::where('user_id',auth()->id())->first();
        
        if($restaurant)
            return $restaurant->id;
        
        return '';
    }
}
