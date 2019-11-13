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
                                    <th>Kode Pelanggan</th>
                                    <th>Nama Pelanggan</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pelanggans as $pelang)
                                    <tr>
                                        <td>{{ $pelang->KodePelanggan}}</td>
                                        <td>{{ $pelang->NamaPelanggan}}</td>
                                        <td><a href="{{url('pelunasanpiutang/invoice/'.$pelang->KodePelanggan)}}" class="btn btn-primary">Select Invoice</a></td>
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
