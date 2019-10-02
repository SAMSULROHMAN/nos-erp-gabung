@extends('index')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h1>Kartu Stok</h1><br>
                    </div>
                    <div class="x_body">
                        <table class="table table-light">
                            <thead class="thead-light">
                                <tr>
                                    <th>Pelanggan</th>
                                    <th>No Tagihan</th>
                                    <th>Tanggal</th>
                                    <th>Total</th>
                                    <th>Total Bayar</th>
                                    <th>Selisih</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($invoice as $stokmasuk)
                                    <tr>
                                        <td>{{ $stokmasuk->NamaPelanggan}}</td>
                                        <td>{{ $stokmasuk->KodeInvoicePiutangShow}}</td>
                                        <td>{{ $stokmasuk->Tanggal}}</td>
                                        <td>{{ $stokmasuk->Subtotal}}</td>
                                        <td>{{ $stokmasuk->bayar}}</td>
                                        <td>{{ $stokmasuk->selisih}}</td>
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
