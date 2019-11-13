@extends('index')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="x_panel">
                <div class="x_title">
                    <h1>Tambah data</h1>
                </div>
                <div class="x_content">
                    <form action="{{ route('dataitem.store')}}" class="form-horizontal form-label-left input_mask" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="">Kode Kategori</label>
                            <select class="form-control" name="KodeKategori" id="KodeKategori">
                                <option value=""> --Pilih Kode Kategori --</option>
                                @foreach ($kategori as $k)
                                    <option value="{{ $k->KodeKategori}}">{{ $k->NamaKategori }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="NamaItem">Nama Item</label>
                            <input id="NamaItem" class="form-control" type="text" name="NamaItem" placeholder="Nama Item">
                        </div>
                        <div class="form-group">
                            <label for="">Jenis Item</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="jenisitem" id="bb" value="BahanBaku">
                                <label class="form-check-label" for="bb">Bahan Baku</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="jenisitem" id="bahanjadi" value="BahanJadi">
                                <label class="form-check-label" for="bahanjadi">Bahan Jadi</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">Satuan</label>
                            <select name="KodeSatuan" id="satuan" class="form-control">
                                <option value="">-- Pilih Satuan --</option>
                                @foreach ($satuan as $s)
                                    <option value="{{ $s->KodeSatuan}}">{{ $s->NamaSatuan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Konversi</label>
                            <input type="number" readonly name="Konversi" id="" class="form-control" value="1">
                        </div>
                        <div class="form-group">
                            <label for="">Harga Jual</label>
                            <input type="text" name="HargaJual" id="HargaJual" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Harga Beli</label>
                            <input type="text" name="HargaBeli" id="HargaBeli" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Harga Grosir</label>
                            <input type="text" name="HargaGrosir" id="Grosir" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="Alias">Alias</label>
                            <input id="Alias" class="form-control" type="text" name="Alias">
                        </div>
                        <div class="form-group">
                            <label for="Keterangan">Keterangan</label>
                            <textarea id="Keterangan" class="form-control" name="Keterangan"></textarea>
                        </div>
                        <div class="form-group">
                            <input type="submit" value="Simpan" class="btn btn-success">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
  <script type="text/javascript">
      $('#KodeKategori').select2();
      $('#satuan').select2();
  </script>
@endsection
