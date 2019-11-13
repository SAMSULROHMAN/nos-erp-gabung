@extends('index')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h1>Edit Data Satuan</h1>
                    </div>
                    <div class="x_content">
                        @foreach($satuan as $sat)
                        <form action="{{ route('/datasatuan/update',$sat->KodeSatuan)}}" method="post">
                          @method('PUT')
                        @csrf
                            <div class="form-group">
                                <label>Kode Satuan: </label>
                                <input readonly type="text" name="KodeSatuan" value="{{ $sat->KodeSatuan }}" placeholder="Kode Satuan" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Nama Satuan: </label>
                                <input type="text" required="required" name="NamaSatuan" value="{{ $sat->NamaSatuan }}" placeholder="Nama Satuan" class="form-control">
                            </div>
                            <button class="btn btn-success">Simpan</button>
                        </form>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
