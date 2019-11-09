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
use App\Model\suratjalanreturn;
use App\Model\invoicepiutangdetail;
use PDF;

class ReturnSuratJalanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function add($id)
    {
        $sj =DB::select("select DISTINCT a.KodeSuratJalan,a.KodeSuratJalanID from (
sELECT sj.KodeSuratJalanID,a.KodeSuratJalan,a.KodeItem, COALESCE(SUM(a.qty),0)/coalesce(NULLIF(COUNT(sjr.KodeSuratJalanReturnId), 0),1)-COALESCE(SUM(sjrd.Qty),0) as jml
FROM suratjalandetails a inner join items i on a.KodeItem = i.KodeItem
            inner join suratjalans sj on sj.KodeSuratJalan = a.KodeSuratJalan and sj.Status='CFM'
            left join suratjalanreturns sjr on sjr.KodeSuratJalanId = sj.KodeSuratJalanID
            left join suratjalanreturndetails sjrd on sjrd.KodeSuratJalanReturn = sjr.KodeSuratJalanReturn
            group by a.KodeItem, i.Keterangan, a.KodeSuratJalan, sj.KodeSuratJalanID
            having jml >0) a");
        if ($id=="0"){
            if(count($sj) <=0 ){
                return redirect('/suratJalan/create/0');
            }
            $id = $sj[0]->KodeSuratJalanID;
        }
        $items = DB::select("sELECT a.KodeItem,i.NamaItem, COALESCE(SUM(a.qty),0)/coalesce(NULLIF(COUNT(sjr.KodeSuratJalanReturnId), 0),1)-COALESCE(SUM(sjrd.Qty),0) as jml, i.Keterangan, s.NamaSatuan, k.HargaJual
FROM suratjalandetails a inner join items i on a.KodeItem = i.KodeItem inner join itemkonversis k on i.KodeItem = k.KodeItem inner join satuans s on s.KodeSatuan = k.KodeSatuan
            left join suratjalans sj on sj.KodeSuratJalan = a.KodeSuratJalan
            left join suratjalanreturns sjr on sjr.KodeSuratJalanId = sj.KodeSuratJalanID
            left join suratjalanreturndetails sjrd on sjrd.KodeSuratJalanReturn = sjr.KodeSuratJalanReturn
            where sj.KodeSuratJalanID='".$id."' group by a.KodeItem, i.Keterangan, s.NamaSatuan, k.HargaJual, i.NamaItem
            having jml >0");
        $so =DB::select("select so.* from suratjalans sj inner join pemesananpenjualans so on so.KodeSO = sj.KodeSO where sj.KodeSuratJalanID='".$id."'")[0];
        $sjDet = suratjalan::where('KodeSuratJalanID',$id)->first();
        return view('returnSuratJalan.add', compact('sj', 'id','items','so','sjDet'));
    }

    public function store(Request $request,$id)
    {

        $last_id = DB::select('SELECT * FROM suratjalanreturns ORDER BY KodeSuratJalanReturnId DESC LIMIT 1');

        $year_now = date('y');
        $month_now = date('m');
        $date_now = date('d');
        $pref = "RSJ";
        if($request->ppn=='ya'){
            $pref = "RSJT";
        }
        if ($last_id == null) {
            $newID = $pref."-" . $year_now . $month_now . "0001";
        } else {
            $string = $last_id[0]->KodeSuratJalanReturn;
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
        DB::table('suratjalanreturns')->insert([
            'KodeSuratJalanId' => $request->KodeSJ,
            'Tanggal' => $request->Tanggal,
            'Status' => 'OPN',
            'KodeUser' => 'Admin',
            'Total' => $request->total,
            'PPN' => $request->ppn,
            'NilaiPPN'=>$request->ppnval,
            'Printed'=>0,
            'Diskon'=>$request->diskon,
            'NilaiDiskon'=>$request->diskonval,
            'Subtotal'=>$request->subtotal,
            'KodeSuratJalanReturn' => $newID,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        $items = $request->item;
        $qtys = $request->qty;
        foreach ($items as $key => $value) {
            DB::table('suratjalanreturndetails')->insert([
                'KodeSuratJalanReturn' => $newID,
                'KodeItem'=>$items[$key],
                'Qty' => $qtys[$key],
                'NoUrut' => 0,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]);

        }

        return redirect('/returnSuratJalan');
    }



    public function index()
    {
        $suratjalanreturns = suratjalanreturn::where('Status','OPN')->get();
        return view('returnSuratJalan.index',compact('suratjalanreturns'));
    }

    public function filterData(Request $request)
    {
        $start = $request->get('start');
        $end = $request->get('end');
        // dd($start,$end);
        $result = suratjalanreturn::where('Status','OPN')->get();
        $suratjalanreturns = $result->whereDate('Tanggal',[$start.' 00:00:00',$end.' 00:00:00']);
        $suratjalanreturns->all();
        return view('returnSuratJalan.index',compact('suratjalanreturns','start','end'));
    }

    public function show($id)
    {
        $suratjalanreturn = suratjalanreturn::where('KodeSuratJalanReturnId',$id)->first();
        $suratjalan = suratjalan::where('KodeSuratJalanID',$suratjalanreturn->KodeSuratJalanId)->first();
        $driver = karyawan::where('IDKaryawan',$suratjalan->KodeSopir)->first();
        $matauang = matauang::where('KodeMataUang',$suratjalan->KodeMataUang)->first();
        $lokasi = lokasi::where('KodeLokasi',$suratjalan->KodeLokasi)->first();
        $pelanggan = pelanggan::where('KodePelanggan',$suratjalan->KodePelanggan)->first();
        $items = DB::select("sELECT a.KodeItem,i.NamaItem, SUM(a.Qty) as jml, i.Keterangan, s.NamaSatuan, k.HargaJual
            FROM suratjalanreturndetails a
            inner join suratjalanreturns b on a.KodeSuratJalanReturn = b.KodeSuratJalanReturn
            inner join items i on a.KodeItem = i.KodeItem inner join itemkonversis k on i.KodeItem = k.KodeItem inner join satuans s on s.KodeSatuan = k.KodeSatuan where b.KodeSuratJalanReturnId='".$id."' group by a.KodeItem, i.Keterangan, s.NamaSatuan, k.HargaJual, i.NamaItem ");
        return view('returnSuratJalan.show', compact('id','suratjalanreturn','driver','matauang','lokasi','pelanggan','items','suratjalan'));
    }

    public function confirm($id)
    {
        $suratjalanreturn = suratjalanreturn::where('KodeSuratJalanReturnId',$id)->first();
        $suratjalanreturn->Status = "CFM";
        $suratjalanreturn->save();
        $suratjalan = suratjalan::where('KodeSuratJalanID',$suratjalanreturn->KodeSuratJalanId)->first();
        $invoice = invoicepiutangdetail::where('KodeSuratJalan',$suratjalanreturn->KodeSuratJalanId)->first();
        $now = $invoice->Subtotal;
        $invoice->Subtotal = $now - $suratjalanreturn->Total;
        $invoice->save();
        $invoMaster = $invoice->invoicepiutang;
        $now = $invoMaster->Total;
        $invoMaster->Total = $now - $suratjalanreturn->Total;
        $invoMaster->save();
        $items = DB::select("sELECT a.KodeItem,i.NamaItem, SUM(a.Qty) as jml, i.Keterangan, s.NamaSatuan, k.HargaJual FROM suratjalanreturndetails a inner join suratjalanreturns sj on a.KodeSuratJalanReturn = sj.KodeSuratJalanReturn inner join items i on a.KodeItem = i.KodeItem inner join itemkonversis k on i.KodeItem = k.KodeItem inner join satuans s on s.KodeSatuan = k.KodeSatuan where sj.KodeSuratJalanReturnId=".$id." group by a.KodeItem, i.Keterangan, s.NamaSatuan, k.HargaJual, i.NamaItem ");
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
                'Tanggal' => $suratjalanreturn->Tanggal,
                'KodeLokasi' => $suratjalan->KodeLokasi,
                'KodeItem' => $value->KodeItem,
                'JenisTransaksi'=>'SJB',
                'KodeTransaksi'=>$suratjalanreturn->KodeSuratJalanReturn,
                'Qty' => $value->jml,
                'HargaRata'=>0,
                'KodeUser'=>'Admin',
                'idx'=>0,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ]);
        }

        return redirect('/konfirmasireturnSuratJalan');
    }

    public function konfirmasiSuratJalanReturn()
    {
        $suratjalanreturns = suratjalanreturn::where('Status','CFM')->get();
        return view('returnSuratJalan.listkonfirmasi',compact('suratjalanreturns'));
    }

    public function filterKonfirmasiSuratJalanReturn(Request $request)
    {
      $start = $request->get('start');
      $end = $request->get('end');
      // dd($start,$end);
      $result = suratjalanreturn::where('Status','OPN')->get();
      $suratjalanreturns = $result->whereDate('Tanggal',[$start.' 00:00:00',$end.' 00:00:00']);
      $suratjalanreturns->all();
      return view('returnSuratJalan.listkonfirmasi',compact('suratjalanreturns'));
    }

    public function view($id)
    {
        $suratjalanreturn = suratjalanreturn::where('KodeSuratJalanReturnId',$id)->first();
        $suratjalan = suratjalan::where('KodeSuratJalanID',$suratjalanreturn->KodeSuratJalanId)->first();
        $driver = karyawan::where('IDKaryawan',$suratjalan->KodeSopir)->first();
        $matauang = matauang::where('KodeMataUang',$suratjalan->KodeMataUang)->first();
        $lokasi = lokasi::where('KodeLokasi',$suratjalan->KodeLokasi)->first();
        $pelanggan = pelanggan::where('KodePelanggan',$suratjalan->KodePelanggan)->first();
        $items = DB::select("sELECT a.KodeItem,i.NamaItem, SUM(a.Qty) as jml, i.Keterangan, s.NamaSatuan, k.HargaJual
            FROM suratjalanreturndetails a
            inner join suratjalanreturns b on a.KodeSuratJalanReturn = b.KodeSuratJalanReturn
            inner join items i on a.KodeItem = i.KodeItem inner join itemkonversis k on i.KodeItem = k.KodeItem inner join satuans s on s.KodeSatuan = k.KodeSatuan where b.KodeSuratJalanReturnId='".$id."' group by a.KodeItem, i.Keterangan, s.NamaSatuan, k.HargaJual, i.NamaItem ");
        return view('returnSuratJalan.view', compact('id','suratjalanreturn','driver','matauang','lokasi','pelanggan','items','suratjalan'));
    }

    public function print($id)
    {
        $data =
        DB::select("select sj.*,a.*,b.Keterangan from suratjalanreturns a
            left join suratjalans sj on sj.KodeSuratJalanID = a.KodeSuratJalanId
            left join pemesananpenjualans b on sj.KodeSO = b.KodeSO  where a.KodeSuratJalanReturnId = '".$id."'")[0];
        // suratjalan::where('KodeSuratJalanID',$id)->first();
        $items = DB::select("sELECT a.KodeItem,i.NamaItem, SUM(a.Qty) as jml, i.Keterangan, s.NamaSatuan, k.HargaJual FROM suratjalanreturndetails a inner join items i on a.KodeItem = i.KodeItem inner join itemkonversis k on i.KodeItem = k.KodeItem inner join satuans s on s.KodeSatuan = k.KodeSatuan where a.KodeSuratJalanReturn='".$data->KodeSuratJalanReturn."' group by a.KodeItem, i.Keterangan, s.NamaSatuan, k.HargaJual, i.NamaItem ");
        $jml = 0;
        foreach ($items as $value) {
            $jml += $value->jml;
        }
        // dd($data);
        $data->Tanggal = Carbon::parse($data->Tanggal)->format('d/m/Y');
        // $data->tgl_kirim = Carbon::parse($data->tgl_kirim)->format('d/m/Y');

        $pdf = PDF::loadview('returnSuratJalan.print',compact('data', 'id', 'items', 'jml'));

        return $pdf->download('returnSuratJalan.pdf');
    }





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






}
