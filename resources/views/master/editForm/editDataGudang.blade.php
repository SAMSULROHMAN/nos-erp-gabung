@extends('index')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h1>Edit Data Gudang</h1>
                    </div>
                    <div class="x_content">
                        @foreach($lokasi as $lok)
                        <form action="{{ route('datagudang.update',$lok->KodeLokasi)}}" method="post">
                          @method('PUT')
                        @csrf
                            <div class="form-group">
                                <label>Kode Gudang: </label>
                                <input type="text" name="KodeLokasi" value="{{ $lok->KodeLokasi }}" placeholder="Kode Gudang" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Nama Gudang: </label>
                                <input type="text" required="required" name="NamaLokasi" value="{{ $lok->NamaLokasi }}" placeholder="Nama Gudang" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Tipe: </label>
                                <select class="form-control" name="Tipe" id="Tipe">
                                    <option disabled>-- Pilih Tipe Gudang --</option>
                                    <option value="INV">INV</option>
                                </select>
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
