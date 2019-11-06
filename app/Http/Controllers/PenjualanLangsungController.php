<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use App\Model\penjualanLangsung;

class PenjualanLangsungController extends Controller
{
    public function index(){
    	$pemesananpembelian = DB::table('pemesananpembelians')->get();
        $matauang = DB::table('matauangs')->get();
        $lokasi = DB::table('lokasis')->get();
        $pelanggan = DB::table('pelanggans')->get();
        $item = DB::select("SELECT s.KodeItem, s.NamaItem, k.HargaJual, t.NamaSatuan, s.Keterangan FROM items s
            inner join itemkonversis k on k.KodeItem = s.KodeItem
            inner join satuans t on k.KodeSatuan = t.KodeSatuan where s.jenisitem='bahanbaku' ");
        $last_id = DB::select('SELECT * FROM penjualanlangsungs ORDER BY KodePenjualanLangsung DESC LIMIT 1');

        $year_now = date('y');
        $month_now = date('m');
        $date_now = date('d');

        if ($last_id == null) {
            $newID = "DJB-" . $year_now . $month_now . "0001";
        } else {
            $string = $last_id[0]->KodePenjualanLangsung;
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
            $newID = "DJB-" . $year_now . $month_now . $newID;

        }
        return view('penjualanLangsung.add', [
            'newID' => $newID,
            'pemesananpembelian' => $pemesananpembelian,
            'matauang' => $matauang,
            'lokasi' => $lokasi,
            'pelanggan' => $pelanggan,
            'item' => $item
        ]);
    }

    public function create(Request $request){
    	DB::table('penjualanlangsungs')->insert([
            'KodePenjualanLangsung' => $request->KodeSO,
            'Tanggal' => $request->Tanggal,
            'KodeLokasi' => $request->KodeLokasi,
            'KodeMataUang' => $request->KodeMataUang,
            'Status' => 'CLS',
            'KodeUser' => 'Admin',
            'Total' => $request->subtotal,
            'PPN' => $request->ppn,
            'NilaiPPN'=>$request->ppnval,
            'Printed'=>0,
            'Diskon'=>$request->diskon,
            'NilaiDiskon'=>$request->diskonval,
            'Subtotal'=>$request->subtotal-$request->ppnval,
            'KodePelanggan' => $request->KodePelanggan,
			'NoIndeks' => 0,
			'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        $items = $request->item;
        $qtys = $request->qty;
        $prices = $request->price;
        $totals = $request->total;
        foreach ($items as $key => $value) {
            DB::table('penjualanlangsungdetails')->insert([
                'KodePenjualanLangsung' => $request->KodeSO,
                'KodeItem'=>$items[$key],
                'KodeSatuan'=>'',
                'Qty' => $qtys[$key],
                'Harga' => $prices[$key],
                'Keterangan'=>$request->Keterangan,
                'Diskon'=>0,
            	'NilaiDiskon'=>0,
                'NoUrut' => 0,
                'Subtotal' => $totals[$key],
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]);

        }
        return redirect('/penjualanLangsung');
    }

    public function retriveData()
    {
        $penjualanlangsung = DB::table('penjualanlangsungs')
        ->join('matauangs','penjualanlangsungs.KodeMataUang','=','matauangs.KodeMataUang')
        ->join('lokasis','penjualanlangsungs.KodeLokasi','=','lokasis.KodeLokasi')
        ->join('pelanggans','penjualanlangsungs.KodePelanggan','=','pelanggans.KodePelanggan')
        ->select('penjualanlangsungs.*','matauangs.NamaMataUang','lokasis.NamaLokasi','pelanggans.NamaPelanggan')
        ->get();
        return view('penjualanLangsung.penjualanLangsung',compact('penjualanlangsung'));
    }
}
