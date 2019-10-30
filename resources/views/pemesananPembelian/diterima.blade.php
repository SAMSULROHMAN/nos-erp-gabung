@extends('index')
@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h1>Pemesanan Pembelian Diterima</h1>
        </div>
      </div>
    </div>
    <div class="card-body">
      <div class="x_panel">
        <table id="pemesananpembelian" class="table table-light">
          <thead class="thead-light">
            <tr>
              <th>Kode PO</th>
              <th>Gudang</th>
              <th>Mata Uang</th>
              <th>Supplier</th>
              <th>Tanggal Pemesanan</th>
              <th>Tanggal Diterima</th>
              <th>Detail</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>
    </div>
  </div>
</div>
</div>
</div>

<script type="text/javascript">
  var table = $('#pemesananpembelian').DataTable({
    processing: true,
    serverSide: true,
    ajax: "{{ route('api.popembelianCLS') }}",
    columns: [{
        data: 'KodePO',
        name: 'KodePO'
      },
      {
        data: 'NamaLokasi',
        name: 'NamaLokasi'
      },
      {
        data: 'NamaMataUang',
        name: 'NamaMataUang'
      },
      {
        data: 'NamaSupplier',
        name: 'NamaSupplier'
      },
      {
        data: 'Tanggal',
        name: 'Tanggal'
      },
      {
        data: 'TanggalDiterima',
        name: 'TanggalDiterima'
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