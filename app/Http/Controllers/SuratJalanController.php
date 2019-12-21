<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Model\suratjalan;
use App\Model\karyawan;
use App\Model\pemesananpenjualan;
use App\Model\matauang;
use App\Model\lokasi;
use App\Model\pelanggan;
use Carbon\Carbon;
use PDF;
use App\Model\invoicepiutang;


class SuratJalanController extends Controller
{

    public function index()
    {
        //$suratjalans = suratjalan::where('Status','OPN')->get();
        $suratjalans = suratjalan::join('lokasis','lokasis.KodeLokasi','=','suratjalans.KodeLokasi')
        ->join('pelanggans','pelanggans.KodePelanggan','=','suratjalans.KodePelanggan')
        ->select('suratjalans.KodeSuratJalanID','suratjalans.KodeSO','suratjalans.Status','suratjalans.Tanggal','lokasis.NamaLokasi','pelanggans.NamaPelanggan')
        ->get();
        $suratjalans = $suratjalans->where('Status','OPN');
        $suratjalans->all();
        return view('suratJalan.suratJalan',compact('suratjalans'));
    }

    public function filterData(Request $request)
    {
        $start = $request->get('start');
        $end = $request->get('end');
        //dd($start,$end);
        $result = suratjalan::where('Status','OPN')->get();
        $suratjalans = $result->whereBetween('Tanggal',[$start.' 00:00:00', $end.' 00:00:00']);
        $suratjalans->all();
        return view('suratJalan.suratJalan',compact('suratjalans','start','end'));
    }

    public function konfirmasiSuratJalan()
    {
        $suratjalans = suratjalan::where('Status','CFM')->get();
        return view('suratJalan.konfirmasiSuratJalan',compact('suratjalans'));
    }

    public function filterKonfirmasiSuratJalan(Request $request)
    {
        $start = $request->get('start');
        $end = $request->get('end');
        // dd($start,$end);
        $result = suratjalan::where('Status','CFM')->get();
        $suratjalans = $result->whereBetween('Tanggal',[$start.' 00:00:00', $end.' 00:00:00']);
        $suratjalans->all();
        return view('suratJalan.suratJalan',compact('suratjalans','start','end'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $drivers = karyawan::where('jabatan','driver')->get();
        $pemesananpenjualan =DB::select("select DISTINCT a.KodeSO from (
            sELECT DISTINCT a.KodeSO,COALESCE(SUM(a.qty),0)/coalesce(NULLIF(COUNT(sj.KodeSO), 0),1)-COALESCE(SUM(sjd.qty),0) as jml FROM pemesanan_penjualan_detail a inner join items i on a.KodeItem = i.KodeItem inner join itemkonversis k on i.KodeItem = k.KodeItem inner join satuans s on s.KodeSatuan = k.KodeSatuan
                        left join suratjalans sj on sj.KodeSO = a.KodeSO
                        left join suratjalandetails sjd on sjd.KodeSuratJalan = sj.KodeSuratJalan and sjd.KodeItem = a.KodeItem
                        GROUP by a.KodeSO, a.KodeItem
                        having jml>0 ) as a");
        if ($id=="0"){
            if(count($pemesananpenjualan) <=0 ){
                return redirect('/sopenjualan/create');
            }
            $id = $pemesananpenjualan[0]->KodeSO;
        }
        $pelanggans = DB::table('pelanggans')->get();
        $lokasis = DB::table('lokasis')->get();
        $items = DB::select("sELECT a.KodeItem,i.NamaItem, COALESCE(a.qty,0)-COALESCE(SUM(sjd.qty),0) as jml, i.Keterangan, s.NamaSatuan, k.HargaJual FROM pemesanan_penjualan_detail a inner join items i on a.KodeItem = i.KodeItem inner join itemkonversis k on i.KodeItem = k.KodeItem inner join satuans s on s.KodeSatuan = k.KodeSatuan
            left join suratjalans sj on sj.KodeSO = a.KodeSO
            left join suratjalandetails sjd on sjd.KodeSuratJalan = sj.KodeSuratJalan and sjd.KodeItem = a.KodeItem
            where a.KodeSO='".$id."' group by a.KodeItem, i.Keterangan, s.NamaSatuan, k.HargaJual, i.NamaItem, a.qty
            having jml >0");
        $so =pemesananpenjualan::where('KodeSO',$id)->first();
        $matauang = DB::table('matauangs')->get();
        return view('suratJalan.buatSuratJalan', compact('pemesananpenjualan', 'id', 'pelanggans', 'lokasis','drivers','items','so','matauang'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$id)
    {
        $last_id = DB::select('SELECT * FROM suratjalans ORDER BY KodeSuratJalanID DESC LIMIT 1');

        $year_now = date('y');
        $month_now = date('m');
        $date_now = date('d');
        $pref = "SJ";
        if($request->ppn=='ya'){
            $pref = "SJT";
        }
        if ($last_id == null) {
            $newID = $pref."-" . $year_now . $month_now . "0001";
        } else {
            $string = $last_id[0]->KodeSuratJalan;
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

            $newID = $pref."-" . $year_now . $month_now . $newID;
        }
        DB::table('suratjalans')->insert([
            'KodeSuratJalan' => $newID,
            'Tanggal' => $request->Tanggal,
            'KodeLokasi' => $request->KodeLokasi,
            'KodeMataUang' => $request->KodeMataUang,
            'Status' => 'OPN',
            'KodeUser' => 'Admin',
            'Total' => 0,
            'PPN' => $request->ppn,
            'NilaiPPN'=>$request->ppnval,
            'KodePelanggan' => $request->KodePelanggan,
            'Printed'=>0,
            'Diskon'=>$request->diskon,
            'NilaiDiskon'=>$request->diskonval,
            'Subtotal'=>$request->subtotal,
            'NoIndeks'=>0,
            'Nopol'=>$request->nopol,
            'KodeSO'=>$request->KodeSO,
            'KodeSopir'=>$request->KodeSopir,
            'Alamat'=>$request->Alamat,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        $items = $request->item;
        $qtys = $request->qty;
        foreach ($items as $key => $value) {
            DB::table('suratjalandetails')->insert([
                'KodeSuratJalan' => $newID,
                'KodeItem'=>$items[$key],
                'Qty' => $qtys[$key],
                'NoUrut' => 0,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]);

        }

        return redirect('/suratJalan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $suratjalan = suratjalan::where('KodeSuratJalanID',$id)->first();
        $driver = karyawan::where('IDKaryawan',$suratjalan->KodeSopir)->first();
        $matauang = matauang::where('KodeMataUang',$suratjalan->KodeMataUang)->first();
        $lokasi = lokasi::where('KodeLokasi',$suratjalan->KodeLokasi)->first();
        $pelanggan = pelanggan::where('KodePelanggan',$suratjalan->KodePelanggan)->first();
        $items = DB::select("sELECT a.KodeItem,i.NamaItem, SUM(a.Qty) as jml, i.Keterangan, s.NamaSatuan, k.HargaJual FROM suratjalandetails a inner join items i on a.KodeItem = i.KodeItem inner join itemkonversis k on i.KodeItem = k.KodeItem inner join satuans s on s.KodeSatuan = k.KodeSatuan where a.KodeSuratJalan='".$suratjalan->KodeSuratJalan."' group by a.KodeItem, i.Keterangan, s.NamaSatuan, k.HargaJual, i.NamaItem ");
        return view('suratJalan.showSuratJalan', compact('id','suratjalan','driver','matauang','lokasi','pelanggan','items'));
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

        $data = suratjalan::where('KodeSuratJalanID',$id)->first();
        $data->Status = "CFM";
        $data->save();
        $so = pemesananpenjualan::find($data->KodeSO);
        $items = DB::select("sELECT a.KodeItem,i.NamaItem, SUM(a.Qty) as jml, i.Keterangan, s.NamaSatuan, k.HargaJual FROM suratjalandetails a inner join items i on a.KodeItem = i.KodeItem inner join itemkonversis k on i.KodeItem = k.KodeItem inner join satuans s on s.KodeSatuan = k.KodeSatuan where a.KodeSuratJalan='".$data->KodeSuratJalan."' group by a.KodeItem, i.Keterangan, s.NamaSatuan, k.HargaJual, i.NamaItem ");

        $last_id = DB::select('SELECT * FROM invoicepiutangs ORDER BY KodeInvoicePiutang DESC LIMIT 1');

        $year_now = date('y');
        $month_now = date('m');
        $date_now = date('d');
        $pref = "IVP";
        if ($last_id == null) {
            $newID = $pref."-" . $year_now . $month_now . "0001";
        } else {
            $string = $last_id[0]->KodeInvoicePiutangShow;
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

            $newID = $pref."-" . $year_now . $month_now . $newID;
        }

        $lastID =DB::table('invoicepiutangs')->insertGetId([
            'Tanggal' => $data->Tanggal,
            'KodePelanggan' => $data->KodePelanggan,
            'Status' => 'CFM',
            'Total' => $so->Total,
            'Keterangan' => $so->keterangan,
            'KodeMataUang' => $data->KodeMataUang,
            'KodeUser' => 'Admin',
            'Term' => $so->term,
            'KodeLokasi' => $data->KodeLokasi,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
            'KodeInvoicePiutangShow'=>$newID,
        ]);

        DB::table('invoicepiutangdetails')->insert([
            'KodePiutang'=>$lastID,
            'KodeSuratJalan' => $data->KodeSuratJalanID,
            'Subtotal' => $data->Subtotal,
            'KodeInvoicePiutang' => $lastID,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        $last_id = DB::select('SELECT * FROM stokkeluars ORDER BY KodeStokKeluar DESC LIMIT 1');

        $year_now = date('y');
        $month_now = date('m');
        $date_now = date('d');

        if ($last_id == null) {
            $newID = "SLM-" . $year_now . $month_now . "0001";
        } else {
            $string = $last_id[0]->KodeStokKeluar;
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

            $newID = "SLM-" . $year_now . $month_now . $newID;
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
                'JenisTransaksi'=>'SJB',
                'KodeTransaksi'=>$data->KodeSuratJalan,
                'Qty' => -$value->jml,
                'HargaRata'=>0,
                'KodeUser'=>'Admin',
                'idx'=>0,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ]);
        }

        return redirect('/konfirmasisuratJalan');
    }

    public function view($id)
    {
        $suratjalan = suratjalan::where('KodeSuratJalanID',$id)->first();
        $driver = karyawan::where('IDKaryawan',$suratjalan->KodeSopir)->first();
        $matauang = matauang::where('KodeMataUang',$suratjalan->KodeMataUang)->first();
        $lokasi = lokasi::where('KodeLokasi',$suratjalan->KodeLokasi)->first();
        $pelanggan = pelanggan::where('KodePelanggan',$suratjalan->KodePelanggan)->first();
        $items = DB::select("sELECT a.KodeItem,i.NamaItem, SUM(a.Qty) as jml, i.Keterangan, s.NamaSatuan, k.HargaJual FROM suratjalandetails a inner join items i on a.KodeItem = i.KodeItem inner join itemkonversis k on i.KodeItem = k.KodeItem inner join satuans s on s.KodeSatuan = k.KodeSatuan where a.KodeSuratJalan='".$suratjalan->KodeSuratJalan."' group by a.KodeItem, i.Keterangan, s.NamaSatuan, k.HargaJual, i.NamaItem ");
        return view('suratJalan.viewSuratJalan', compact('id','suratjalan','driver','matauang','lokasi','pelanggan','items'));
    }

    public function print($id)
    {

        $suratjalan = suratjalan::where('KodeSuratJalanID', $id)->first();
        $driver = karyawan::where('IDKaryawan', $suratjalan->KodeSopir)->first();
        $matauang = matauang::where('KodeMataUang', $suratjalan->KodeMataUang)->first();
        $lokasi = lokasi::where('KodeLokasi', $suratjalan->KodeLokasi)->first();
        $pelanggan = pelanggan::where('KodePelanggan', $suratjalan->KodePelanggan)->first();
        $items = DB::select("sELECT a.KodeItem,i.NamaItem, SUM(a.Qty) as jml,
        i.Keterangan, s.NamaSatuan, k.HargaJual FROM suratjalandetails a inner join items i
        on a.KodeItem = i.KodeItem inner join itemkonversis k on i.KodeItem = k.KodeItem
        inner join satuans s on s.KodeSatuan = k.KodeSatuan
        where a.KodeSuratJalan='".$suratjalan->KodeSuratJalan."
        ' group by a.KodeItem, i.Keterangan, s.NamaSatuan, k.HargaJual, i.NamaItem ");
        $items = DB::select("sELECT a.KodeItem,i.NamaItem,
        SUM(a.Qty) as jml, i.Keterangan, s.NamaSatuan, k.HargaJual FROM
        suratjalandetails a inner join items i on a.KodeItem = i.KodeItem
        inner join itemkonversis k on i.KodeItem = k.KodeItem
        inner join satuans s on s.KodeSatuan = k.KodeSatuan
        where a.KodeSuratJalan='" . $suratjalan->KodeSuratJalan . "'
        group by a.KodeItem, i.Keterangan, s.NamaSatuan, k.HargaJual, i.NamaItem ");

        $pdf = PDF::loadview('suratJalan.pdf', compact('suratjalan', 'driver', 'matauang', 'lokasi', 'pelanggan', 'items'));
        // ob_end_clean();
        //->setPaper('a5', 'landscape');
        return $pdf->stream();
    }

    public function fixInvoideID(){
        $i =invoicepiutang::where('KodeInvoicePiutangShow','')->get();
        $last_id =null;
        foreach($i as $is){
            $year_now = Carbon::parse($is->Tanggal)->format('y');
            $month_now = Carbon::parse($is->Tanggal)->format('m');
            $date_now = Carbon::parse($is->Tanggal)->format('d');
            if ($last_id == null) {
                $newID = "IVP-" . $year_now . $month_now . "0001";
                $is->KodeInvoicePiutangShow = $newID;
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

                $newID = "IVP-" . $year_now . $month_now . $newID;
                $is->KodeInvoicePiutangShow = $newID;
                $is->save();
            }
            $last_id = $newID;
        }
    }
}
