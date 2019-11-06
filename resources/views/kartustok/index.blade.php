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
                    <table id="stok" class="table table-light">
                        <thead class="thead-light">
                            <tr>
                                <th>Tanggal Transaksi</th>
                                <th>Item</th>
                                <th>Gudang</th>
                                <th>Jenis Transaksi</th>
                                <th>Kode Transaksi</th>
                                <th>QTY</th>
                                <th>Saldo Item</th>
                            </tr>
                        </thead>
                        <tbody>
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
    var table = $('#stok').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('api.stok') }}",
        columns: [{
                data: 'Tanggal',
                name: 'Tanggal'
            },
            {
                data: 'NamaItem',
                name: 'NamaItem'
            },
            {
                data: 'NamaLokasi',
                name: 'NamaLokasi'
            },
            {
                data: 'JenisTransaksi',
                name: 'JenisTransaksi'
            },
            {
                data: 'KodeTransaksi',
                name: 'KodeTransaksi'
            },
            {
                data: 'Qty',
                name: 'Qty'
            },
            {
                data: 'saldo',
                name: 'saldo'
            }
        ]
    });
</script>

@endsection
