<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class item extends Model
{
    protected $table = 'items';
    protected $fillable = ['KodeItem', 'KodeKategori', 'NamaItem', 'Status'];

    public function kategori()
    {
        return $this->belongsTo('App\kategori');
    }

    public function satuan()
    {
        return $this->belongsTo('App\satuan');
    }

    public function itemkonversi()
    {
        return $this->belongsToMany('App\itemkonversi');
    }
}
