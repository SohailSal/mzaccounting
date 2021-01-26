<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'ref','date_of_invoice','account_id','paid'
    ];

    public function account()
    {
        return $this->belongsTo('App\Account');
    }

    public function invoiceEntries()
    {
        return $this->hasMany('App\InvoiceEntry');
    }

    public function receipt()
    {
        return $this->hasOne('App\Receipt');
    }

}
