<?php
namespace App\Ultility;

class Constant{

   /**
    * Define constant
    * 
    * 
    */
    
   const AVATAR_PATH = '/images/users/';
   const DEFAULT_AVATAR = 'default-avatar.jpg';
   
   const STORE_AVATAR_PATH = "/app/public" . self::AVATAR_PATH;   
   
   const OWNER_TYPE = 'owner';
   const ADMIN_TYPE = 'admin';
   const USER_TYPE = 'user';
   
   const GOOGLE_SIGNUP_TYPE = 'google';
   const LINKEDIN_SIGNUP_TYPE = 'linkedin';
   const INTERNAL_SIGNUP_TYPE = 'internal';
   
   const PREPAID_BILLING_TYPE = 'prepaid';
   const POSTPAID_BILLING_TYPE = 'postpaid';

   const VERIFIED_STATUS = 'verified';
   const ACTIVE_STATUS = 'active';
   const INACTIVE = 'inactive';
   const PENDING_STATUS = 'pending';
   const DELETED_STATUS = 'deleted';
   const CLOSED_STATUS = 'closed';
   
      
   const SUPER_ADMIN_ROLE = 1;
   const ADMIN_ROLE = 2;
   const MANAGER_ROLE = 3;
   const USER_ROLE = 4;
   
   const DEFAULT_ROLE_LEVEL = 4;
   public static $roleLevel = [
        self::SUPER_ADMIN_ROLE => 12,
        self::ADMIN_ROLE => 9,
        self::MANAGER_ROLE => 6,
        self::USER_ROLE => 3,
   ];
   
   
   public static $userRole = [
        self::SUPER_ADMIN_ROLE => 'Super Admin',
        self::ADMIN_ROLE => 'Admin',
        self::MANAGER_ROLE =>'Manager',
        self::USER_ROLE =>'User',
   ];       
    
   //Admin email
   const ADMIN_EMAIL = 'dungle.navigos@gmail.com';
   
   const SECRET_CODE = 'a1l3@jhz';
}