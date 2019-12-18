<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\karyawan;
use DB;

class KaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $karyawan = karyawan::where('Status','OPN')->paginate(5);
        return view('master.karyawan.index', compact('karyawan'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $last_id = DB::select('SELECT * FROM karyawan ORDER BY KodeKaryawan DESC LIMIT 1');

        //Auto generate ID
        if($last_id == null) {
            $newID = "KAR-001";
        }
        else {
            $string = $last_id[0]->KodeKaryawan;
            $id = substr($string, -3, 3);
            $new = $id+1;
            $new = str_pad($new, 3, '0', STR_PAD_LEFT);
            $newID = "KAR-".$new;
        }

        return view('master.karyawan.create',compact('newID'));
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
            'KodeKaryawan'=> 'required',
            'Nama' => 'required',
            'Alamat' => 'required',
            'Kota' => 'required',
            'Propinsi' => 'required',
            'Jabatan' => 'required',
            'Telepon' => 'required',
        ]);

        karyawan::create([
            'KodeKaryawan' => $request->KodeKaryawan,
            'Nama' => $request->Nama,
            'Alamat' => $request->Alamat,
            'Kota' => $request->Kota,
            'Propinsi' => $request->Propinsi,
            'Negara' => $request->Negara,
            'Telepon' => $request->Telepon,
            'Email' => $request->Email,
            'JenisKelamin' => $request->JenisKelamin,
            'KodeUser' => 'Admin',
            'Status' => 'OPN',
            'Jabatan' => $request->Jabatan,
            'tahunmasuk' => $request->tahunmasuk
        ]);

        return redirect('/datakaryawan');
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
        $karyawan = DB::table('karyawan')->get()->where('IDKaryawan',$id);
        return view('master.karyawan.edit',compact('karyawan'));
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
        // $this->validate($request,[
        //     'KodeKaryawan'=> 'required',
        //     'Nama' => 'required',
        //     'Alamat' => 'required',
        //     'Kota' => 'required',
        //     'Propinsi' => 'required',
        //     'Jabatan' => 'required',
        //     'Telepon' => 'required',
        // ]);

        // $tahun = DB::table('karyawan')->where('IDKaryawan',$request->IDKaryawan)->update([
        //     'KodeKaryawan' => $request->KodeKaryawan,
        //     'Nama' => $request->NamaKaryawan,
        //     'Alamat' => $request->Alamat,
        //     'Kota' => $request->Kota,
        //     'Propinsi' => $request->Propinsi,
        //     'Negara' => $request->Negara,
        //     'Telepon' => $request->Telepon,
        //     'Email' => $request->Email,
        //     'KodeUser' => $request->KodeUser,
        //     'Status' => 'OPN',
        //     'Jabatan' => $request->Jabatan,
        //     'JenisKelamin' => $request->JenisKelamin,
        //     'tahunmasuk' => $request->tahunmasuk,
        //     'updated_at' => \Carbon\Carbon::now()
        // ]);
        $tahun = karyawan::find($id);
        $tahun = karyawan::create([
            'KodeKaryawan' => $request->KodeKaryawan,
            'Nama' => $request->Nama,
            'Alamat' => $request->Alamat,
            'Kota' => $request->Kota,
            'Propinsi' => $request->Propinsi,
            'Negara' => $request->Negara,
            'Telepon' => $request->Telepon,
            'Email' => $request->Email,
            'JenisKelamin' => $request->JenisKelamin,
            'KodeUser' => 'Admin',
            'Status' => 'OPN',
            'Jabatan' => $request->Jabatan,
            'tahunmasuk' => $request->tahunmasuk
        ]);
        dd($tahun);
        return redirect('/datakaryawan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $karyawan = karyawan::find($id);
        $karyawan->Status = 'DEL';
        $karyawan->save();
        return redirect('/datakaryawan');
    }
}
