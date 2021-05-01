<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'ref', 'date_of_payment', 'account_id', 'description', 'mode', 'cheque', 'payee', 'amount'
    ];

    public function account()
    {
        return $this->belongsTo('App\Account','account_id');
    }
}
