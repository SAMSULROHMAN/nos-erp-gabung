@extends('index')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="x_panel">
                    <div class="x_header">
                        <h1>Data Karyawan</h1>
                        <a href="{{ url('datakaryawan/create')}}" class="btn btn-success">
                            <i class="fa fa-plus" aria-hidden="true"></i>Tambah
                        </a>
                        <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Cari">
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="x_body">
                        <table class="table table-light">
                            <thead class="thead-light">
                                <tr>
                                    <th>Nama</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Jabatan</th>
                                    <th>Alamat</th>
                                    <th>Kota</th>
                                    <th>Propinsi</th>
                                    <th>Negara</th>
                                    <th>Telepon</th>
                                    <th>Email</th>
                                    <th>Tahun Masuk</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($karyawan as $k)
                                    <tr>
                                        <td>{{ $k->Nama }}</td>
                                        <td>{{ $k->JenisKelamin }}</td>
                                        <td>{{ $k->Jabatan }}</td>
                                        <td>{{ $k->Alamat }}</td>
                                        <td>{{ $k->Kota }}</td>
                                        <td>{{ $k->Propinsi }}</td>
                                        <td>{{ $k->Negara }}</td>
                                        <td>{{ $k->Telepon }}</td>
                                        <td>{{ $k->Email }}</td>
                                        <td>{{ $k->tahunmasuk }}</td>
                                        <td>
                                            <a href="{{ route('datakaryawan.edit',$k->IDKaryawan)}}" class="btn btn-warning">
                                                <i class="fa fa-pencil" aria-hidden="true"></i> Edit
                                            </a>

                                            <form action="{{ route('datakaryawan.destroy',$k->IDKaryawan)}}" method="post">
                                                @method('DELETE')
                                                @csrf
                                                <button type="submit" class="btn btn-md btn-danger">
                                                    <i class="fa fa-trash" aria-hidden="true"></i> Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
