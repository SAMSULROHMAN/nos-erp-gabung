@extends('home')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h1>Tambah Data Satuan</h1>
                    </div>
                    <div class="x_content">
                        <form action="{{ route('datasatuan.store')}}" method="POST">
                        @csrf
                            <div class="form-group">
                                <label>Kode Satuan: </label>
                                <input type="text" required="required" name="KodeSatuan" placeholder="Kode Satuan" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Nama Satuan: </label>
                                <input type="text" required="required" name="NamaSatuan" placeholder="Nama Satuan" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Nama Kemasan: </label>
                                <input type="text" name="NamaKemasan" placeholder="Nama Kemasan" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Jumlah Satuan dalam Kemasan: </label>
                                <input type="number" name="JumlahSatuan" placeholder="Jumlah Satuan Dalam Kemasan" class="form-control">
                            </div>
                            <button class="btn btn-success">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
