@extends('index')
@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="x_panel">
          <div class="x_header">
            <h1>Data Gudang</h1>
            <br>
            <a href="{{ route('datagudang.create')}}" class="btn btn-success">
              <i class="fa fa-plus-square" aria-hidden="true"></i>
              Tambah Gudang
            </a>
            <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                <form action="{{ route('datagudang.index')}}" role="search">
                  <div class="input-group">
                      <input type="text" value="{{ Request::get('keyword') }}" name="keyword" class="form-control" placeholder="Cari Nama Gudang">
                      <span class="input-group-btn">
                        <button class="btn btn-default" type="submit" value="filter">
                            <i class="fa fa-search"></i>
                        </button>
                      </span>
                  </div>
                </form>
            </div>
          </div>
          <div class="x_body">
              <table class="table table-light" id="gudang_table">
                <thead class="thead-light">
                  <tr>
                    <th>Kode Gudang</th>
                    <th>Nama Gudang</th>
                    <th>Tipe</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                      @foreach($lokasi as $lok)
                        <tr>
                        <td>{{$lok->KodeLokasi}}</td>
                        <td>{{$lok->NamaLokasi}}</td>
                        <td>{{$lok->Tipe}}</td>
                        <td>
                          <a href="{{ route('datagudang.edit',$lok->KodeLokasi)}}" class="btn-xs btn btn-warning">
                            <i class="fa fa-pencil" aria-hidden="true"></i>&nbsp;Edit
                          </a>
                          <form class="d-form-inline" action="{{ route('datagudang.destroy',$lok->KodeLokasi)}}" method="post">
                            @method('DELETE')
                            @csrf
                            <button type="submit" class="btn btn-xs btn-danger">Delete</button>
                          </form>
                        </td>
                      </tr>
                      @endforeach
                </tbody>
              </table>
              {{-- <div class="pull-left">
                {{ $lokasi->links() }}
              </div> --}}
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('scripts')
<script type="text/javascript">
    $(document).ready(function(){
      $('#gudang_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('gudang')}}',
            columns: [
                {data: 'KodeLokasi', name: 'KodeLokasi'},
                {data: 'NamaLokasi', name: 'NamaLokasi'},
                {data: 'Tipe', name: 'Tipe'},
                {data: 'Opsi', name: 'Opsi', orderable: false, searchable: false}
            ]
      });
    });
</script>
@endsection
