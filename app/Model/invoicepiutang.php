<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class invoicepiutang extends Model
{
    protected $table = 'invoicepiutangs';
    protected $primaryKey = 'KodeInvoicePiutang';

    public function detail()
    {
        return $this->hasOne('App\Model\invoicepiutangdetail', 'KodeInvoicePiutang', 'KodeInvoicePiutang');
    }

    public function payments()
    {
        return $this->hasMany('App\Model\pelunasanpiutang', 'KodeInvoice', 'KodeInvoicePiutang');
    }
}
