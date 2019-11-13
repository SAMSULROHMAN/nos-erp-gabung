@extends('home')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h1>Edit Data Klasifikasi</h1>
                    </div>
                    <div class="x_content">
                        @foreach($kategori as $kat)
                        <form action="{{ route('dataklasifikasi.update',$kat->KodeKategori)}}" method="post">
                          @method('PUT')
                        @csrf
                            <div class="form-group">
                                <label>Kode Klasifikasi: </label>
                                <input readonly type="text" name="KodeKategori" value="{{ $kat->KodeKategori }}" placeholder="Kode Klasifikasi" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Nama Klasifikasi : </label>
                                <input type="text" name="NamaKategori" value="{{ $kat->NamaKategori }}" required="required" placeholder="Nama Klasifikasi" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Kode Item: </label>
                                <input type="text" name="KodeItemAwal" value="{{ $kat->KodeItemAwal }}" required="required" placeholder="Kode Item" class="form-control">
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
