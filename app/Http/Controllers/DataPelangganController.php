<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\pelanggan;
use App\Model\alamatpelanggan;
use App\Model\lokasi;
use DB;

class DataPelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pelanggan = DB::table('pelanggans')->where('Status','OPN')->paginate(5);
        return view('master.dataPelanggan', ['pelanggan'=> $pelanggan]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $last_id = DB::select('SELECT * FROM pelanggans ORDER BY KodePelanggan DESC LIMIT 1');

        //Auto generate ID
        if($last_id == null) {
            $newID = "PLG-001";
        }
        else {
            $string = $last_id[0]->KodePelanggan;
            $id = substr($string, -3, 3);
            $new = $id+1;
            $new = str_pad($new, 3, '0', STR_PAD_LEFT);
            $newID = "PLG-".$new;
        }
        return view('master.buatForm.buatDataPelanggan', ['newID' => $newID]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $pelanggan = $request->all();
        $alamats = $request->alamat;
        $pelanggan = new pelanggan();
        $pelanggan->KodePelanggan = $request->KodePelanggan;
        $pelanggan->NamaPelanggan = $request->NamaPelanggan;
        $pelanggan->Kontak = $request->Kontak;
        $pelanggan->Handphone = $request->Handphone;
        $pelanggan->Email = $request->Email;
        $pelanggan->NIK = $request->NIK;
        $pelanggan->NPWP = $request->NPWP;
        $pelanggan->Status = 'OPN';
        $pelanggan->created_at = \Carbon\Carbon::now();
        $pelanggan->updated_at = \Carbon\Carbon::now();
        $pelanggan->save();

        foreach ($alamats as $key => $value) {
            DB::table('alamatpelanggans')->insert([
                'KodePelanggan' => $request->KodePelanggan,
                'Alamat' => $alamats[$key],
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ]);
        }

        return redirect('/datapelanggan');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    { }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pelanggan = pelanggan::find($id);
        return view('master.editForm.editDataPelanggan', compact('pelanggan'));
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
        $pelanggan = $request->validate([
            'KodePelanggan' => 'required',
            'NamaPelanggan' => 'required',
            'Kontak' => 'required',
            'Handphone' => 'required',
            'Email' => 'required',
            'NIK' => 'required'
        ]);
        /*
        $pelanggan = pelanggan::find($id);
        $pelanggan->KodePelanggan = $request->input('KodePelanggan');
        $pelanggan->NamaPelanggan = $request->input('NamaPelanggan');
        $pelanggan->Kontak = $request->input('Kontak');
        $pelanggan->Handphone = $request->input('Handphone');
        $pelanggan->Email = $request->input('Email');
        $pelanggan->NIK = $request->input('NIK');
        $pelanggan->save();
        */
        pelanggan::whereId($id)->update($pelanggan);
        return redirect()->route('datapelanggan.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // $pelanggan = pelanggan::find($id);
        // $pelanggan->delete();
        $pelanggan = pelanggan::find($id);
        $pelanggan->Status = 'DEL';
        $pelanggan->save();
        return redirect('/datapelanggan');
        //return redirect()->route('datapelanggan.index');
    }
}
