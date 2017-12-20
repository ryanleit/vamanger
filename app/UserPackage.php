<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class UserPackage extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user_packages';

    /**
    * The database primary key value.
    *
    * @var string
    */
  //  protected $primaryKey = 'id';
    
      /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'package_id', 'status'];
    
}
