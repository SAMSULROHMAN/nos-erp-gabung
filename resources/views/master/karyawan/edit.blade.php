@extends('index')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h1>Edit Data Karyawan</h1>
                    </div>
                    <div class="x_content">
                        @foreach($karyawan as $k)
                        <form action="{{ route('/datakaryawan/update',$k->IDKaryawan)}}" method="post">
                            @csrf
                            <div class="form-group">
                                <label>Kode Karyawan: </label>
                                <input readonly type="text" value="{{ $k->KodeKaryawan }}" name="KodeKaryawan" required="required" placeholder="Kode Karyawan" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Nama Karyawan: </label>
                                <input type="text" required="required" type="text" name="Nama" placeholder="Nama Karyawan" class="form-control" value="{{ $k->Nama }}">
                            </div>
                            <div class="form-group">
                                <label>Jabatan: </label>
                                <input type="text" required="required" name="Jabatan" placeholder="Jabatan" class="form-control" value="{{ $k->Jabatan }}">
                            </div>
                            <div class="form-group">
                                <label>Alamat: </label>
                                <input type="text" required="required" name="Alamat" placeholder="Alamat" class="form-control" value="{{ $k->Alamat }}">
                            </div>
                            <div class="form-group">
                                <label for="">Jenis kelamin</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="JenisKelamin" id="bb" value="Laki-laki">
                                    <label class="form-check-label" for="bb">Laki-laki</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="JenisKelamin" id="bahanjadi" value="Perempuan">
                                    <label class="form-check-label" for="bahanjadi">Perempuan</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Kota: </label>
                                <input type="text" required="required" name="Kota" placeholder="Kota" class="form-control" value="{{ $k->Kota}}">
                            </div>
                            <div class="form-group">
                                <label>Propinsi: </label>
                                <input type="text" required="required" name="Propinsi" placeholder="Propinsi" class="form-control" value="{{ $k->Propinsi }}">
                            </div>
                            <div class="form-group">
                                <label>Negara: </label>
                                <input type="text" required="required" name="Negara" placeholder="Negara" class="form-control" value="{{ $k->Negara }}">
                            </div>
                            <div class="form-group">
                                <label>Telepon: </label>
                                <input type="text" required="required" name="Telepon" placeholder="Telepon" class="form-control" value="{{ $k->Telepon }}">
                            </div>
                            <div class="form-group">
                                <label>E-mail: </label>
                                <input type="text" required="required" name="Email" placeholder="E-mail" class="form-control" value="{{ $k->Email }}">
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
