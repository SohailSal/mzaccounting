<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    protected $fillable = [
        'ref', 'date_of_receipt', 'invoice_id', 'account_id', 'description', 'amount','itax','stax'
    ];

    public function account()
    {
        return $this->belongsTo('App\Account');
    }

    public function invoice()
    {
        return $this->belongsTo('App\Invoice');
    }
}
