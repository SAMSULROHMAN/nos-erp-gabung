<?php

namespace App\Http\Controllers;

use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use DB;
use PDF;
use Carbon\Carbon;
// use App\Model\penerimaanbarangreturn;
use App\penerimaanbarangreturn;
use App\Model\penerimaanbarang;
use App\lokasi;
use App\supplier;
use App\invoicehutangdetail;
use SebastianBergmann\Environment\Console;

class ReturnPenerimaanBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('returnPenerimaanBarang.index');
    }

    public function konfirmasi()
    {
        return view('returnPenerimaanBarang.konfirmasi');
    }

    public function batal()
    {
        return view('returnPenerimaanBarang.batal');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $penerimaanbarang = penerimaanbarang::all()->where('Status', 'CFM');
        if ($id == "0") {
            $init = $penerimaanbarang->first();
            $id = $init->KodePenerimaanBarang;
        }
        $suppliers = DB::table('suppliers')->get();
        $lokasis = DB::table('lokasis')->get();
        $items = DB::select("SELECT a.KodeItem,i.NamaItem, SUM(a.qty) as jml, i.Keterangan, s.NamaSatuan, k.HargaBeli FROM penerimaanbarangdetails a inner join items i on a.KodeItem = i.KodeItem inner join itemkonversis k on i.KodeItem = k.KodeItem inner join satuans s on s.KodeSatuan = k.KodeSatuan where a.KodePenerimaanBarang='" . $id . "' group by a.KodeItem, i.Keterangan, s.NamaSatuan, k.HargaBeli, i.NamaItem ");
        $lpb = penerimaanbarang::where('KodePenerimaanBarang', $id)->first();
        $matauang = DB::table('matauangs')->get();

        $year_now = date('Y');
        $month_now = date('m');
        $date_now = date('d');
        $dateNow = $year_now . '-' . $month_now . '-' . $date_now;

        return view('returnPenerimaanBarang.buat', compact('penerimaanbarang', 'id', 'suppliers', 'lokasis', 'items', 'lpb', 'dateNow'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $last_id = DB::select('SELECT * FROM penerimaanbarangreturns ORDER BY id DESC LIMIT 1');

        $year_now = date('y');
        $month_now = date('m');
        $date_now = date('d');
        $pref = "RPB";
        if ($last_id == null) {
            $newID = $pref . "-" . $year_now . $month_now . "0001";
        } else {
            $string = $last_id[0]->KodePenerimaanBarangReturn;
            $ids = substr($string, -4, 4);
            $month = substr($string, -6, 2);
            $year = substr($string, -8, 2);

            if ((int) $year_now > (int) $year) {
                $newID = "0001";
            } else if ((int) $month_now > (int) $month) {
                $newID = "0001";
            } else {
                $newID = $ids + 1;
                $newID = str_pad($newID, 4, '0', STR_PAD_LEFT);
            }

            $newID = $pref . "-" . $year_now . $month_now . $newID;
        }
        DB::table('penerimaanbarangreturns')->insert([
            'KodePenerimaanBarangReturn' => $newID,
            'Tanggal' => $request->Tanggal,
            'KodeLokasi' => $request->KodeLokasi,
            'Status' => 'OPN',
            'KodeUser' => 'Admin',
            'Total' => 0,
            'PPN' => $request->ppn,
            'NilaiPPN' => $request->ppnval,
            'KodeSupplier' => $request->KodeSupplier,
            'Printed' => 0,
            'Diskon' => $request->diskon,
            'NilaiDiskon' => $request->diskonval,
            'Subtotal' => $request->subtotal,
            'KodePenerimaanBarang' => $request->KodePenerimaanBarang,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        $items = $request->item;
        $qtys = $request->qty;
        foreach ($items as $key => $value) {
            DB::table('penerimaanbarangreturndetails')->insert([
                'KodePenerimaanBarangReturn' => $newID,
                'KodeItem' => $items[$key],
                'Qty' => $qtys[$key],
                'NoUrut' => 0,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]);
        }

        return redirect('/returnPenerimaanBarang');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $penerimaanbarangreturn = penerimaanbarangreturn::where('KodePenerimaanBarangReturn', $id)->first();
        $lokasi = lokasi::where('KodeLokasi', $penerimaanbarangreturn->KodeLokasi)->first();
        $supplier = supplier::where('KodeSupplier', $penerimaanbarangreturn->KodeSupplier)->first();
        $items = DB::select("SELECT a.KodeItem,i.NamaItem, SUM(a.Qty) as jml, i.Keterangan, s.NamaSatuan, k.HargaBeli FROM penerimaanbarangreturndetails a inner join items i on a.KodeItem = i.KodeItem inner join itemkonversis k on i.KodeItem = k.KodeItem inner join satuans s on s.KodeSatuan = k.KodeSatuan where a.KodePenerimaanBarangReturn='" . $penerimaanbarangreturn->KodePenerimaanBarangReturn . "' group by a.KodeItem, i.Keterangan, s.NamaSatuan, k.HargaBeli, i.NamaItem ");
        $OPN = true;
        return view('returnPenerimaanBarang.lihat', compact('id', 'penerimaanbarangreturn', 'lokasi', 'supplier', 'items', 'OPN'));
    }

    public function lihat($id)
    {
        $penerimaanbarangreturn = penerimaanbarangreturn::where('KodePenerimaanBarangReturn', $id)->first();
        $lokasi = lokasi::where('KodeLokasi', $penerimaanbarangreturn->KodeLokasi)->first();
        $supplier = supplier::where('KodeSupplier', $penerimaanbarangreturn->KodeSupplier)->first();
        $items = DB::select("SELECT a.KodeItem,i.NamaItem, SUM(a.Qty) as jml, i.Keterangan, s.NamaSatuan, k.HargaBeli FROM penerimaanbarangreturndetails a inner join items i on a.KodeItem = i.KodeItem inner join itemkonversis k on i.KodeItem = k.KodeItem inner join satuans s on s.KodeSatuan = k.KodeSatuan where a.KodePenerimaanBarangReturn='" . $penerimaanbarangreturn->KodePenerimaanBarangReturn . "' group by a.KodeItem, i.Keterangan, s.NamaSatuan, k.HargaBeli, i.NamaItem ");
        $OPN = false;
        return view('returnPenerimaanBarang.lihat', compact('id', 'penerimaanbarangreturn', 'lokasi', 'supplier', 'items', 'OPN'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    public function confirm($id)
    {
        $data = penerimaanbarangreturn::where('KodePenerimaanBarangReturn', $id)->first();
        $data->Status = "CFM";
        $data->save();
        $items = DB::select("SELECT a.KodeItem,i.NamaItem, SUM(a.Qty) as jml, i.Keterangan, s.NamaSatuan, k.HargaBeli FROM penerimaanbarangreturndetails a inner join items i on a.KodeItem = i.KodeItem inner join itemkonversis k on i.KodeItem = k.KodeItem inner join satuans s on s.KodeSatuan = k.KodeSatuan where a.KodePenerimaanBarangReturn='" . $data->KodePenerimaanBarangReturn . "' group by a.KodeItem, i.Keterangan, s.NamaSatuan, k.HargaBeli, i.NamaItem ");

        $last_id = DB::select('SELECT * FROM penerimaanbarangreturns ORDER BY KodePenerimaanBarangReturn DESC LIMIT 1');

        foreach ($items as $key => $value) {
            $last_saldo[$key] = DB::table('keluarmasukbarangs')->where('KodeItem', $value->KodeItem)->orderBy('id', 'desc')->limit(1)->pluck('saldo')->toArray();
        }

        $year_now = date('y');
        $month_now = date('m');
        $date_now = date('d');

        if ($last_id == null) {
            $newID = "RPB-" . $year_now . $month_now . "0001";
        } else {
            $string = $last_id[0]->KodePenerimaanBarangReturn;
            $id = substr($string, -4, 4);
            $month = substr($string, -6, 2);
            $year = substr($string, -8, 2);

            if ((int) $year_now > (int) $year) {
                $newID = "0001";
            } else if ((int) $month_now > (int) $month) {
                $newID = "0001";
            } else {
                $newID = $id + 1;
                $newID = str_pad($newID, 4, '0', STR_PAD_LEFT);
            }

            $newID = "RPB-" . $year_now . $month_now . $newID;
        }
        $tot = 0;

        foreach ($items as $key => $value) {
            $tot += $value->jml;
        }

        foreach ($items as $key => $value) {
            DB::table('keluarmasukbarangs')->insert([
                'Tanggal' => $data->Tanggal,
                'KodeLokasi' => $data->KodeLokasi,
                'KodeItem' => $value->KodeItem,
                'JenisTransaksi' => 'RPB',
                'KodeTransaksi' => $data->KodePenerimaanBarangReturn,
                'Qty' => -$value->jml,
                'HargaRata' => 0,
                'KodeUser' => 'Admin',
                'idx' => 0,
                'indexmov' => 0,
                'saldo' => (int) $last_saldo[$key][0] - (int) $value->jml,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ]);
        }

        $lpb = invoicehutangdetail::where('KodeLPB', '=', $data->KodePenerimaanBarang)->first();
        DB::table('invoicehutangs')
            ->where('KodeInvoiceHutang', $lpb->KodeInvoiceHutang)
            ->update(['Status' => "CLS"]);

        return redirect('/konfirmasiReturnPenerimaanBarang');
    }

    public function cancel($id)
    {
        $data = penerimaanbarangreturn::where('KodePenerimaanBarangReturn', $id)->first();
        $data->Status = "DEL";
        $data->save();
        return redirect('/batalReturnPenerimaanBarang');
    }

    public function print($id)
    {   
        $data = 
        DB::select("select lpb.*,a.*,b.Keterangan from penerimaanbarangreturns a 
            left join penerimaanbarangs lpb on lpb.KodePenerimaanBarang = a.KodePenerimaanBarang
            left join pemesananpembelians b on lpb.KodePO = b.KodePO  where a.KodePenerimaanBarangReturn = '".$id."'")[0];
        $items = DB::select("SELECT a.KodeItem,i.NamaItem, SUM(a.Qty) as jml, i.Keterangan, s.NamaSatuan, k.HargaBeli FROM penerimaanbarangreturndetails a inner join items i on a.KodeItem = i.KodeItem inner join itemkonversis k on i.KodeItem = k.KodeItem inner join satuans s on s.KodeSatuan = k.KodeSatuan where a.KodePenerimaanBarangReturn='".$data->KodePenerimaanBarangReturn."' group by a.KodeItem, i.Keterangan, s.NamaSatuan, k.HargaBeli, i.NamaItem ");
        $lokasi = lokasi::where('KodeLokasi', $data->KodeLokasi)->get();
        $supplier = supplier::where('KodeSupplier', $data->KodeSupplier)->get();
        $jml = 0;
        foreach ($items as $value) {
            $jml += $value->jml;
        }
        $data->Tanggal = Carbon::parse($data->Tanggal)->format('d/m/Y');
        
        $pdf = PDF::loadview('returnPenerimaanBarang.print',compact('data', 'id', 'items', 'jml', 'supplier', 'lokasi'));
        
        return $pdf->download('returnPenerimaanBarang.pdf');
    }

    public function apiOPN()
    {
        $penerimaanbarangreturn = DB::table('penerimaanbarangreturns')
            ->join('lokasis', 'penerimaanbarangreturns.KodeLokasi', '=', 'lokasis.KodeLokasi')
            ->join('suppliers', 'penerimaanbarangreturns.KodeSupplier', '=', 'suppliers.KodeSupplier')
            ->select('penerimaanbarangreturns.*', 'lokasis.NamaLokasi', 'suppliers.NamaSupplier')
            ->where('penerimaanbarangreturns.Status', 'OPN')
            ->get();

        return Datatables::of($penerimaanbarangreturn)
            ->addColumn('action', function ($penerimaanbarangreturn) {
                return '<a href="/returnPenerimaanBarang/show/' . $penerimaanbarangreturn->KodePenerimaanBarangReturn . '" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-eye-open"></i></a> ';
            })->make(true);
    }

    public function apiCFM()
    {
        $penerimaanbarangreturn = DB::table('penerimaanbarangreturns')
            ->join('lokasis', 'penerimaanbarangreturns.KodeLokasi', '=', 'lokasis.KodeLokasi')
            ->join('suppliers', 'penerimaanbarangreturns.KodeSupplier', '=', 'suppliers.KodeSupplier')
            ->select('penerimaanbarangreturns.*', 'lokasis.NamaLokasi', 'suppliers.NamaSupplier')
            ->where('penerimaanbarangreturns.Status', 'CFM')
            ->get();

        return Datatables::of($penerimaanbarangreturn)
            ->addColumn('action', function ($penerimaanbarangreturn) {
                return '<a href="/returnPenerimaanBarang/lihat/' . $penerimaanbarangreturn->KodePenerimaanBarangReturn . '" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-eye-open"></i></a> ';
            })->make(true);
    }

    public function apiDEL()
    {
        $penerimaanbarangreturn = DB::table('penerimaanbarangreturns')
            ->join('lokasis', 'penerimaanbarangreturns.KodeLokasi', '=', 'lokasis.KodeLokasi')
            ->join('suppliers', 'penerimaanbarangreturns.KodeSupplier', '=', 'suppliers.KodeSupplier')
            ->select('penerimaanbarangreturns.*', 'lokasis.NamaLokasi', 'suppliers.NamaSupplier')
            ->where('penerimaanbarangreturns.Status', 'DEL')
            ->get();

        return Datatables::of($penerimaanbarangreturn)
            ->addColumn('action', function ($penerimaanbarangreturn) {
                return '<a href="/returnPenerimaanBarang/lihat/' . $penerimaanbarangreturn->KodePenerimaanBarangReturn . '" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-eye-open"></i></a> ';
            })->make(true);
    }
}