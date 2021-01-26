<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientType extends Model
{
    protected $fillable = [
        'type_of_client'
    ];

    public function clients()
    {
        return $this->hasMany('App\Client');
    }

}
