@extends('index')
@section('content')
<div class="container">
    <div class="x_panel">
        <div class="x_title">
            <h3>Filter Tanggal</h3>
        </div>
        <form action="{{ url('/konfirmasisuratJalan/cari')}}" method="get">
            <div class="x_content">
                <div class="col-md-5 col-sm-5">
                    <div class="form-group">
                        <label for="tanggalpo">Dari :</label>
                        <div class="input-group date" id="start">
                            <input type="text" class="form-control" name="start" value="{{ Request::get('start')}}" />
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 col-sm-5">
                    <div class="form-group">
                        <label for="tanggalpo">Sampai :</label>
                        <div class="input-group date" id="end">
                            <input type="text" class="form-control" name="end" value="{{ Request::get('end') }}" />
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
            <h3>Konfirmasi Surat Jalan</h3>
        </div>
        <div class="x_content">
            <table class="table table-bordered" id="table">
                <thead>
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
                        <td>{{ \Carbon\Carbon::parse($suratjalan->Tanggal)->format('d-m-Y') }}</td>
                        <td>{{ $suratjalan->KodeLokasi}}</td>
                        <td>
                            <a href="{{ url('/suratJalan/view/'.$suratjalan->KodeSuratJalanID ) }}" class="btn-sm btn btn-primary">
                                <i class="fa fa-eye" aria-hidden="true"></i>
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
    $('#start').datetimepicker({
        defaultDate: new Date(),
        format: 'YYYY-DD-MM'
    });

    $('#end').datetimepicker({
        defaultDate: new Date(),
        format: 'YYYY-DD-MM'
    });
    $('#table').DataTable();
</script>
@endsection
