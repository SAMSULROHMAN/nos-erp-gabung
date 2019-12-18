<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class keluarmasukbarang extends Model
{
    protected $table = 'keluarmasukbarangs';

    public function lokasi()
    {
        return $this->belongsTo('App\Model\lokasi','KodeLokasi');
    }

    public function item()
    {
        return $this->belongsTo('App\Model\item','KodeItem');
    }

}
