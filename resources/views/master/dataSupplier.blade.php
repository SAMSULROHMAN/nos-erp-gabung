@extends('index')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="x_panel">
                <div class="x_header">
                    <h1>Data Supplier</h1>
                    <a href="{{ url('/datasupplier/create')}}" class="btn btn-success">
                        <i class="fa fa-plus-square" aria-hidden="true"></i>
                        Tambah Supplier
                    </a>
                    <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                        <form action="{{ route('datasupplier.index')}}" role="search">
                          <div class="input-group">
                              <input type="text" class="form-control" name="keyword" value="{{ Request::get('keyword')}}" placeholder="Cari">
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
                                <th>Kode Supplier</th>
                                <th>Nama Supplier</th>
                                <th>Kontak</th>
                                <th>Handphone</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($supplier as $sup)
                            <tr>
                                <td>{{$sup->KodeSupplier}}</td>
                                <td>{{$sup->NamaSupplier}}</td>
                                <td>{{$sup->Kontak}}</td>
                                <td>{{$sup->Handphone}}</td>
                                <td>
                                    <a href="{{ route('datasupplier.edit',$sup->KodeSupplier) }}" class="btn btn-warning">
                                        <i class="fa fa-pencil" aria-hidden="true"></i>Edit
                                    </a>
                                    <a href="{{ route('datasupplier.destroy',$sup->KodeSupplier) }}" class="btn btn-danger">
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
