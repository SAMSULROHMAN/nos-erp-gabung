@extends('index')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="x_panel">
                <div class="x_header">
                    <h1>Data Satuan</h1>
                    <a href="{{ url('/datasatuan/create')}}" class="btn btn-success">
                        <i class="fa fa-plus-square" aria-hidden="true"></i>
                        Tambah Satuan
                    </a>
                    <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                        <form action="{{ route('datasatuan.index')}}" role="search">
                          <div class="input-group">
                              <input type="text" class="form-control" value="{{ Request::get('keyword')}}" name="keyword" placeholder="Cari">
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
                                <th>Kode Satuan</th>
                                <th>Nama Satuan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($satuan as $sat)
                            <tr>
                                <td>{{$sat->KodeSatuan}}</td>
                                <td>{{$sat->NamaSatuan}}</td>
                                <td>
                                    <a href="/datasatuan/edit/{{ $sat->KodeSatuan }}" class="btn btn-warning">
                                        <i class="fa fa-pencil" aria-hidden="true"></i>Edit
                                    </a>
                                    <a href="/datasatuan/destroy/{{ $sat->KodeSatuan }}" class="btn btn-danger">
                                        <i class="fa fa-trash" aria-hidden="true"></i>Hapus
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
