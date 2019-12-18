@extends('index')
@section('content')
    <div class="container">
        <div class="row">
            <div class="x_panel">
                <form action="{{ route('datapelanggan.store') }}" method="post">
                    @csrf
                    <div class="col-md-6">
                        <div class="x_panel">
                            <div class="x_title"><h3>Data pelanggan</h3></div>
                            <div class="x_body">
                                <div class="form-group">
                                    <label for="KodePelanggan">Kode Pelanggan</label>
                                    <input id="KodePelanggan" readonly value="{{ $newID }}" class="form-control" type="text" name="KodePelanggan">
                                </div>
                                <div class="form-group">
                                    <label for="NamaPelanggan">Nama Pelanggan</label>
                                    <input id="NamaPelanggan" class="form-control" type="text" name="NamaPelanggan">
                                </div>
                                <div class="form-group">
                                    <label for="Kontak">Kontak</label>
                                    <input id="Kontak" class="form-control" type="number" name="Kontak">
                                </div>
                                <div class="form-group">
                                    <label for="Handphone">Handphone</label>
                                    <input id="Handphone" class="form-control" type="number" name="Handphone">
                                </div>
                                <div class="form-group">
                                    <label for="Email">Email</label>
                                    <input id="Email" class="form-control" type="email" name="Email">
                                </div>
                                <div class="form-group">
                                    <label for="NIK">NIK</label>
                                    <input id="NIK" class="form-control" type="number" name="NIK">
                                </div>
                                <div class="form-group">
                                    <label for="NIK">NPWP</label>
                                    <input id="NIK" class="form-control" type="number" name="NPWP">
                                </div>
                                <input type="hidden" name="status" value="OPN">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="x_panel">
                            <div class="x_title"><h3>Daftar Alamat Pelanggan</h3></div>
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
