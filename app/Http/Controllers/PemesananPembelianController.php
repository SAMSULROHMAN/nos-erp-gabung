<?php

namespace App\Http\Controllers;

use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use App\pemesananpembelian;
use App\lokasi;
use App\matauang;
use App\supplier;
use App\item;
use PDF;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PemesananPembelianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $pemesananpembelian = DB::table('pemesananpembelians')
        //     ->join('lokasis', 'pemesananpembelians.KodeLokasi', '=', 'lokasis.KodeLokasi')
        //     ->join('matauangs', 'pemesananpembelians.KodeMataUang', '=', 'matauangs.KodeMataUang')
        //     ->join('suppliers', 'pemesananpembelians.KodeSupplier', '=', 'suppliers.KodeSupplier')
        //     ->select('pemesananpembelians.*', 'lokasis.NamaLokasi', 'matauangs.NamaMataUang', 'suppliers.NamaSupplier')
        //     ->get();
        // return view('pemesananPembelian.pemesananPembelian', [
        //     'pemesananpembelian' => $pemesananpembelian
        // ]);

        return view('pemesananPembelian.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $matauang = DB::table('matauangs')->get();
        $lokasi = DB::table('lokasis')->get();
        $supplier = DB::table('suppliers')->get();
        $item = DB::select("SELECT s.KodeItem, s.NamaItem, k.HargaBeli, t.NamaSatuan, s.Keterangan FROM items s 
            inner join itemkonversis k on k.KodeItem = s.KodeItem 
            inner join satuans t on k.KodeSatuan = t.KodeSatuan where s.jenisitem='bahanbaku' ");
        $last_id = DB::select('SELECT * FROM pemesananpembelians ORDER BY KodePO DESC LIMIT 1');
        $last_id_tax = DB::select('SELECT * FROM pemesananpembelians WHERE KodePO LIKE "%POT-%"  ORDER BY KodePO DESC LIMIT 1');

        $year_now = date('y');
        $month_now = date('m');
        $date_now = date('d');

        if ($last_id == null) {
            $newID = "PO-" . $year_now . $month_now . "0001";
        } else {
            $string = $last_id[0]->KodePO;
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

            $newID = "PO-" . $year_now . $month_now . $newID;
        }

        //generate ID PO ppn
        if ($last_id_tax == null) {
            $newID_tax = "POT-" . $year_now . $month_now . "0001";
        } else {
            $string = $last_id_tax[0]->KodePO;
            $id = substr($string, -4, 4);
            $month = substr($string, -6, 2);
            $year = substr($string, -8, 2);

            if ((int) $year_now > (int) $year) {
                $newID_tax = "0001";
            } else if ((int) $month_now > (int) $month) {
                $newID_tax = "0001";
            } else {
                $newID_tax = $id + 1;
                $newID_tax = str_pad($newID_tax, 4, '0', STR_PAD_LEFT);
            }

            $newID_tax = "POT-" . $year_now . $month_now . $newID_tax;
        }

        $year_now = date('Y');
        $dateNow = $year_now . '-' . $month_now . '-' . $date_now;

        return view('pemesananPembelian.buat', [
            'newID' => $newID,
            'newID_tax' => $newID_tax,
            'matauang' => $matauang,
            'lokasi' => $lokasi,
            'supplier' => $supplier,
            'item' => $item,
            'dateNow' => $dateNow
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $this->validate($request, [
        //     'KodePO' => 'required',
        //     'KodeLokasi' => 'required',
        //     'KodeMataUang' => 'required',
        //     'KodeSupplier' => 'required',
        //     'PPN' => 'required',
        //     'Tanggal' => 'required',
        //     'Expired' => 'required'
        // ]);

        DB::table('pemesananpembelians')->insert([
            'KodePO' => $request->KodePO,
            'KodeLokasi' => $request->KodeLokasi,
            'KodeMataUang' => $request->KodeMataUang,
            'KodeSupplier' => $request->KodeSupplier,
            'Status' => 'OPN',
            'KodeUser' => 'Admin',
            'PPN' => $request->ppn,
            'NilaiPPN' => $request->NilaiPPN,
            'Diskon' => $request->diskon,
            'NilaiDiskon' => $request->NilaiDiskon,
            'Subtotal' => $request->subtotal,
            'Tanggal' => $request->Tanggal,
            'Expired' => $request->Expired,
            'Keterangan' => $request->Keterangan,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        $items = $request->item;
        $qtys = $request->qty;
        $prices = $request->price;
        $totals = $request->total;
        foreach ($items as $key => $value) {
            DB::table('pemesananpembeliandetails')->insert([
                'KodePO' => $request->KodePO,
                'KodeItem' => $items[$key],
                'Qty' => $qtys[$key],
                'Harga' => $prices[$key],
                'NoUrut' => 0,
                'Subtotal' => $totals[$key],
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]);
        }
        return redirect('/popembelian');

        // pemesananpembelian::create([
        //     'KodePO' => (string)$request->kodepo,
        //     'KodeLokasi' => (string)$request->kodelokasi,
        //     'KodeMataUang' => (string)$request->kodematauang,
        //     'PPN' => $request->ppn,
        //     'Tanggal' => $request->tanggal,
        //     'Expired' => $request->expired,
        //     'Keterangan' => $request->keterangan
        // ]);

        // return redirect()->route('pemesananpembelian.pemesananpembelian');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = DB::select("SELECT a.KodePO, a.Tanggal, a.Expired, b.NamaMataUang, c.NamaLokasi, d.NamaSupplier, a.Keterangan, a.Diskon, a.PPN, a.Subtotal from pemesananpembelians a 
            inner join matauangs b on b.KodeMataUang = a.KodeMataUang
            inner join lokasis c on c.KodeLokasi = a.KodeLokasi
            inner join suppliers d on d.KodeSupplier = a.KodeSupplier
            where a.KodePO ='" . $id . "' limit 1")[0];
        $items = DB::select("SELECT a.Qty, b.NamaItem, d.NamaSatuan, a.Harga, a.Subtotal, b.Keterangan  from pemesananpembeliandetails a 
            inner join items b on a.KodeItem = b.KodeItem
            inner join itemkonversis c on c.KodeItem = a.KodeItem 
            inner join satuans d on c.KodeSatuan = d.KodeSatuan
            where a.KodePO ='" . $id . "' ");
        $OPN = true;
        // dd($items);

        return view('pemesananpembelian.lihat', compact('data', 'id', 'items', 'OPN'));
    }

    public function lihat($id)
    {
        $data = DB::select("SELECT a.KodePO, a.Tanggal, a.Expired, b.NamaMataUang, c.NamaLokasi, d.NamaSupplier, a.Keterangan, a.Diskon, a.PPN, a.Subtotal from pemesananpembelians a 
            inner join matauangs b on b.KodeMataUang = a.KodeMataUang
            inner join lokasis c on c.KodeLokasi = a.KodeLokasi
            inner join suppliers d on d.KodeSupplier = a.KodeSupplier
            where a.KodePO ='" . $id . "' limit 1")[0];
        $items = DB::select("SELECT a.Qty, b.NamaItem, d.NamaSatuan, a.Harga, a.Subtotal, b.Keterangan  from pemesananpembeliandetails a 
            inner join items b on a.KodeItem = b.KodeItem
            inner join itemkonversis c on c.KodeItem = a.KodeItem 
            inner join satuans d on c.KodeSatuan = d.KodeSatuan
            where a.KodePO ='" . $id . "' ");
        $OPN = false;
        // dd($items);

        return view('pemesananpembelian.lihat', compact('data', 'id', 'items', 'OPN'));
    }

    public function print($id)
    {   
        $data = pemesananpembelian::where('KodePO', $id)->get();
        $items = DB::select("SELECT a.KodeItem,i.NamaItem, SUM(a.Qty) as jml, i.Keterangan, s.NamaSatuan, k.HargaBeli FROM pemesananpembeliandetails a inner join items i on a.KodeItem = i.KodeItem inner join itemkonversis k on i.KodeItem = k.KodeItem inner join satuans s on s.KodeSatuan = k.KodeSatuan where a.KodePO='".$data[0]->KodePO."' group by a.KodeItem, i.Keterangan, s.NamaSatuan, k.HargaBeli, i.NamaItem ");
        $lokasi = lokasi::where('KodeLokasi', $data[0]->KodeLokasi)->get();
        $supplier = supplier::where('KodeSupplier', $data[0]->KodeSupplier)->get();
        $jml = 0;
        foreach ($items as $value) {
            $jml += $value->jml;
        }
        $data->Tanggal = Carbon::parse($data[0]->Tanggal)->format('d/m/Y');

        $pdf = PDF::loadview('pemesananPembelian.print',compact('data', 'id', 'items', 'jml', 'supplier', 'lokasi'));
        
        return $pdf->download('pemesananPembelian.pdf');
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
        DB::table('pemesananpembelians')->where('KodePO', $id)->delete();
        return redirect('/popembelian');
    }

    public function apiOPN()
    {
        $pemesananpembelian = DB::table('pemesananpembelians')
            ->join('lokasis', 'pemesananpembelians.KodeLokasi', '=', 'lokasis.KodeLokasi')
            ->join('matauangs', 'pemesananpembelians.KodeMataUang', '=', 'matauangs.KodeMataUang')
            ->join('suppliers', 'pemesananpembelians.KodeSupplier', '=', 'suppliers.KodeSupplier')
            ->select('pemesananpembelians.*', 'lokasis.NamaLokasi', 'matauangs.NamaMataUang', 'suppliers.NamaSupplier')
            ->where('pemesananpembelians.Status', 'OPN')
            ->get();

        // $start_date = (!empty($_GET["start_date"])) ? ($_GET["start_date"]) : ('');
        // $end_date = (!empty($_GET["end_date"])) ? ($_GET["end_date"]) : ('');

        // if ($start_date && $end_date) {

        //     $start_date = date('Y-m-d', strtotime($start_date));
        //     $end_date = date('Y-m-d', strtotime($end_date));

        //     $pemesananpembelian->whereRaw("date(pemesananpembelians.created_at) >= '" . $start_date . "' AND date(pemesananpembelians.created_at) <= '" . $end_date . "'");
        // }
        // $popembelian = $pemesananpembelian->select('*');

        return Datatables::of($pemesananpembelian)
            ->addColumn('action', function ($pemesananpembelian) {
                // url('/popembelian/show/'.$pemesananpembelian->KodePO)
                return '<a href="/popembelian/show/' . $pemesananpembelian->KodePO . '" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-eye-open"></i></a> ';
            })->make(true);
    }

    public function apiCFM()
    {
        $pemesananpembelian = DB::table('pemesananpembelians')
            ->join('lokasis', 'pemesananpembelians.KodeLokasi', '=', 'lokasis.KodeLokasi')
            ->join('matauangs', 'pemesananpembelians.KodeMataUang', '=', 'matauangs.KodeMataUang')
            ->join('suppliers', 'pemesananpembelians.KodeSupplier', '=', 'suppliers.KodeSupplier')
            ->select('pemesananpembelians.*', 'lokasis.NamaLokasi', 'matauangs.NamaMataUang', 'suppliers.NamaSupplier')
            ->where('pemesananpembelians.Status', 'CFM')
            ->get();

        return Datatables::of($pemesananpembelian)
            ->addColumn('action', function ($pemesananpembelian) {
                return '<a href="/popembelian/lihat/' . $pemesananpembelian->KodePO . '" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-eye-open"></i></a> ';
            })->make(true);
    }

    public function apiDEL()
    {
        $pemesananpembelian = DB::table('pemesananpembelians')
            ->join('lokasis', 'pemesananpembelians.KodeLokasi', '=', 'lokasis.KodeLokasi')
            ->join('matauangs', 'pemesananpembelians.KodeMataUang', '=', 'matauangs.KodeMataUang')
            ->join('suppliers', 'pemesananpembelians.KodeSupplier', '=', 'suppliers.KodeSupplier')
            ->select('pemesananpembelians.*', 'lokasis.NamaLokasi', 'matauangs.NamaMataUang', 'suppliers.NamaSupplier')
            ->where('pemesananpembelians.Status', 'DEL')
            ->get();

        return Datatables::of($pemesananpembelian)
            ->addColumn('action', function ($pemesananpembelian) {
                return '<a href="/popembelian/lihat/' . $pemesananpembelian->KodePO . '" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-eye-open"></i></a> ';
            })->make(true);
    }

    public function apiCLS()
    {
        $pemesananpembelian = DB::table('pemesananpembelians')
            ->join('lokasis', 'pemesananpembelians.KodeLokasi', '=', 'lokasis.KodeLokasi')
            ->join('matauangs', 'pemesananpembelians.KodeMataUang', '=', 'matauangs.KodeMataUang')
            ->join('suppliers', 'pemesananpembelians.KodeSupplier', '=', 'suppliers.KodeSupplier')
            ->join('penerimaanbarangs', 'pemesananpembelians.KodePO', '=', 'penerimaanBarangs.KodePO')
            ->select('pemesananpembelians.*', 'lokasis.NamaLokasi', 'matauangs.NamaMataUang', 'suppliers.NamaSupplier', 'penerimaanbarangs.Tanggal as TanggalDiterima')
            ->where('pemesananpembelians.Status', 'CLS')
            ->get();

        return Datatables::of($pemesananpembelian)
            ->addColumn('action', function ($pemesananpembelian) {
                // return '<a href="url('')" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-eye-open"></i></a> ';
                return '<a href="/popembelian/lihat/' . $pemesananpembelian->KodePO . '" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-eye-open"></i></a> ';
            })->make(true);
    }

    public function confirm(Request $request, $id)
    {
        DB::table('pemesananpembelians')
            ->where('KodePO', $id)
            ->update(['Status' => "CFM"]);
        return redirect('/pokonfirmasi');
    }

    public function cancel(Request $request, $id)
    {
        DB::table('pemesananpembelians')
            ->where('KodePO', $id)
            ->update(['Status' => "DEL"]);
        return redirect('/pobatal');
    }

    public function konfirmasiPembelian()
    {
        $pemesananpembelian = DB::table('pemesananpembelians')
            ->where('Status', 'CFM')->get();
        return view('pemesananPembelian.konfirmasi', ['pemesananpembelian' => $pemesananpembelian]);
    }

    public function batalPembelian()
    {
        $pemesananpembelian = DB::table('pemesananpembelians')
            ->where('Status', 'DEL')->get();
        return view('pemesananPembelian.batal', ['pemesananpembelian' => $pemesananpembelian]);
    }

    public function diterimaPembelian()
    {
        $pemesananpembelian = DB::table('pemesananpembelians')
            ->where('Status', 'CLS')->get();
        return view('pemesananPembelian.diterima', ['pemesananpembelian' => $pemesananpembelian]);
    }
}
