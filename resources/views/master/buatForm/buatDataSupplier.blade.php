@extends('index')
{{-- @section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h1>Tambah Data Supplier</h1>
                    </div>
                    <div class="x_content">
                        <form action="{{ route('datasupplier.store')}}" method="post">
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
@endsection --}}
@section('content')
    <div class="container">
        <div class="row">
            <div class="x_panel">
                <form action="{{ route('datasupplier.store') }}" method="post">
                    @csrf
                    <div class="col-md-6">
                        <div class="x_panel">
                            <div class="x_title"><h3>Data Supplier</h3></div>
                            <div class="x_body">
                                <div class="form-group">
                                    <label>Kode Supplier: </label>
                                    <input readonly type="text" value="{{$newID}}" name="KodeSupplier" required="required" placeholder="Kode Supplier" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Nama Supplier: </label>
                                    <input type="text" required="required" type="text" name="NamaSupplier" placeholder="Nama Supplier" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Kontak: </label>
                                    <input type="text" required="required" name="Kontak" placeholder="Kontak" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Handphone: </label>
                                    <input type="text" required="required" name="Handphone" placeholder="Handphone" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="x_panel">
                            <div class="x_title"><h3>Daftar Alamat Supplier</h3></div>
                            <div class="x_content">
                                <table class="table table-responsive">
                                    <thead>
                                        <tr>
                                            <th>Alamat</th>
                                            <th>
                                                <a href="#" class="btn btn-sm btn-info addRow">
                                                    <i class="fa fa-plus"></i>
                                                </a>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <input type="text" name="alamat[]" id="" class="form-control">
                                            </td>
                                            <td>
                                                <a href="#" class="btn btn-sm btn-danger" id="remove">
                                                    <i class="fa fa-minus"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="form-group pull-right">
                        <input type="submit" value="Simpan" class="btn btn-md btn-success">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $('.addRow').on('click',function(){
            tambahRow();
        });

        function tambahRow()
        {
            let tr = '<tr>'+
                        '<td>'+
                            '<input type="text" name="alamat[]" id="" class="form-control">'+
                        '</td>'+
                        '<td>'+
                            '<a href="#" class="btn btn-sm btn-danger" id="remove">'+
                                '<i class="fa fa-minus"></i>'+
                            '</a>'+
                        '</td>'+
                    '</tr>';
            $('tbody').append(tr);
        }

        $('tbody').on('click','#remove',function(){
            $(this).parent().parent().remove();
        });
    </script>
@endsection
