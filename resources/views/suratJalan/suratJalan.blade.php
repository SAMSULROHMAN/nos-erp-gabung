@extends('index')
@section('content')
 <div class="container">
   <div class="x_panel">
       <div class="x_title">
         <h3>Filter Tanggal</h3>
       </div>
       <div class="x_content">
         <div class="col-md-6 col-sm-6">
           <div class="form-group">
               <label for="tanggalpo">Dari :</label>
               <div class="input-group date" id="tanggalpo">
                   <input type="text" class="form-control"/>
                   <span class="input-group-addon">
                      <span class="glyphicon glyphicon-calendar"></span>
                   </span>
               </div>
           </div>
         </div>
         <div class="col-md-6 col-sm-6">
           <div class="form-group">
               <label for="tanggalpo">Sampai :</label>
               <div class="input-group date" id="tanggalposampai">
                   <input type="text" class="form-control"/>
                   <span class="input-group-addon">
                      <span class="glyphicon glyphicon-calendar"></span>
                   </span>
               </div>
           </div>
         </div>
       </div>
   </div>
   <div class="x_panel">
    <div class="x_title">
      <div class="row">
        <div class="col-md-12 col-sm-12">
            <h3>Surat Jalan</h3>
        </div>
      </div>
    </div>
    <div class="x_content">
      <table class="table table-light" id="tsuratjalan">
          <thead class="thead-light">
            <tr>
              <th scope="col">Nomor S.O</th>
              <th scope="col">Nama Pelanggan</th>
              <th scope="col">Tanggal</th>
              <th scope="col">Gudang</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
              @foreach ($suratjalans as $suratjalan)
                <tr>
                    <td>{{ $suratjalan->KodeSO}}</td>
                    <td>{{ $suratjalan->KodePelanggan}}</td>
                    <td>{{ $suratjalan->Tanggal }}</td>
                    <td>{{ $suratjalan->KodeLokasi}}</td>
                    <td>
                        <a href="{{ url('/suratJalan/show/'.$suratjalan->KodeSuratJalanID) }}" class="btn-sm btn btn-primary">
                            <i class="fa fa-eye" aria-hidden="true"></i>
                        </a>
                        <a href="{{ url('suratJalan/print/'.$suratjalan->KodeSuratJalanID)}}" class="btn-sm btn btn-warning">
                            <i class="fa fa-pencil" aria-hidden="true"></i>
                        </a>
                        <a href="#" class="btn-sm btn btn-danger">
                            <i class="fa fa-trash" aria-hidden="true"></i>
                        </a>
                    </td>
                </tr>
              @endforeach
          </tbody>
        </table>
    </div>
  </div>
</div>
@endsection
@section('scripts')

<script type="text/javascript">
    $('#tanggalpo').datetimepicker({
      defaultDate: new Date(),
      format: 'DD/MM/YYYY'
    });

    $('#tanggalposampai').datetimepicker({
      defaultDate: new Date(),
      format: 'DD/MM/YYY'
    });

    $('#tsuratjalan').DataTable();
</script>

@endsection
