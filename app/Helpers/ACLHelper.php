<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;

Class ACLHelper {
    
    /**
     * 
     * @return type
     */
    private static function getUserRole(){
        $role_id = null;
        
        $user = Auth::user();
        if(!empty($user)){
            $role = $user->role()->first()->toArray();
            $role_id = $role["id"];
        }
        
        return $role_id;
    }
    /**
     * 
     * @return type
     */
    private static function getUserPermissions(){
        $permissions = array();
        $user = Auth::user();
        if(!empty($user)){
            $role = $user->role()->first()->toArray();
            $permissions = json_decode($role["permissions"],TRUE);
        }
        
        return $permissions;
    }
    /**
     * @Desc check has role 
     * @param type $roles
     * @return boolean
     */
    public static function hasRole($roles) {
        
        $role_user_auth = self::getUserRole();
        
        if(empty($role_user_auth)) return false;
        
        if($role_user_auth == \App\Ultility\Constant::SUPER_ADMIN_ROLE) return true;   
        
        if(empty($roles)) return false;

        if(is_array($roles)){
            return in_array($role_user_auth, $roles);
        }else{
            return $role_user_auth == $roles;
        }
        
        return true;
    }
    /**
     * 
     * @param type $permissions
     * @return boolean
     */
    public static function hasPermission($permissions){
        $role_user_auth = self::getUserRole();
        
        if(empty($role_user_auth)) return false;
        
        if($role_user_auth == \App\Ultility\Constant::SUPER_ADMIN_ROLE) return true;
        
        $per_user_auth = self::getUserPermissions();
        if((count($per_user_auth) <= 0) || empty($permissions)) return false;
        
        if(is_array($permissions)){
            foreach ($permissions as $per) {
                if(in_array($per,  $per_user_auth))
                return true;
            }

        }else return in_array($permissions,$per_user_auth);

        return false;
        
    }    
}

