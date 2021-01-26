<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'ref', 'date_of_payment', 'account_id', 'description', 'mode', 'cheque', 'payee', 'amount', 'posted'
    ];

    public function account()
    {
        return $this->belongsTo('App\Account');
    }
}
