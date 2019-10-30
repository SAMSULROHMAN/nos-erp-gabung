@extends('index')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h1>Pelunasan Hutang</h1><br>
                    </div>
                    <div class="x_body">
                        @if($sisa >0)
                            <a class="btn btn-primary " href="{{url('/pelunasanhutang/payment/'.$invoice[0]->KodeInvoiceHutang.'/add')}}">Tambah Pembayaran</a>
                        @endif
                        <table class="table table-light">
                            <thead class="thead-light">
                                <tr>
                                    <th>Supplier</th>
                                    <th>No Tagihan</th>
                                    <th>Tanggal</th>
                                    <th>Total Bayar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($payments as $payment)
                                    <tr>
                                        <td>{{ $supplier[0]->NamaSupplier }}</td>
                                        <td>{{ $invoice[0]->KodeInvoiceHutangShow}}</td>
                                        <td>{{ $payment->Tanggal}}</td>
                                        <td>{{ $payment->Jumlah}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
