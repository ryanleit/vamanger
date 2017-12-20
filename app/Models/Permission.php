<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class Permission extends Model
{
    use SoftDeletes;
    public $incrementing = false;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'permissions';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
    
     /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'component_id'];

    public function component()
    {
        return $this->hasOne(Component::class,'id');
        //return $this->belongsTo(Component::class,'id');
    }
    
    public function component_with_trashed()
    {
        return $this->belongsTo(Component::class)->withTrashed();
    }
}
