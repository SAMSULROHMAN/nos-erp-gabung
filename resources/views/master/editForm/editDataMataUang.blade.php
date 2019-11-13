@extends('index')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h1>Edit Data Mata Uang</h1>
                    </div>
                    <div class="x_content">
                        @foreach($matauang as $mu)
                        <form action="{{ route('datamatauang.update',$mu->KodeMataUang)}}" method="post">
                        @csrf
                            <div class="form-group">
                                <label>Kode Mata Uang: </label>
                                <input readonly type="text" name="KodeMataUang" value="{{ $mu->KodeMataUang }}" placeholder="Kode Mata Uang" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Nama Mata Uang: </label>
                                <input type="text" required="required" name="NamaMataUang" value="{{ $mu->NamaMataUang }}" placeholder="Nama Mata Uang" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Nilai: </label>
                                <input type="text" required="required" name="Tipe" value="{{ $mu->Nilai }}" placeholder="Nilai" class="form-control">
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
