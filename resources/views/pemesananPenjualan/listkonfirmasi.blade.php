@extends('index')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="x_panel">
              <form action="{{ url('/konfirmasipemesananPenjualan/filter')}}" method="get">
                <div class="x_title">
                  <h3>Filter Tanggal</h3>
                </div>
                <div class="x_content">
                  <div class="col-md-5 col-sm-5">
                    <div class="form-group">
                      <label for="">Dari  :</label>
                      <div class="input-group date" id="start">
                        <input type="text" class="form-control" name="start" value="{{ Request::get('start')}}"/>
                        <span class="input-group-addon">
                           <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-5 col-sm-5">
                    <div class="form-group">
                      <label for="">Sampai  :</label>
                      <div class="input-group date" id="end">
                        <input type="text" class="form-control" name="end" value="{{ Request::get('end')}}"/>
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
                        <input type="submit" value="Filter" class="btn btn-md btn-block btn-primary">
                      </div>
                    </div>
                  </div>
                </div>
              </form>
            </div>
            <div class="x_panel">
                <div class="x_title">
                    <h3>Pemesanan Penjualan</h3>
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
                                <th>Action</th>
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
                            <th><a href="{{ url('sopenjualan/view/'.$p->KodeSO) }}"><button class="btn btn-primary"><i class="fa fa-eye"></i></button></a></th>
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
      $('#start').datetimepicker({
        defaultDate: new Date(),
        format: 'YYYY-MM-DD'
      });

      $('#end').datetimepicker({
        defaultDate: new Date(),
        format: 'YYYY-MM-DD'
      });

      $('#table').DataTable();
  </script>
@endsection
