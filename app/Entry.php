<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Entry extends Model
{
    protected $fillable = [
        'account_id', 'transaction_id','debit','credit'
    ];

    public function transaction()
    {
        return $this->belongsTo('App\Transaction');
    }
    public function account()
    {
        return $this->belongsTo('App\Account');
    }
}
