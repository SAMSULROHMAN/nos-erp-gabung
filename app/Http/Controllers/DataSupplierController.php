<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\supplier;
use Illuminate\Support\Facades\DB;

class DataSupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$supplier = DB::table('suppliers')->get();
        $supplier = supplier::where('Status','OPN')->paginate(5);
        return view('master.dataSupplier', ['supplier' => $supplier]);

        // $supplier = supplier::all();
        // return view('master.dataSupplier', compact('supplier',$supplier));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $last_id = DB::select('SELECT * FROM suppliers ORDER BY KodeSupplier DESC LIMIT 1');

        //Auto generate ID
        if($last_id == null) {
            $newID = "SUP-001";
        }
        else {
            $string = $last_id[0]->KodeSupplier;
            $id = substr($string, -3, 3);
            $new = $id+1;
            $new = str_pad($new, 3, '0', STR_PAD_LEFT);
            $newID = "SUP-".$new;
        }

        return view('master.buatForm.buatDataSupplier', ['newID' => $newID]);
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
            'KodeSupplier'=> 'required',
            'NamaSupplier'=> 'required',
            'Kontak'=> 'required',
            'Handphone'=> 'required',
        ]);

        $alamats = $request->alamat;
        DB::table('suppliers')->insert([
            'KodeSupplier' => $request->KodeSupplier,
            'NamaSupplier' => $request->NamaSupplier,
            'Kontak' => $request->Kontak,
            'Handphone' => $request->Handphone,
            'Status' => 'OPN',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);

        foreach ($alamats as $key => $value) {
            DB::table('alamatsuppliers')->insert([
                'KodeSupplier' => $request->KodeSupplier,
                'Alamat' => $alamats[$key],
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ]);
        }
        return redirect('/datasupplier');

        // supplier::create([
        //     'KodeSupplier' => $request->KodeSupplier,
        //     'NamaSupplier' => $request->NamaSupplier,
        //     'Kontak' => $request->Kontak,
        //     'Handphone' => $request->Handphone,
        //     'Alamat' => $request->Alamat
        // ]);

        // return redirect('/datasupplier');
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
        $supplier = DB::table('suppliers')->get()->where('KodeSupplier',$id);
        return view('master.editForm.editDataSupplier',['supplier' => $supplier]);

        // $supplier = supplier::find($id);
        // return view('master.editForm.editDataSupplier',['supplier' => $supplier]);
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
            'NamaSupplier'=> 'required',
            'Kontak'=> 'required',
            'Handphone'=> 'required',
            'Alamat'=> 'required'
        ]);

        DB::table('suppliers')->where('KodeSupplier',$request->KodeSupplier)->update([
            'NamaSupplier' => $request->NamaSupplier,
            'Kontak' => $request->Kontak,
            'Handphone' => $request->Handphone,
            'Alamat' => $request->Alamat,
            'updated_at' => \Carbon\Carbon::now()
        ]);
        return redirect('/datasupplier');

        // $supplier = supplier::find($id);
        // $supplier->NamaSupplier = $request->NamaSupplier;
        // $supplier->Kontak = $request->Kontak;
        // $supplier->Handphone = $request->Handphone;
        // $supplier->Alamat = $request->Alamat;
        // $supplier->save();
        // return redirect('/datasupplier');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('suppliers')->where('KodeSupplier',$id)->delete();
        return redirect('/datasupplier');

        // $supplier = supplier::find($id);
        // $supplier->delete();
        // return redirect('/datasupplier');
    }
}
