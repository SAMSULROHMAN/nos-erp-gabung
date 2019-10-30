<?php

namespace App\Http\Controllers;

use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use DB;
use PDF;
use App\Model\penerimaanbarang;
use App\Model\pemesananpembelian;
use App\lokasi;
use App\supplier;
use App\Model\invoicehutang;
use Carbon\Carbon;

class PenerimaanBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $penerimaanbarangs = DB::table('penerimaanbarangs')
            ->join('lokasis', 'penerimaanbarangs.KodeLokasi', '=', 'lokasis.KodeLokasi')
            ->join('suppliers', 'penerimaanbarangs.KodeSupplier', '=', 'suppliers.KodeSupplier')
            ->select('penerimaanbarangs.*', 'lokasis.NamaLokasi', 'suppliers.NamaSupplier')
            ->where('penerimaanbarangs.Status', 'OPN')
            ->get();

        return view('penerimaanBarang.index', compact('penerimaanbarangs'));
    }

    public function konfirmasiPenerimaanBarang()
    {
        $penerimaanbarangs = DB::table('penerimaanbarangs')
            ->join('lokasis', 'penerimaanbarangs.KodeLokasi', '=', 'lokasis.KodeLokasi')
            ->join('suppliers', 'penerimaanbarangs.KodeSupplier', '=', 'suppliers.KodeSupplier')
            ->select('penerimaanbarangs.*', 'lokasis.NamaLokasi', 'suppliers.NamaSupplier')
            ->where('penerimaanbarangs.Status', 'CFM')
            ->get();

        return view('penerimaanBarang.konfirmasi', compact('penerimaanbarangs'));
    }

    public function batalPenerimaanBarang()
    {
        $penerimaanbarangs = DB::table('penerimaanbarangs')
            ->join('lokasis', 'penerimaanbarangs.KodeLokasi', '=', 'lokasis.KodeLokasi')
            ->join('suppliers', 'penerimaanbarangs.KodeSupplier', '=', 'suppliers.KodeSupplier')
            ->select('penerimaanbarangs.*', 'lokasis.NamaLokasi', 'suppliers.NamaSupplier')
            ->where('penerimaanbarangs.Status', 'DEL')
            ->get();

        return view('penerimaanBarang.batal', compact('penerimaanbarangs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $pemesananpembelians = pemesananpembelian::all()->where('Status', 'CFM');
        if ($id == "0") {
            $init = $pemesananpembelians->first();
            $id = $init['KodePO'];
        }
        $suppliers = DB::table('suppliers')->get();
        $lokasis = DB::table('lokasis')->get();
        $items = DB::select("SELECT a.KodeItem,i.NamaItem, SUM(a.qty) as jml, i.Keterangan, s.NamaSatuan, k.HargaBeli FROM pemesananpembeliandetails a inner join items i on a.KodeItem = i.KodeItem inner join itemkonversis k on i.KodeItem = k.KodeItem inner join satuans s on s.KodeSatuan = k.KodeSatuan where a.KodePO='" . $id . "' group by a.KodeItem, i.Keterangan, s.NamaSatuan, k.HargaBeli, i.NamaItem ");
        $po = pemesananpembelian::where('KodePO', $id)->first();
        $matauang = DB::table('matauangs')->get();

        $year_now = date('Y');
        $month_now = date('m');
        $date_now = date('d');
        $dateNow = $year_now . '-' . $month_now . '-' . $date_now;

        return view('penerimaanBarang.buat', compact('pemesananpembelians', 'id', 'suppliers', 'lokasis', 'items', 'po', 'dateNow'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $last_id = DB::select('SELECT * FROM penerimaanbarangs ORDER BY id DESC LIMIT 1');

        $year_now = date('y');
        $month_now = date('m');
        $date_now = date('d');
        $pref = "LPB";
        if ($request->ppn == 'ya') {
            $pref = "LPB";
        }
        if ($last_id == null) {
            $newID = $pref . "-" . $year_now . $month_now . "0001";
        } else {
            $string = $last_id[0]->KodePenerimaanBarang;
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
        DB::table('penerimaanbarangs')->insert([
            'KodePenerimaanBarang' => $newID,
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
            'KodePO' => $request->KodePO,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        $items = $request->item;
        $qtys = $request->qty;
        foreach ($items as $key => $value) {
            DB::table('penerimaanbarangdetails')->insert([
                'KodePenerimaanBarang' => $newID,
                'KodeItem' => $items[$key],
                'Qty' => $qtys[$key],
                'NoUrut' => 0,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]);
        }

        return redirect('/penerimaanBarang');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $penerimaanbarang = penerimaanbarang::where('KodePenerimaanBarang', $id)->first();
        $lokasi = lokasi::where('KodeLokasi', $penerimaanbarang->KodeLokasi)->first();
        $supplier = supplier::where('KodeSupplier', $penerimaanbarang->KodeSupplier)->first();
        $items = DB::select("SELECT a.KodeItem,i.NamaItem, SUM(a.Qty) as jml, i.Keterangan, s.NamaSatuan, k.HargaBeli FROM penerimaanbarangdetails a inner join items i on a.KodeItem = i.KodeItem inner join itemkonversis k on i.KodeItem = k.KodeItem inner join satuans s on s.KodeSatuan = k.KodeSatuan where a.KodePenerimaanBarang='" . $penerimaanbarang->KodePenerimaanBarang . "' group by a.KodeItem, i.Keterangan, s.NamaSatuan, k.HargaBeli, i.NamaItem ");
        $OPN = true;
        return view('penerimaanBarang.lihat', compact('id', 'penerimaanbarang', 'lokasi', 'supplier', 'items', 'OPN'));
    }

    public function lihat($id)
    {
        $penerimaanbarang = penerimaanbarang::where('KodePenerimaanBarang', $id)->first();
        $lokasi = lokasi::where('KodeLokasi', $penerimaanbarang->KodeLokasi)->first();
        $supplier = supplier::where('KodeSupplier', $penerimaanbarang->KodeSupplier)->first();
        $items = DB::select("SELECT a.KodeItem,i.NamaItem, SUM(a.Qty) as jml, i.Keterangan, s.NamaSatuan, k.HargaBeli FROM penerimaanbarangdetails a inner join items i on a.KodeItem = i.KodeItem inner join itemkonversis k on i.KodeItem = k.KodeItem inner join satuans s on s.KodeSatuan = k.KodeSatuan where a.KodePenerimaanBarang='" . $penerimaanbarang->KodePenerimaanBarang . "' group by a.KodeItem, i.Keterangan, s.NamaSatuan, k.HargaBeli, i.NamaItem ");
        $OPN = false;
        return view('penerimaanBarang.lihat', compact('id', 'penerimaanbarang', 'lokasi', 'supplier', 'items', 'OPN'));
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
        $data = penerimaanbarang::where('KodePenerimaanBarang', $id)->first();
        $data->Status = "CFM";
        $data->save();
        $po = pemesananpembelian::find($data->KodePO);
        $items = DB::select("SELECT a.KodeItem,i.NamaItem, SUM(a.Qty) as jml, i.Keterangan, s.NamaSatuan, k.HargaBeli FROM penerimaanbarangdetails a inner join items i on a.KodeItem = i.KodeItem inner join itemkonversis k on i.KodeItem = k.KodeItem inner join satuans s on s.KodeSatuan = k.KodeSatuan where a.KodePenerimaanBarang='" . $data->KodePenerimaanBarang . "' group by a.KodeItem, i.Keterangan, s.NamaSatuan, k.HargaBeli, i.NamaItem ");

        $last_id = DB::select('SELECT * FROM invoicehutangs ORDER BY KodeInvoiceHutangShow DESC LIMIT 1');

        $year_now = date('y');
        $month_now = date('m');
        $date_now = date('d');
        $pref = "IVH";
        if ($last_id == null) {
            $newID = $pref . "-" . $year_now . $month_now . "0001";
        } else {
            $string = $last_id[0]->KodeInvoiceHutangShow;
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

        $lastID = DB::table('invoicehutangs')->insertGetId([
            'KodeInvoiceHutangShow' => $newID,
            'Tanggal' => $data->Tanggal,
            'KodeSupplier' => $data->KodeSupplier,
            'Status' => 'OPN',
            'Total' => $po->Total,
            'Keterangan' => $po->Keterangan,
            'KodeMataUang' => $po->KodeMataUang,
            'KodeUser' => 'Admin',
            'Term' => $po->Term,
            'KodeLokasi' => $data->KodeLokasi,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        DB::table('invoicehutangdetails')->insert([
            'KodeHutang' => $lastID,
            'KodeLPB' => $data->KodePenerimaanBarang,
            'Subtotal' => $data->Subtotal,
            'KodeInvoiceHutang' => $newID,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        foreach ($items as $key => $value) {
            $last_saldo[$key] = DB::table('keluarmasukbarangs')->where('KodeItem', $value->KodeItem)->orderBy('id', 'desc')->limit(1)->pluck('saldo')->toArray();
        }

        $tot = 0;
        foreach ($items as $key => $value) {
            $tot += $value->jml;
        }

        foreach ($items as $key => $value) {
            if (isset($last_saldo[$key][0])) {
                $saldo = (int) $last_saldo[$key][0] + (int) $value->jml;
            } else {
                $saldo = 0 + (int) $value->jml;
            }
            DB::table('keluarmasukbarangs')->insert([
                'Tanggal' => $data->Tanggal,
                'KodeLokasi' => $data->KodeLokasi,
                'KodeItem' => $value->KodeItem,
                'JenisTransaksi' => 'LPB',
                'KodeTransaksi' => $data->KodePenerimaanBarang,
                'Qty' => $value->jml,
                'HargaRata' => 0,
                'KodeUser' => 'Admin',
                'idx' => 0,
                'indexmov' => 0,
                'saldo' => $saldo,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ]);
        }

        $updatePO = pemesananpembelian::where('KodePO', $data->KodePO)->first();
        $updatePO->Status = "CLS";
        $updatePO->save();

        DB::table('pemesananpembelians')
            ->where('KodePO', $id)
            ->update(['Status' => "CLS"]);

        return redirect('/konfirmasiPenerimaanBarang');
    }

    public function cancel($id)
    {
        $data = penerimaanbarang::where('KodePenerimaanBarang', $id)->first();
        $data->Status = "DEL";
        $data->save();
        return redirect('/batalPenerimaanBarang');
    }

    public function fixInvoiceID()
    {
        $i = invoicehutang::where('KodeInvoiceHutangShow', '')->get();
        $last_id = null;
        foreach ($i as $is) {
            $year_now = Carbon::parse($is->Tanggal)->format('y');
            $month_now = Carbon::parse($is->Tanggal)->format('m');
            $date_now = Carbon::parse($is->Tanggal)->format('d');
            if ($last_id == null) {
                $newID = "IVP-" . $year_now . $month_now . "0001";
                $is->KodeInvoiceHutangShow = $newID;
                $is->save();
            } else {
                $string = $last_id;
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

                $newID = "IVH-" . $year_now . $month_now . $newID;
                $is->KodeInvoiceHutangShow = $newID;
                $is->save();
            }
            $last_id = $newID;
        }
    }

    public function print($id)
    {   
        $data = 
        DB::select("select a.*,b.Keterangan from penerimaanbarangs a 
            left join pemesananpembelians b on a.KodePO = b.KodePO  where a.KodePenerimaanBarang = '".$id."'")[0];
        $items = DB::select("SELECT a.KodeItem,i.NamaItem, SUM(a.Qty) as jml, i.Keterangan, s.NamaSatuan, k.HargaBeli FROM penerimaanbarangdetails a inner join items i on a.KodeItem = i.KodeItem inner join itemkonversis k on i.KodeItem = k.KodeItem inner join satuans s on s.KodeSatuan = k.KodeSatuan where a.KodePenerimaanBarang='".$data->KodePenerimaanBarang."' group by a.KodeItem, i.Keterangan, s.NamaSatuan, k.HargaBeli, i.NamaItem ");
        $lokasi = lokasi::where('KodeLokasi', $data->KodeLokasi)->get();
        $supplier = supplier::where('KodeSupplier', $data->KodeSupplier)->get();
        $jml = 0;
        foreach ($items as $value) {
            $jml += $value->jml;
        }
        $data->Tanggal = Carbon::parse($data->Tanggal)->format('d/m/Y');

        $pdf = PDF::loadview('penerimaanBarang.print',compact('data', 'id', 'items', 'jml', 'supplier', 'lokasi'));
        
        return $pdf->download('penerimaanBarang.pdf');
    }

    public function apiOPN()
    {
        $penerimaanbarang = DB::table('penerimaanbarangs')
            ->join('lokasis', 'penerimaanbarangs.KodeLokasi', '=', 'lokasis.KodeLokasi')
            ->join('suppliers', 'penerimaanbarangs.KodeSupplier', '=', 'suppliers.KodeSupplier')
            ->select('penerimaanbarangs.*', 'lokasis.NamaLokasi', 'suppliers.NamaSupplier')
            ->where('penerimaanbarangs.Status', 'OPN')
            ->get();

        return Datatables::of($penerimaanbarang)
            ->addColumn('action', function ($penerimaanbarang) {
                return '<a href="/penerimaanBarang/show/' . $penerimaanbarang->KodePenerimaanBarang . '" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-eye-open"></i></a> ';
            })->make(true);
    }

    public function apiCFM()
    {
        $penerimaanbarang = DB::table('penerimaanbarangs')
            ->join('lokasis', 'penerimaanbarangs.KodeLokasi', '=', 'lokasis.KodeLokasi')
            ->join('suppliers', 'penerimaanbarangs.KodeSupplier', '=', 'suppliers.KodeSupplier')
            ->select('penerimaanbarangs.*', 'lokasis.NamaLokasi', 'suppliers.NamaSupplier')
            ->where('penerimaanbarangs.Status', 'CFM')
            ->get();

        return Datatables::of($penerimaanbarang)
            ->addColumn('action', function ($penerimaanbarang) {
                return '<a href="/penerimaanBarang/lihat/' . $penerimaanbarang->KodePenerimaanBarang . '" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-eye-open"></i></a> ';
            })->make(true);
    }

    public function apiDEL()
    {
        $penerimaanbarang = DB::table('penerimaanbarangs')
            ->join('lokasis', 'penerimaanbarangs.KodeLokasi', '=', 'lokasis.KodeLokasi')
            ->join('suppliers', 'penerimaanbarangs.KodeSupplier', '=', 'suppliers.KodeSupplier')
            ->select('penerimaanbarangs.*', 'lokasis.NamaLokasi', 'suppliers.NamaSupplier')
            ->where('penerimaanbarangs.Status', 'DEL')
            ->get();

        return Datatables::of($penerimaanbarang)
            ->addColumn('action', function ($penerimaanbarang) {
                return '<a href="/penerimaanBarang/lihat/' . $penerimaanbarang->KodePenerimaanBarang . '" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-eye-open"></i></a> ';
            })->make(true);
    }
}
