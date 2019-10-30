<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Model\invoicepiutang;
use App\Model\invoicehutang;
use App\Model\lokasi;

class InvoiceController extends Controller
{
    public function piutang()
    {
        $invoice = DB::select('SELECT i.KodeInvoicePiutangShow, i.KodeInvoicePiutang, p.NamaPelanggan, i.Tanggal, d.Subtotal, COALESCE(sum(pp.Jumlah),0) as bayar FROM invoicepiutangs i inner join invoicepiutangdetails d on i.KodeInvoicePiutang = d.KodeInvoicePiutang inner join pelanggans p on p.KodePelanggan = i.KodePelanggan
            left join pelunasanpiutangs pp on pp.KodeInvoice = i.KodeInvoicePiutang
            GROUP by i.KodeInvoicePiutangShow, i.KodeInvoicePiutang, p.NamaPelanggan, i.Tanggal, d.Subtotal');
        return view('invoice.piutang.index', compact('invoice'));
    }

    public function hutang()
    {
        $invoice = DB::select('SELECT i.KodeInvoiceHutangShow, i.KodeInvoiceHutang, s.NamaSupplier, i.Tanggal, d.Subtotal, COALESCE(sum(ph.Jumlah),0) as bayar FROM invoicehutangs i inner join invoicehutangdetails d on i.KodeInvoiceHutangShow = d.KodeInvoiceHutang inner join suppliers s on s.KodeSupplier = i.KodeSupplier
            left join pelunasanhutangs ph on ph.KodeInvoice = i.KodeInvoiceHutang
            GROUP by i.KodeInvoiceHutangShow, i.KodeInvoiceHutang, s.NamaSupplier, i.Tanggal, d.Subtotal');
        return view('invoice.hutang.index', compact('invoice'));
    }
}
