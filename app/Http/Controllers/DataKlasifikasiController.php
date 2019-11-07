<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\kategori;
use Illuminate\Support\Facades\DB;
use App\Request\Request\Master\RequestKlasifikasi;


class DataKlasifikasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kategori = kategori::where('Status','OPN')->paginate(5);
        return view('master.dataKlasifikasi', ['kategori' => $kategori]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $last_id = DB::select('SELECT * FROM kategoris ORDER BY KodeKategori DESC LIMIT 1');

        //Auto generate ID
        if($last_id == null) {
            $newID = "KLA-001";
        }
        else {
            $string = $last_id[0]->KodeKategori;
            $id = substr($string, -3, 3);
            $new = $id+1;
            $new = str_pad($new, 3, '0', STR_PAD_LEFT);
            $newID = "KLA-".$new;
        }

        return view('master.buatForm.buatDataKlasifikasi', ['newID' => $newID]);

        // return view('master.buatForm.buatDataKlasifikasi');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'KodeKategori'=> 'required',
            'NamaKategori'=> 'required',
            'KodeItemAwal'=> 'required'
        ]);
            //$validated = $request->validated();

        DB::table('kategoris')->insert([
            'KodeKategori' => $request->KodeKategori,
            'NamaKategori' => $request->NamaKategori,
            'KodeItemAwal' => $request->KodeItemAwal,
            'Status' => 'OPN',
            'KodeUser' => 'Admin',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);
        return redirect('/dataklasifikasi');

        // kategori::create([
        //     'KodeKategori' => $request->KodeKategori,
        //     'NamaKategori' => $request->NamaKategori,
        //     'KodeItemAwal' => $request->KodeItemAwal
        // ]);

        // return redirect('/dataklasifikasi');
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
        $kategori = DB::table('kategoris')->where('KodeKategori',$id)->get();
        return view('master.editForm.editDataKlasifikasi',['kategori' => $kategori]);

        // $kategori = kategori::find($id);
        // return view('master.editForm.editDataKlasifikasi',['kategori' => $kategori]);
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
        $this->validate($request,[
            'NamaKategori'=> 'required',
            'KodeItemAwal'=> 'required'
        ]);

        DB::table('kategoris')->where('KodeKategori',$request->KodeKategori)->update([
            'NamaKategori' => $request->NamaKategori,
            'KodeItemAwal' => $request->KodeItemAwal,
            'updated_at' => \Carbon\Carbon::now()
        ]);
        return redirect('/dataklasifikasi');

        // $kategori = kategori::find($id);
        // $kategori->NamaKategori = $request->NamaKategori;
        // $kategori->KodeItemAwal = $request->KodeItemAwal;
        // $kategori->save();
        // return redirect('/dataklasifikasi');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // DB::table('kategoris')->where('KodeKategoris',$id)->delete();
        // return redirect('/dataklasifikasi');
        $kategori = kategori::find($id);
        $kategori->Status = 'DEL';
        $kategori->save();
        return redirect('/dataklasifikasi');
        // $kategori = kategori::find($id);
        // $kategori->delete();
        // return redirect('/dataklasifikasi');
    }
}
