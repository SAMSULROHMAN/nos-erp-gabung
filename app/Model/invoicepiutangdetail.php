<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class invoicepiutangdetail extends Model
{
    protected $table = 'invoicepiutangdetails';
    protected $primaryKey = 'id';

    public function invoicepiutang()
    {
        return $this->belongsTo('App\Model\invoicepiutang', 'KodeInvoicePiutang', 'KodeInvoicePiutang');
    }

    public function sj()
    {
        return $this->hasOne('App\Model\suratjalan', 'KodeSuratJalanID', 'KodeSuratJalan');
    }
}
