@extends('index')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="x_panel">
                <div class="x_header">
                    <h1>Data Pelanggan</h1>
                    <a href="{{ route('datapelanggan.create')}}" class="btn btn-success">
                        <i class="fa fa-plus" aria-hidden="true"></i>Tambah
                    </a>
                    <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                        <form class="" action="{{ route('datapelanggan.index')}}" role="search">
                          <div class="input-group">
                              <input type="text" class="form-control" placeholder="Cari">
                              <span class="input-group-btn">
                                  <button class="btn btn-default" type="submit">
                                      <i class="fa fa-search"></i>
                                  </button>
                              </span>
                          </div>
                        </form>
                    </div>
                </div>
                <div class="x_body">
                    <table class="table table-light">
                        <thead class="thead-light">
                            <tr>
                                <th>Kode Pelanggan</th>
                                <th>Nama Pelanggan</th>
                                <th>Kontak</th>
                                <th>Handphone</th>
                                <th>Email</th>
                                <th>NIK</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pelanggan as $p)
                            <tr>
                                <td>{{ $p->KodePelanggan }}</td>
                                <td>{{ $p->NamaPelanggan }}</td>
                                <td>{{ $p->Kontak}}</td>
                                <td>{{ $p->Handphone}}</td>
                                <td>{{ $p->Email}}</td>
                                <td>{{ $p->NIK }}</td>
                                <td>
                                    {{-- <a href="{{ route('datapelanggan.edit',$p->KodePelanggan)}}" class="btn btn-warning">
                                        <i class="fa fa-pencil" aria-hidden="true"></i> Edit
                                    </a> --}}
                                    <a href="/datapelanggan/destroy/{{ $p->KodePelanggan }}" class="btn btn-danger">
                                        <i class="fa fa-trash" aria-hidden="true"></i> Hapus
                                    </a>
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
