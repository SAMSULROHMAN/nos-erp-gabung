@extends('index')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="x_panel">
                <div class="x_header">
                    <h1>Data Item</h1>
                    <a href="{{ url('/dataitem/create')}}" class="btn btn-success">
                        <i class="fa fa-plus-square" aria-hidden="true"></i>Tambah Item
                    </a>
                    <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                        <form class="" action="{{ route('dataitem.index')}}" role="search">
                          <div class="input-group">
                              <input type="text" class="form-control" name="keyword" value="{{ Request::get('keyword') }}" placeholder="Cari">
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
                                <th>Kode Item</th>
                                <th>Kode Kategori</th>
                                <th>Nama Item</th>
                                <th>Jenis Item</th>
                                <th>Satuan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($items as $item)
                            <tr>
                                <td>{{ $item->KodeItem }}</td>
                                <td>{{ $item->KodeKategori }}</td>
                                <td>{{ $item->NamaItem }}</td>
                                <td>{{ $item->jenisitem }}</td>
                                <td>{{ $item->KodeSatuan }}</td>
                                <td>
                                    {{-- <a href="#" class="btn btn-warning">
                                        <i class="fa fa-pencil" aria-hidden="true"></i>Edit
                                    </a> --}}
                                    <form action="{{ route('dataitem.destroy',$item->KodeItem)}}" method="post">
                                      @method('DELETE')
                                      @csrf
                                      <button type="submit" class="btn btn-danger">
                                          <i class="fa fa-trash" aria-hidden="true"></i>Hapus
                                      </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        {{ $items->links()}}
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
