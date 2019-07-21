@extends('home')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h1>Tambah Data Supplier</h1>
                    </div>
                    <div class="x_content">
                        <form action="/datasupplier/store" method="get">
                        @csrf
                            <div class="form-group">
                                <label>Kode Supplier: </label>
                                <input readonly type="text" value="{{$newID}}" name="KodeSupplier" required="required" placeholder="Kode Supplier" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Nama Supplier: </label>
                                <input type="text" required="required" type="text" name="NamaSupplier" placeholder="Nama Supplier" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Alamat: </label>
                                <input type="text" required="required" name="Alamat" placeholder="Alamat" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Kontak: </label>
                                <input type="text" required="required" name="Kontak" placeholder="Kontak" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Handphone: </label>
                                <input type="text" required="required" name="Handphone" placeholder="Handphone" class="form-control">
                            </div>
                            <button class="btn btn-success">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection