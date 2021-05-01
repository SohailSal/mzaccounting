<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $fillable = [
        'head_of_account', 'type_id'
    ];

    public function type(){
        return $this->belongsTo('App\Type');
    }

    public function entries()
    {
        return $this->hasMany('App\Entry');
    }

    public function client()
    {
        return $this->hasOne('App\Client');
    }

    public function invoices()
    {
        return $this->hasMany('App\Invoice');
    }

    public function receipts()
    {
        return $this->hasMany('App\Receipt');
    }

    public function payments()
    {
        return $this->hasMany('App\Payment','account_id');
    }

    public function posts()
    {
        return $this->hasMany('App\Post');
    }
}


