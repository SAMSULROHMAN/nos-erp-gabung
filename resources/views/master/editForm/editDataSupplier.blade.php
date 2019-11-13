@extends('index')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h1>Edit Data Supplier</h1>
                    </div>
                    <div class="x_content">
                        @foreach($supplier as $sup)
                        <form action="{{ route('/datasupplier/update',$sup->KodeSupplier)}}" method="post">

                          @method('PUT')
                        @csrf
                            <div class="form-group">
                                <label>Kode Supplier: </label>
                                <input readonly type="text" value="{{ $sup->KodeSupplier }}" name="KodeSupplier" required="required" placeholder="Kode Supplier" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Nama Supplier: </label>
                                <input type="text" value="{{ $sup->NamaSupplier }}" required="required" type="text" name="NamaSupplier" placeholder="Nama Supplier" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Alamat: </label>
                                <input type="text" value="{{ $sup->Alamat }}" required="required" name="Alamat" placeholder="Alamat" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Kontak: </label>
                                <input type="text" value="{{ $sup->Kontak }}" required="required" name="Kontak" placeholder="Kontak" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Handphone: </label>
                                <input type="text" value="{{ $sup->Handphone }}" required="required" name="Handphone" placeholder="Handphone" class="form-control">
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
