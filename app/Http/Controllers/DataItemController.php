<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use App\Model\item;
use App\Model\kategori;
use App\Model\satuan;
use App\Model\itemkonversi;

class DataItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $items = item::leftJoin('itemkonversis','itemkonversis.KodeItem','=','items.KodeItem')
        ->select('items.*','itemkonversis.KodeSatuan')->where('Status','OPN')
        ->paginate(5);
        $search = $request->get('keyword');
        if($search){
          $lokasi = item::where('KodeItem','LIKE',"%$search%")
          ->orWhere('NamaItem','LIKE',"%$search%")
          ->orWhere('jenisitem','LIKE',"%$search%")
          ->paginate(5);
        }
        return view('master.dataItem', ['items' => $items]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $last_id = DB::select('SELECT * FROM items ORDER BY KodeItem DESC LIMIT 1');

        //Auto generate ID
        if($last_id == null) {
            $newID = "BRS000001";
        }
        else {
            $string = $last_id[0]->KodeItem;
            $id = substr($string, -3, 3);
            $new = $id+1;
            $new = str_pad($new, 5, '0', STR_PAD_LEFT);
            $newID = "BRS0".$new;
        }
        $satuan = satuan::all();
        $itemk = itemkonversi::all();
        $kategori = kategori::all();
        return view('master.buatForm.buatDataItem', ['kategori' => $kategori, 'newID' => $newID, 'satuan' => $satuan, 'itemk' => $itemk]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $lastID = DB::select("SELECT count(1) as jml FROM items where KodeKategori='".$request->KodeKategori."' ")[0]->jml;
        $lastID +=1;
        $kodeAwal = DB::select("SELECT KodeItemAwal as jml FROM kategoris where KodeKategori='".$request->KodeKategori."' group by KodeItemAwal")[0]->jml;
        $kodeAwal .="-";
        if($lastID>100){
            $kodeAwal .=$lastID;
        }else if($lastID>10){
            $kodeAwal .="0".$lastID;
        }else{
            $kodeAwal .="00".$lastID;
        }


        $item = DB::table('items')->insert([
            'KodeItem' => $kodeAwal,
            'KodeKategori' => $request->KodeKategori,
            'NamaItem' => $request->NamaItem,
            'jenisitem' => $request->jenisitem,
            'Alias' => $request->Alias,
            'Keterangan' => $request->Keterangan,
            'Status' => 'OPN',
            'KodeUser' => 'Admin',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        $item2 = DB::table('itemkonversis')->insert([
            'KodeItem' => $kodeAwal,
            'KodeSatuan' => $request->KodeSatuan,
            'Konversi' => $request->Konversi,
            'HargaJual' => $request->HargaJual,
            'HargaBeli' => $request->HargaBeli,
            'HargaGrosir' => $request->HargaGrosir,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        return redirect('/dataitem');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('editForm.buatDataItem');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = item::find($id);
        $item->Status = 'DEL';
        $item->save();
        return redirect('/dataitem');
    }
}
