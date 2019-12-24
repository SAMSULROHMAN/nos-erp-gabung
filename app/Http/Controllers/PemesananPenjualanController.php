<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\pemesananpenjualan;
use App\Model\pemesananpembelian;
use App\Model\lokasi;
use App\Model\matauang;
use App\Model\pelanggan;
use App\Model\item;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use PDF;

class PemesananPenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pemesananpenjualan = pemesananpenjualan::join('lokasis','lokasis.KodeLokasi','=','pemesananpenjualans.KodeLokasi')
        ->join('matauangs','matauangs.KodeMataUang','=','pemesananpenjualans.KodeMataUang')
        ->join('pelanggans','pelanggans.KodePelanggan','=','pemesananpenjualans.KodePelanggan')
        ->select('pemesananpenjualans.*','lokasis.NamaLokasi','matauangs.NamaMataUang','pelanggans.NamaPelanggan')
        ->get();
        $pemesananpenjualan = $pemesananpenjualan->where('Status','OPN');
        $pemesananpenjualan->all();
        return view('pemesananPenjualan.pemesananPenjualan',compact('pemesananpenjualan'));
    }

    public function filterData(Request $request)
    {
      $search = $request->get('name');
      $start = $request->get('mulai');
      $end = $request->get('sampai');
      $pemesananpenjualan = pemesananpenjualan::join('pelanggans', 'pelanggans.KodePelanggan', '=', 'pemesananpenjualans.KodePelanggan')
        ->Where('pemesananpenjualans.Status','OPN')
        ->Where(function($query) use ($search){
          $query->Where('pelanggans.NamaPelanggan','LIKE',"%$search%")
            ->orWhere('pemesananpenjualans.KodeSO','LIKE',"%$search%");
        })->get();
      if($start && $end){
        $pemesananpenjualan = $pemesananpenjualan->whereBetween('Tanggal', [$start . ' 00:00:00', $end . ' 00:00:00']);
      }else{
        $pemesananpenjualan->all();
      }
      return view('pemesananPenjualan.pemesananPenjualan', compact('pemesananpenjualan', 'mulai', 'sampai'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pemesananpembelian = DB::table('pemesananpembelians')->get();
        $matauang = DB::table('matauangs')->get();
        $lokasi = DB::table('lokasis')->get();
        $pelanggan = DB::table('pelanggans')->get();
        $item = DB::select("SELECT s.KodeItem, s.NamaItem, t.JumlahSatuan, t.NamaKemasan, k.HargaJual, t.NamaSatuan, s.Keterangan FROM items s
              inner join itemkonversis k on k.KodeItem = s.KodeItem
              inner join satuans t on k.KodeSatuan = t.KodeSatuan where s.jenisitem='bahanbaku' ");
        $last_id = DB::select('SELECT * FROM pemesananpenjualans ORDER BY KodeSO DESC LIMIT 1');


      $year_now = date('y');
        $month_now = date('m');
        $date_now = date('d');

        if ($last_id == null) {
            $newID = "SO-" . $year_now . $month_now . "0001";
            $newIDP = "SOT-" . $year_now . $month_now . "0001";
        } else {
            $string = $last_id[0]->KodeSO;
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
            $newIDP = "SOT-" . $year_now . $month_now . $newID;
            $newID = "SO-" . $year_now . $month_now . $newID;

        }

        return view('pemesananPenjualan.buatPenjualan', [
            'newID' => $newID,
            'newIDP' => $newIDP,
            'pemesananpembelian' => $pemesananpembelian,
            'matauang' => $matauang,
            'lokasi' => $lokasi,
            'pelanggan' => $pelanggan,
            'item' => $item
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
        //     'KodeSO' => 'required',
        //     'Tanggal' => 'required',
        //     'TanggalKirim' => 'required',
        //     'Expired' => 'required',
        //     'KodeMataUang' => 'required',
        //     'KodeLokasi' => 'required',
        //     'KodePelanggan' => 'required',
        //     'Term' => 'required',
        // ]);

        DB::table('pemesananpenjualans')->insert([
            'KodeSO' => $request->KodeSO,
            'Tanggal' => $request->Tanggal,
            'tgl_kirim' => $request->TanggalKirim,
            'Expired' => $request->Expired,
            'KodeLokasi' => $request->KodeLokasi,
            'KodeMataUang' => $request->KodeMataUang,
            'KodePelanggan' => $request->KodePelanggan,
            'Term' => $request->Term,
            'Keterangan' => $request->Keterangan,
            'Status' => 'OPN',
            'KodeUser' => 'Admin',
            'Total' => $request->subtotal,
            'PPN' => $request->ppn,
            'NilaiPPN'=>$request->ppnval,
            'Printed'=>0,
            'Diskon'=>$request->diskon,
            'NilaiDiskon'=>$request->diskonval,
            'Subtotal'=>$request->subtotal-$request->ppnval,
            'KodeSales'=>0,
            'POPelanggan'=>$request->po,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        $items = $request->item;
        // dd($items);
        $qtys = $request->qty;
        $prices = $request->price;
        $totals = $request->total;
        // dd($items,$qtys,$prices,$totals);
        foreach ($items as $key => $value) {
            DB::table('pemesanan_penjualan_detail')->insert([
                'KodeSO' => $request->KodeSO,
                'KodeItem'=> $items[$key],
                'Qty' => $qtys[$key],
                'Harga' => $prices[$key],
                'NoUrut' => 0,
                'Subtotal' => $totals[$key],
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]);

         }
        return redirect('/sopenjualan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = DB::select("SELECT a.KodeSo, a.Tanggal, a.tgl_kirim,a.Expired,a.term, a.POPelanggan, b.NamaMataUang, c.NamaLokasi, d.NamaPelanggan, a.Keterangan, a.Diskon, a.PPN, a.Subtotal, a.NilaiPPN from pemesananpenjualans a
            inner join matauangs b on b.KodeMataUang = a.KodeMataUang
            inner join lokasis c on c.KodeLokasi = a.KodeLokasi
            inner join pelanggans d on d.KodePelanggan = a.KodePelanggan
            where a.KodeSO ='".$id."' limit 1")[0];
        $items = DB::select("SELECT a.Qty,b.NamaItem,d.NamaSatuan, a.Harga, a.Subtotal, b.Keterangan  from pemesanan_penjualan_detail a
            inner join items b on a.KodeItem = b.KodeItem
            inner join itemkonversis c on c.KodeItem = a.KodeItem
            inner join satuans d on c.KodeSatuan = d.KodeSatuan
            where a.KodeSO ='".$id."' ");
        // dd($items);
        $data->Tanggal = Carbon::parse($data->Tanggal)->format('d/m/Y');
        $data->tgl_kirim = Carbon::parse($data->tgl_kirim)->format('d/m/Y');
        return view('pemesananpenjualan.show', compact('data', 'id', 'items'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $matauang = DB::table('matauangs')->get();
        $lokasi = DB::table('lokasis')->get();
        $data = DB::select("SELECT a.KodeSo, a.Tanggal, a.tgl_kirim,a.Expired,a.term, a.POPelanggan, b.NamaMataUang, c.NamaLokasi, d.NamaPelanggan, a.Keterangan, a.Diskon, a.PPN, a.Subtotal, a.NilaiPPN, c.KodeLokasi, d.KodePelanggan, b.KodeMataUang from pemesananpenjualans a
            inner join matauangs b on b.KodeMataUang = a.KodeMataUang
            inner join lokasis c on c.KodeLokasi = a.KodeLokasi
            inner join pelanggans d on d.KodePelanggan = a.KodePelanggan
            where a.KodeSO ='".$id."' limit 1")[0];
        $items = DB::select("SELECT a.Qty,b.KodeItem,b.NamaItem,d.NamaSatuan, a.Harga, a.Subtotal, b.Keterangan  from pemesanan_penjualan_detail a
            inner join items b on a.KodeItem = b.KodeItem
            inner join itemkonversis c on c.KodeItem = a.KodeItem
            inner join satuans d on c.KodeSatuan = d.KodeSatuan
            where a.KodeSO ='".$id."' ");
        $itemSelect = DB::select("SELECT s.KodeItem, s.NamaItem, k.HargaJual, t.NamaSatuan, s.Keterangan FROM items s
            inner join itemkonversis k on k.KodeItem = s.KodeItem
            inner join satuans t on k.KodeSatuan = t.KodeSatuan where s.jenisitem='bahanbaku' ");
        // dd($items);
        $data->Tanggal = Carbon::parse($data->Tanggal)->format('Y-m-d');
        $data->tgl_kirim = Carbon::parse($data->tgl_kirim)->format('Y-m-d');
        $pelanggan = DB::table('pelanggans')->get();
        return view('pemesananpenjualan.edit', compact('data', 'id', 'items','itemSelect','lokasi', 'pelanggan','matauang'));
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

        DB::table('pemesanan_penjualan_detail')->where('KodeSO', '=', $request->KodeSO)->delete();
        $items = $request->item;
        $qtys = $request->qty;
        $prices = $request->price;
        $totals = $request->total;
        foreach ($items as $key => $value) {
            DB::table('pemesanan_penjualan_detail')->insert([
                'KodeSO' => $request->KodeSO,
                'KodeItem'=>$items[$key],
                'Qty' => $qtys[$key],
                'Harga' => $prices[$key],
                'NoUrut' => 0,
                'Subtotal' => $totals[$key],
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]);

        }
        DB::table('pemesananpenjualans')
        ->where('KodeSO', $request->KodeSO)->update([
            'Tanggal' => $request->Tanggal,
            'tgl_kirim' => $request->TanggalKirim,
            'Expired' => $request->Expired,
            'KodeLokasi' => $request->KodeLokasi,
            'KodeMataUang' => $request->KodeMataUang,
            'KodePelanggan' => $request->KodePelanggan,
            'Term' => $request->Term,
            'Keterangan' => $request->Keterangan,
            'Status' => 'OPN',
            'KodeUser' => 'Admin',
            'Total' => $request->subtotal,
            'PPN' => $request->ppn,
            'NilaiPPN'=>$request->ppnval,
            'Printed'=>0,
            'Diskon'=>$request->diskon,
            'NilaiDiskon'=>$request->diskonval,
            'Subtotal'=>$request->subtotal-$request->ppnval,
            'KodeSales'=>0,
            'POPelanggan'=>$request->po,
            'updated_at' => \Carbon\Carbon::now(),
        ]);
        return redirect('/sopenjualan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('pemesananpenjualans')->where('KodeSO', $id)->update([
          'Status' => 'DEL'
        ]);
        return redirect('/sopenjualan');
    }

    public function confirm(Request $request, $id)
    {
        $data = pemesananpenjualan::find($id);
        $data->Status = "CFM";
        $data->save();
        return redirect('/konfirmasipemesananPenjualan');
    }

    public function konfirmasiPenjualan(){
        //$pemesananpenjualan = pemesananpenjualan::all()->where('Status','CFM');
        $pemesananpenjualan = pemesananpenjualan::join('lokasis','lokasis.KodeLokasi','=','pemesananpenjualans.KodeLokasi')
        ->join('matauangs','matauangs.KodeMataUang','=','pemesananpenjualans.KodeMataUang')
        ->join('pelanggans','pelanggans.KodePelanggan','=','pemesananpenjualans.KodePelanggan')
        ->select('pemesananpenjualans.*','lokasis.NamaLokasi','matauangs.NamaMataUang','pelanggans.NamaPelanggan')
        ->get();
        $pemesananpenjualan = $pemesananpenjualan->where('Status','CFM');
        $pemesananpenjualan->all();
        $filter = false;
        return view('pemesananPenjualan.listkonfirmasi',compact('pemesananpenjualan', 'filter'));
    }

    public function konfirmasiPenjualanFilter(Request $request){
        // Cara 1
        // $pemesananpenjualan = pemesananpenjualan::all()->where('Status','CFM')
        //                     ->where('Tanggal','>=',$request->start)
        //                     ->where('Tanggal','<=',$request->finish);
        // $filter = true;
        // $start = $request->start;
        // $finish = $request->finish;
        //Cara 2
        $start = $request->get('start');
        $end = $request->get('end');
        //dd($start,$end);
        // $tanggal = '2019-09-13 00:00:00';
        $hasil1 = pemesananpenjualan::where('Status','CFM')->get();
        $pemesananpenjualan = $hasil1->whereBetween('Tanggal',[$start.' 00:00:00',$end.' 00:00:00']);
        $pemesananpenjualan->all();
        //return $pemesananpenjualan;
        return view('pemesananPenjualan.listkonfirmasi',compact('pemesananpenjualan', 'filter','start','finish'));
    }

    public function konfirmasiPenjualanPrint(Request $request){

        if($request->start!=null){
            $pemesananpenjualan =pemesananpenjualan::all()->where('Status','CFM')->where('Tanggal','>=',$request->start)->where('Tanggal','<=',$request->finish);
        }else{
            $pemesananpenjualan =pemesananpenjualan::all()->where('Status','CFM');
        }
        $pdf = PDF::loadview('pemesananPenjualan.pdf',['pemesananpenjualan'=>$pemesananpenjualan]);

        return $pdf->download('pemesananpenjualan.pdf');
    }

    public function dikirimPenjualan(){
        $pemesananpenjualan =pemesananpenjualan::all()->where('Status','CLS');
        return view('pemesananPenjualan.listkonfirmasi',['pemesananpenjualan' => $pemesananpenjualan]);
    }

    public function view($id)
    {
        $data = DB::select("SELECT a.KodeSo, a.Tanggal, a.tgl_kirim,a.Expired,a.term, a.POPelanggan, b.NamaMataUang, c.NamaLokasi, d.NamaPelanggan, a.Keterangan, a.Diskon, a.PPN, a.Subtotal, a.NilaiPPN from pemesananpenjualans a
            inner join matauangs b on b.KodeMataUang = a.KodeMataUang
            inner join lokasis c on c.KodeLokasi = a.KodeLokasi
            inner join pelanggans d on d.KodePelanggan = a.KodePelanggan
            where a.KodeSO ='".$id."' limit 1")[0];
        $items = DB::select("SELECT a.Qty,b.NamaItem,d.NamaSatuan, a.Harga, a.Subtotal, b.Keterangan  from pemesanan_penjualan_detail a
            inner join items b on a.KodeItem = b.KodeItem
            inner join itemkonversis c on c.KodeItem = a.KodeItem
            inner join satuans d on c.KodeSatuan = d.KodeSatuan
            where a.KodeSO ='".$id."' ");
        // dd($items);
        $data->Tanggal = Carbon::parse($data->Tanggal)->format('d/m/Y');
        $data->tgl_kirim = Carbon::parse($data->tgl_kirim)->format('d/m/Y');
        return view('pemesananpenjualan.view', compact('data', 'id', 'items'));
    }

    public function print($id)
    {
        $data = DB::select("SELECT a.KodeSo, a.Tanggal, a.tgl_kirim,a.Expired,a.term, a.POPelanggan, b.NamaMataUang, c.NamaLokasi, d.NamaPelanggan, a.Keterangan, a.Diskon, a.PPN, a.Subtotal, a.NilaiPPN from pemesananpenjualans a
            inner join matauangs b on b.KodeMataUang = a.KodeMataUang
            inner join lokasis c on c.KodeLokasi = a.KodeLokasi
            inner join pelanggans d on d.KodePelanggan = a.KodePelanggan
            where a.KodeSO ='".$id."' limit 1")[0];
        $items = DB::select("SELECT a.Qty,b.NamaItem,d.NamaSatuan, a.Harga, a.Subtotal, b.Keterangan  from pemesanan_penjualan_detail a
            inner join items b on a.KodeItem = b.KodeItem
            inner join itemkonversis c on c.KodeItem = a.KodeItem
            inner join satuans d on c.KodeSatuan = d.KodeSatuan
            where a.KodeSO ='".$id."' ");
        $jml = 0;
        foreach ($items as $value) {
            $jml += $value->Qty;
        }
        $data->Tanggal = Carbon::parse($data->Tanggal)->format('d/m/Y');
        $data->tgl_kirim = Carbon::parse($data->tgl_kirim)->format('d/m/Y');

        $pdf = PDF::loadview('pemesananPenjualan.pdfdetail',compact('data', 'id', 'items', 'jml'));

        return $pdf->download('pemesananpenjualandetail.pdf');
        return view('pemesananpenjualan.pdfdetail', compact('data', 'id', 'items', 'jml'));
    }
}
