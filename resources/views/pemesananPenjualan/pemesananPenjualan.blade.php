@extends('index')
@section('content')
    <div class="container">
      <div class="row">
        <div class="col-md-12">

          <div class="x_panel">
              <div class="x_title">
                <h3>Filter Tanggal</h3>
              </div>
              <form action="{{ url('/sopenjualan/cari')}}" method="get">
                <div class="x_content">
                  <div class="col-md-5 col-sm-5">
                    <div class="form-group">
                        <label for="tanggalpo">Dari :</label>
                        <div class="input-group date" id="tanggalpo">
                            <input type="text" class="form-control" name="mulai" value="{{ Request::get('mulai')}}"/>
                            <span class="input-group-addon">
                               <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                  </div>
                  <div class="col-md-5 col-sm-5">
                    <div class="form-group">
                        <label for="tanggalpo">Sampai :</label>
                        <div class="input-group date" id="tanggalposampai">
                            <input type="text" class="form-control" name="sampai" value="{{ Request::get('mulai')}}"/>
                            <span class="input-group-addon">
                               <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                  </div>
                  <div class="col-md-2 col-sm-2">
                    <div class="form-group">
                      <label for="">Filter</label>
                      <div class="input-group">
                        <input type="submit" class="btn btn-md btn-block btn-primary" value="Filter">
                      </div>
                    </div>
                  </div>
                </div>
              </form>
          </div>

          <div class="x_panel">
              <div class="x_title">
                <div class="row">
                  <div class="col-md-6 col-sm-6">
                    <h3>Pemesanan Penjualan</h3>
                    <p>Sales Order<p>
                  </div>
                  <div class="col-md-6 col-sm-6">
                    <a href="{{ url('/sopenjualan/create')}}" class="btn btn-success pull-right">
                      <i class="fa fa-plus" aria-hidden="true"></i>Tambah S.O.
                    </a>
                  </div>
                </div>
              </div>
            <div class="x_content">
              <table class="table table-light" id="table">
                <thead class="thead-light">
                  <tr>
                    <th>Kode SO</th>
                    <th>Tanggal</th>
                    <th>Tanggal Kirim</th>
                    <th>Expired</th>
                    <th>Mata Uang</th>
                    <th>Gudang</th>
                    <th>Pelanggan</th>
                    <th>Term</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                  @foreach ($pemesananpenjualan as $p)
                    <tr>
                        <td>{{ $p->KodeSO}}</td>
                        <td>{{ \Carbon\Carbon::parse($p->Tanggal)->format('d-m-Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($p->tgl_kirim)->format('d-m-Y') }}</td>
                        <td>{{ $p->Expired }}</td>
                        <td>{{ $p->KodeMataUang}}</td>
                        <td>{{ $p->KodeLokasi}}</td>
                        <td>{{ $p->KodePelanggan}}</td>
                        <td>{{ $p->term }}</td>
                        <td>
                          <a href="{{ url('/sopenjualan/show/'. $p->KodeSO )}}" class="btn-sm btn btn-primary">
                            <i class="fa fa-eye" aria-hidden="true"></i>
                          </a>
                          <a href="{{ url('/sopenjualan/edit/'.$p->KodeSO)}}" class="btn-sm btn btn-warning">
                            <i class="fa fa-pencil" aria-hidden="true"></i>
                          </a>
                          <a href="{{ url('/sopenjualan/destroy/'.$p->KodeSO)}}" class="btn-sm btn btn-danger">
                            <i class="fa fa-trash" aria-hidden="true"></i>
                          </a>
                        </td>
                    </tr>
                  @endforeach
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
@endsection
@section('scripts')

<script type="text/javascript">
    $('#tanggalpo').datetimepicker({
      defaultDate: new Date(),
      format: 'YYYY-MM-DD'
    });

    $('#tanggalposampai').datetimepicker({
      defaultDate: new Date(),
      format: 'YYYY-MM-DD'
    });

    $('#table').DataTable();
</script>


@endsection
