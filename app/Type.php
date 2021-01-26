<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $fillable = [
        'type_of_account'
    ];

    public function accounts(){
        return $this->hasMany('App\Account');
    }
}
