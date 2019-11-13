@extends('index')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h1>Pelunasan Piutang</h1><br>
                    </div>
                    <div class="x_body">
                        <table class="table table-light" id="table">
                            <thead class="thead-light">
                                <tr>
                                    <th>Pelanggan</th>
                                    <th>No Tagihan</th>
                                    <th>Tanggal</th>
                                    <th>Total</th>
                                    <th>Total Bayar</th>
                                    <th>Selisih</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($invoice as $stokmasuk)
                                    @if(($stokmasuk->Subtotal - $stokmasuk->bayar)<=0)
                                         @continue
                                    @endif
                                    <tr>
                                        <td>{{ $stokmasuk->NamaPelanggan}}</td>
                                        <td>{{ $stokmasuk->KodeInvoicePiutangShow}}</td>
                                        <td>{{ $stokmasuk->Tanggal}}</td>
                                        <td>{{ $stokmasuk->Subtotal}}</td>
                                        <td>{{ $stokmasuk->bayar}}</td>
                                        <td>{{ $stokmasuk->Subtotal - $stokmasuk->bayar}}</td>
                                        <td><a href="{{url('pelunasanpiutang/payment/'.$stokmasuk->KodeInvoicePiutang)}}" class="btn btn-primary">Add Payment</a></td>
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
@section('scripts')
  <script type="text/javascript">
    $('#table').DataTable();
  </script>
@endsection
