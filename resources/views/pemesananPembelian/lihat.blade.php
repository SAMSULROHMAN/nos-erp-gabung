@extends('index')
@section('content')
<style type="text/css">
    form {
        margin: 20px 0;
    }

    form input,
    button {
        padding: 5px;
    }

    table {
        width: 100%;
        margin-bottom: 20px;
        border-collapse: collapse;
    }

    table,
    th,
    td {
        border: 1px solid #cdcdcd;
    }

    table th,
    table td {
        padding: 10px;
        text-align: left;
    }
</style>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="x_panel">
                <div class="x_title">
                    <h1>Pemesanan Pembelian</h1>
                    <h3>{{$id}}</h3>
                </div>
                <div class="x_content">
                    <form action="#" method="post">
                        @csrf
                        <!-- Contents -->
                        <br>
                        <div class="form-row">
                            <!-- column 1 -->
                            <div class="form-group col-md-3">
                                <input type="hidden" class="form-control" value="{{$id}}" readonly>
                                <div class="form-group">
                                    <label for="inputDate">Tanggal</label>
                                    <input type="date" class="form-control" id="inputDate" value="{{$data->Tanggal}}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="inputBerlaku">Masa Berlaku</label>
                                    <input type="text" class="form-control" id="inputBerlaku" placeholder="/hari" value="{{$data->Expired}}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="inputPelanggan">Diskon</label>
                                    <input type="number" class="diskon form-control" name="diskon" id="" placeholder="%" value="{{$data->Diskon}}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="inputPelanggan">PPN</label>
                                    @if($data->PPN == "ya")
                                    <input type="text" class="form-control" name="po" id="inputBerlaku" placeholder="" value="Ya" readonly>
                                    @else
                                    <input type="text" class="form-control" name="po" id="inputBerlaku" placeholder="" value="Tidak" readonly>
                                    @endif
                                </div>
                            </div>
                            <!-- pembatas -->
                            <div class="form-group col-md-1"></div>
                            <!-- column 2 -->
                            <div class="form-group col-md-4">
                                <div class="form-group">
                                    <label for="inputMatauang">Mata Uang</label>
                                    <input type="text" class="form-control" placeholder="" value="{{$data->NamaMataUang}}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="inputGudang">Gudang</label>
                                    <input type="text" class="form-control" placeholder="" value="{{$data->NamaLokasi}}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="inputSupplier">Supplier</label>
                                    <input type="text" class="form-control" placeholder="" value="{{$data->NamaSupplier}}" readonly>
                                </div>
                            </div>
                            <!-- pembatas -->
                            <div class="form-group col-md-1"></div>
                            <!-- column 3 -->
                            <div class="form-group col-md-3">
                                <label for="inputKeterangan">Keterangan</label>
                                <textarea class="form-control" name="Keterangan" id="inputKeterangan" rows="5" readonly>{{$data->Keterangan}}</textarea>
                                <br><br>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <input type="hidden" value="1" name="totalItem" id="totalItem">
                                <table id="items">
                                    <tr>
                                        <td>nama barang</td>
                                        <td>qty</td>
                                        <td>satuan</td>
                                        <td>harga</td>
                                        <td>keterangan</td>
                                        <td>total</td>
                                    </tr>
                                    @foreach($items as $item)
                                    <tr class="rowinput">
                                        <td>
                                            {{$item->NamaItem}}
                                        </td>
                                        <td>
                                            {{$item->Qty}}
                                        </td>
                                        <td>
                                            {{$item->NamaSatuan}}
                                        </td>
                                        <td>
                                            Rp. {{number_format($item->Harga)}},-
                                        </td>
                                        <td>
                                            {{$item->Keterangan}}
                                        </td>
                                        <td>
                                            Rp. {{number_format($item->Subtotal)}},-
                                        </td>
                                    </tr>
                                    @endforeach
                                </table>
                                <div class="col-md-9">
                                    @if($OPN == true)
                                    <button type="submit" class="btn btn-success" formaction="{{ url('/popembelian/confirm/'.$id) }}">Konfirmasi</button>
                                    <button type="submit" class="btn btn-danger" formaction="{{ url('/popembelian/cancel/'.$id) }}">Batal</button>
                                    @endif
                                    @if($OPN == false)
                                    <button type="submit" class="btn btn-primary" formaction="{{ url('/popembelian/print/'.$id) }}">Print</button>
                                    @endif
                                </div>
                                <div class="col-md-3">
                                    <label for="inputPelanggan">Subtotal</label>
                                    <input type="text" readonly class="form-control subtotal" value="{{$string_total = "Rp. " . number_format($data->Subtotal, 0, ',', '.') .",-"}}">
                                    <input type="hidden" readonly="" class="form-control subtotal" name="subtotal" id="inputBerlaku" placeholder="" value="{{$data->Subtotal}}">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection