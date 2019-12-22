@extends('home')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h1>Tambah Data Klasifikasi</h1>
                    </div>
                    <div class="x_content">
                        <form action="{{ route('dataklasifikasi.store')}}" method="post">
                        @csrf
                            <div class="form-group">
                                <label>Kode Klasifikasi: </label>
                                <input readonly type="text" value="{{$newID}}" name="KodeKategori" required="required" placeholder="Kode Klasifikasi" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Nama Klasifikasi : </label>
                                <input type="text" name="NamaKategori" required="required" placeholder="Nama Klasifikasi" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Kode Item: </label>
                                <input type="text" name="KodeItemAwal" required="required" placeholder="Kode Item" class="form-control">
                            </div>
                            <button class="btn btn-success">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
