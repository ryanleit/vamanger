<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class UserExperience extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user_experiences';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';
    
     /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    //protected $fillable = [ 'name','description','status'];
    
   // protected $hidden = array('pivot');
}
