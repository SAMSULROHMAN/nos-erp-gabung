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
                        <table class="table table-light">
                            <thead class="thead-light">
                                <tr>
                                    <th>Supplier</th>
                                    <th>No Tagihan</th>
                                    <th>Tanggal</th>
                                    <th>Total</th>
                                    <th>Total Bayar</th>
                                    <th>Selisih</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($invoice as $inv)
                                    @if(($inv->Subtotal - $inv->bayar)<=0)
                                         @continue
                                    @endif
                                    <tr>
                                        <td>{{ $inv->NamaSupplier}}</td>
                                        <td>{{ $inv->KodeInvoiceHutangShow}}</td>
                                        <td>{{ $inv->Tanggal}}</td>
                                        <td>{{ $inv->Subtotal}}</td>
                                        <td>{{ $inv->bayar}}</td>
                                        <td>{{ $inv->Subtotal - $inv->bayar}}</td>
                                        <td>
                                            <a href="{{url('pelunasanhutang/payment/'.$inv->KodeInvoiceHutang)}}" class="btn btn-primary">Add Payment</a>
                                        </td>
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
