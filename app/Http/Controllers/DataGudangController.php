<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\lokasi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class DataGudangController extends Controller
{
    public function __construct(){
      $this->middleware('permission:gudang-list|gudang-create|gudang-edit|gudang-delete', ['only' => ['index','show']]);
      $this->middleware('permission:gudang-create', ['only' => ['create','store']]);
      $this->middleware('permission:gudang-edit', ['only' => ['edit','update']]);
      $this->middleware('permission:gudang-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        // untuk menampilkan data gudang
        $lokasi = lokasi::where('Status','OPN')->paginate(5);
        // logika untuk pencarian data
        // butuh logika enkapsulasi dan abstraksi

        /***
            langkah langkah
            1.definisikan request data yang ingin direquest
            2.gunakan Eloquent , Query Builder, atau SQL Syntax untuk melakukan logika pencarian
        **/
        $search = $request->get('keyword');
        if($search){
          $lokasi = lokasi::where('NamaLokasi','LIKE',"%$search%")
          ->orWhere('KodeLokasi','LIKE',"%$search%")
          ->orWhere('Tipe','LIKE',"%$search%")
          ->paginate(5);
        }
        return view('master.dataGudang',['lokasi' => $lokasi]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $last_id = DB::select('SELECT * FROM lokasis ORDER BY KodeLokasi DESC LIMIT 1');

        //Auto generate ID
        if($last_id == null) {
            $newID = "GUD-001";
        }
        else {
            $string = $last_id[0]->KodeLokasi;
            $id = substr($string, -3, 3);
            $new = $id+1;
            $new = str_pad($new, 3, '0', STR_PAD_LEFT);
            $newID = "GUD-".$new;
        }

        return view('master.buatForm.buatDataGudang', ['newID' => $newID]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'KodeLokasi' => 'required',
            'NamaLokasi' => 'required',
            'Tipe' => 'required'
        ]);

        DB::table('lokasis')->insert([
            'KodeLokasi' => $request->KodeLokasi,
            'NamaLokasi' => $request->NamaLokasi,
            'Tipe' => $request->Tipe,
            'Status' => 'OPN',
            'KodeUser' => 'Admin',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);
        return redirect('/datagudang');

        // lokasi::create([
        //     'KodeLokasi' => $request->KodeLokasi,
        //     'NamaLokasi' => $request->NamaLokasi,
        //     'Tipe' => $request->Tipe
        // ]);

        // return redirect('/datagudang');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $lokasi = DB::table('lokasis')->get()->where('KodeLokasi',$id);
        return view('master.lihatForm.lihatDataGudang', ['lokasi' => $lokasi]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function edit($id)
    {
        $lokasi = DB::table('lokasis')->get()->where('KodeLokasi',$id);
        return view('master.editForm.editDataGudang',['lokasi' => $lokasi]);

        // $lokasi = lokasi::find($id);
        // return view('master.editForm.editDataGudang', ['lokasi' => $lokasi]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        $this->validate($request, [
            'NamaLokasi' => 'required',
            'Tipe' => 'required',
        ]);

        DB::table('lokasis')->where('KodeLokasi',$request->KodeLokasi)->update([
            'NamaLokasi' => $request->NamaLokasi,
            'Tipe' => $request->Tipe,
            'Status' => 'OPN',
            'KodeUser' => 'Admin',
            'updated_at' => \Carbon\Carbon::now()
        ]);
        return redirect('/datagudang');

        // $lokasi = lokasi::find($id);
        // $lokasi->NamaLokasi = $request->NamaLokasi;
        // $lokasi->Tipe = $request->Tipe;
        // $lokasi->save();
        // return redirect('/datagudang');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // DB::table('lokasis')->where('KodeLokasi',$id)->delete();
        // return redirect('/datagudang');
        $lokasi = lokasi::find($id);
        $lokasi->Status = 'DEL';
        $lokasi->save();
        return redirect('/datagudang');
        // $lokasi = lokasi::find($id);
        // $lokasi->delete();
        // return redirect('/datagudang');
    }

    public function filterData(Request $request)
    {

        return $lokasi;
    }
}
