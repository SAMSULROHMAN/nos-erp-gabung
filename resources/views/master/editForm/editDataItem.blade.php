@extends('index')
@section('content')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 text-dark">Tambah Data Item</h1>
        </div><!-- /.col -->
    </div><!-- /.row -->
    <br>

    <form action="{{ route('dataitem.update')}}" method="post">
    @csrf
        <div class="form-group">
            <label>ID Barang: </label>
            <input type="text" required="required" name="KodeLokasi" class="form-control">
        </div>
        <div class="form-group">
            <label>ID Klasifikasi </label>
            <input type="text" required="required" name="NamaLokasi"  class="form-control">
        </div>
        <div class="form-group">
            <label>Satuan: </label>
            <input type="text" required="required" name="Tipe"  class="form-control">
        </div>
        <div class="form-group">
            <label>Nama Barang: </label>
            <input type="text" required="required" name="Tipe" class="form-control">
        </div>
        <div class="form-group">
            <label>Alias: </label>
            <input type="text" required="required" name="Tipe" class="form-control">
        </div>
        <div class="form-group">
            <label>Keterangan: </label>
            <input type="text" required="required" name="Tipe"  class="form-control">
        </div>
        <button class="btn btn-success">Simpan</button>
    </form>

</div><!-- /.container-fluid -->

@endsection
