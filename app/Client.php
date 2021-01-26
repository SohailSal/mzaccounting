<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'clienttype_id', 'account_id', 'address', 'phone', 'email', 'person',
        'tax', 'registration', 'incorporation'
    ];

    public function clientType()
    {
        return $this->belongsTo('App\ClientType');
    }

    public function account()
    {
        return $this->belongsTo('App\Account');
    }

}
