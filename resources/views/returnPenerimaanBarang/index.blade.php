@extends('index')
@section('content')
<div class="container">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Return Penerimaan Barang</h1>
                </div>
            </div>
            <a href="{{ url('/returnPenerimaanBarang/create/0') }}" class="btn btn-success">
                <i class="fa fa-plus" aria-hidden="true"></i>
                Tambah Return Penerimaan Barang
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <form>

                <!-- Contents -->
                <hr class="style1">
                <div class="form-row">
                    <table id="penerimaanbarangreturn" class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">Kode RPB</th>
                                <th scope="col">Kode LPB</th>
                                <th scope="col">Supplier</th>
                                <th scope="col">Gudang</th>
                                <th scope="col">Tanggal</th>
                                <th scope="col">Detail</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </form>
        </div>
    </div>
    <!-- Button trigger modal -->
</div>
</div>

<script type="text/javascript">
    var table = $('#penerimaanbarangreturn').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('api.returnpenerimaanbarangOPN') }}",
        columns: [{
                data: 'KodePenerimaanBarangReturn',
                name: 'KodePenerimaanBarangReturn'
            },
            {
                data: 'KodePenerimaanBarang',
                name: 'KodePenerimaanBarang'
            },
            {
                data: 'NamaSupplier',
                name: 'NamaSupplier'
            },
            {
                data: 'NamaLokasi',
                name: 'NamaLokasi'
            },
            {
                data: 'Tanggal',
                name: 'Tanggal'
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            }
        ]
    });
</script>
@endsection