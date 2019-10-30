<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Model\invoicehutang;
use App\Model\invoicehutangdetail;
use App\Model\lokasi;
use App\Model\pelunasanhutang;
use App\Model\kasbank;
use App\Model\matauang;
use App\Model\supplier;

class PelunasanHutangController extends Controller
{
    public function index()
    {
        $suppliers = DB::select('SELECT DISTINCT s.NamaSupplier, s.KodeSupplier FROM invoicehutangs i inner join suppliers s on s.KodeSupplier = i.KodeSupplier');
        return view('pelunasan.hutang.index', compact('suppliers'));
    }

    public function invoice($id)
    {
        $invoice = DB::select("SELECT i.KodeInvoiceHutangShow, i.KodeInvoiceHutang, s.NamaSupplier, i.Tanggal, d.Subtotal, COALESCE(sum(ph.Jumlah),0) as bayar FROM invoicehutangs i inner join invoicehutangdetails d on i.KodeInvoiceHutangShow = d.KodeInvoiceHutang inner join suppliers s on s.KodeSupplier = i.KodeSupplier
                    left join pelunasanhutangs ph on ph.KodeInvoice = i.KodeInvoiceHutang
                    where s.KodeSupplier ='" . $id . "'
                    GROUP by i.KodeInvoiceHutangShow, i.KodeInvoiceHutang, s.NamaSupplier, i.Tanggal, d.Subtotal");
        return view('pelunasan.hutang.invoice', compact('invoice'));
    }

    public function payment($id)
    {
        $invoice = invoicehutang::where('KodeInvoiceHutang', $id)->get();
        $supplier = supplier::where('KodeSupplier', $invoice[0]->KodeSupplier)->get();
        $payments = pelunasanhutang::where('KodeInvoice', $id)->get();
        $detail = invoicehutangdetail::where('KodeHutang', $id)->get();
        $tot = 0;
        foreach ($payments as $bill) {
            $tot += $bill->Jumlah;
        }
        $sub = $detail[0]->Subtotal;
        $sisa = $sub - $tot;
        return view('pelunasan.hutang.paymentlist', compact('invoice', 'payments', 'sisa', 'supplier'));
    }

    public function addpayment($id)
    {
        $invoice = invoicehutang::where('KodeInvoiceHutang', $id)->get();
        $payments = pelunasanhutang::where('KodeInvoice', $id)->get();
        $detail = invoicehutangdetail::where('KodeHutang', $id)->get();
        $tot = 0;
        foreach ($payments as $bill) {
            $tot += $bill->Jumlah;
        }
        $sub = $detail[0]->Subtotal;
        $sisa = (($sub * 1000) - ($tot * 1000)) / 1000;
        $payments = pelunasanhutang::where('KodeHutang', $id)->get();
        $matauang = matauang::all();
        return view('pelunasan.hutang.paymentadd', compact('invoice', 'payments', 'matauang', 'sisa'));
    }

    public function addpaymentpost($id, Request $request)
    {
        $jml = $request->jml;
        $keterangan = $request->keterangan;
        $metode = $request->metode;
        $matauang = $request->matauang;
        $status = $request->status;
        $invoice = invoicehutang::where('KodeInvoiceHutang', $id)->first();
        $last_id = DB::select('SELECT * FROM kasbanks ORDER BY KodeKasBankID DESC LIMIT 1');

        $year_now = date('y');
        $month_now = date('m');
        $date_now = date('d');
        $pref = "KM";
        if ($last_id == null) {
            $newID = $pref . "-" . $year_now . $month_now . "0001";
        } else {
            $string = $last_id[0]->KodeKasBank;
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

        $kas = new kasbank();
        $kas->KodeKasBank = $newID;
        $kas->Tanggal = $request->Tanggal;
        $kas->Status = 'CFM';
        $kas->TanggalCheque = $request->Tanggal;
        $kas->KodeBayar = $metode;
        $kas->TipeBayar = '';
        $kas->NoLink = '';
        $kas->BayarDari = '';   
        $kas->Untuk = $invoice->KodeInvoiceHutangShow;
        $kas->Keterangan = $keterangan;
        $kas->KodeUser = 'Admin';
        $kas->Tipe = $status;
        $kas->created_at = \Carbon\Carbon::now();
        $kas->updated_at = \Carbon\Carbon::now();
        $kas->Total = $request->jml;
        $kas->save();

        $last_id = DB::select('SELECT * FROM pelunasanhutangs ORDER BY KodePelunasanHutangID DESC LIMIT 1');

        $year_now = date('y');
        $month_now = date('m');
        $date_now = date('d');
        $pref = "PLH";
        if ($last_id == null) {
            $newID = $pref . "-" . $year_now . $month_now . "0001";
        } else {
            $string = $last_id[0]->KodePelunasanHutang;
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

        $ph = new pelunasanhutang();
        $ph->KodePelunasanHutang = $newID;
        $ph->Tanggal = $request->Tanggal;
        $ph->Status = 'CFM';
        $ph->KodeHutang = $invoice->KodeInvoiceHutangShow;
        $ph->KodeInvoice = $invoice->KodeInvoiceHutang;
        $ph->KodeBayar = '';
        $ph->TipeBayar = $metode;
        $ph->Jumlah = $request->jml;
        $ph->Keterangan = $keterangan;
        $ph->KodeMataUang = $matauang;
        $ph->KodeUser = 'Admin';
        $ph->KodeSupplier = $invoice->KodeSupplier;
        $ph->KodeKasBank = $kas->KodeKasBankID;
        $ph->created_at = \Carbon\Carbon::now();
        $ph->updated_at = \Carbon\Carbon::now();
        $ph->save();

        return redirect('/pelunasanhutang/payment/' . $id);
    }
}
