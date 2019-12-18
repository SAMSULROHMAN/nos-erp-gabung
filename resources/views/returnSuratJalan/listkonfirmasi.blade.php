@extends('index')
@section('content')
 <div class="container">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Konfirmasi Surat Jalan Return</h1>
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </div>

    <div class="x_panel">
      <div class="x_content">
        <table class="table table-bordered" id="table">
          <thead>
            <tr>
              <th scope="col">Nomor SJR</th>
              <th scope="col">Tanggal</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
              @foreach ($suratjalanreturns as $suratjalan)
                <tr>
                    <td>{{ $suratjalan->KodeSuratJalanReturn}}</td>
                    <td>{{ \Carbon\Carbon::parse($suratjalan->Tanggal)->format('d-m-Y') }}</td>
                    <td>
                        <a href="{{ url('/returnSuratJalan/view/'.$suratjalan->KodeSuratJalanReturnId ) }}" class="btn-sm btn btn-primary">
                            <i class="fa fa-eye" aria-hidden="true"></i>
                        </a>
                    </td>
                </tr>
              @endforeach
          </tbody>
        </table>
      </div>
    </div>
    <!-- Button trigger modal -->


    </div>
  </div>
@endsection
@section('scripts')
  <script type="text/javascript">
    $('#table').DataTable();
  </script>
@endsection
