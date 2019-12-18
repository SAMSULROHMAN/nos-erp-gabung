@extends('index')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h1>Invoice Piutang</h1><br>
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
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($invoice as $stokmasuk)
                                    @if ($stokmasuk->Subtotal == $stokmasuk->bayar || \Carbon\Carbon::parse($stokmasuk->Tanggal)->addDays($stokmasuk->Term) > \Carbon\Carbon::now())
                                        <tr class="success">
                                            <td>{{ $stokmasuk->NamaPelanggan}}</td>
                                            <td>{{ $stokmasuk->KodeInvoicePiutangShow}}</td>
                                            <td>{{ \Carbon\Carbon::parse($stokmasuk->Tanggal)->format('d-m-Y') }}</td>
                                            <td>{{ $stokmasuk->Subtotal }}</td>
                                            <td>{{ $stokmasuk->bayar }}</td>
                                            <td>{{ $stokmasuk->Subtotal - $stokmasuk->bayar}}</td>
                                        </tr>
                                    @else
                                        <tr class="danger">
                                            <td>{{ $stokmasuk->NamaPelanggan}}</td>
                                            <td>{{ $stokmasuk->KodeInvoicePiutangShow}}</td>
                                            <td>{{ \Carbon\Carbon::parse($stokmasuk->Tanggal)->format('d-m-Y') }}</td>
                                            <td>{{ $stokmasuk->Subtotal }}</td>
                                            <td>{{ $stokmasuk->bayar }}</td>
                                            <td>{{ $stokmasuk->Subtotal - $stokmasuk->bayar}}</td>
                                        </tr>
                                    @endif
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
