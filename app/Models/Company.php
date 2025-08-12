<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    
    use SoftDeletes;

    protected $fillable = ['user_id','name','address','industry'];

    public function user() {
        return $this->belongsTo(User::class);
    }

}
