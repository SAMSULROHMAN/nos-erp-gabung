@extends('index')
@section('content')
<style type="text/css">
    form{
        margin: 20px 0;
    }
    form input, button{
        padding: 5px;
    }
    table{
        width: 100%;
        margin-bottom: 20px;
        border-collapse: collapse;
    }
    table, th, td{
        border: 1px solid #cdcdcd;
    }
    table th, table td{
        padding: 10px;
        text-align: left;
    }
</style>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="x_panel">
                <div class="x_title">
                    <h1>Pemesanan Penjualan</h1>
                    <h3>{{$id}}</h3>
                </div>
                <div class="x_content">
                    <form action="{{ url('/sopenjualan/confirm',$id)}}" method="post">
                        @csrf

                        <!-- Contents -->
                        <br>
                        <div class="form-row">
                            <!-- column 1 -->
                            <div class="form-group col-md-3">
                                <input type="hidden" class="form-control" name="KodeSO" value="{{$id}}">
                                <div class="form-group">
                                    <label for="inputDate">Tanggal</label>
                                    <input type="text" readonly="" class="tgl form-control" name="Tanggal" id="inputDate" value="{{$data->Tanggal}}">
                                </div>
                                <div class="form-group">
                                    <label for="inputDate2">Tanggal Kirim</label>
                                    <input type="text" class="form-control" name="TanggalKirim" readonly="" id="inputDate2" value="{{$data->tgl_kirim}}">
                                </div>
                                <div class="form-group">
                                    <label for="inputBerlaku">Masa Berlaku</label>
                                    <input type="text" class="form-control" name="Expired" readonly=""id="inputBerlaku" placeholder="/hari" value="{{$data->Expired}}">
                                </div>
                                <div class="form-group">
                                    <label for="inputTerm">Term</label>
                                    <input type="text" class="form-control" name="Term" readonly="" id="inputTerm" placeholder="/hari" value="{{$data->term}}">
                                </div>
                                <div class="form-group">
                                    <label for="inputPelanggan">P.O. Customer</label>
                                    <input readonly="" type="text" class="form-control" name="po" id="inputBerlaku" placeholder="" value="{{$data->POPelanggan}}">
                                </div>
                            </div>
                            <!-- pembatas -->
                            <div class="form-group col-md-1"></div>
                            <!-- column 2 -->
                            <div class="form-group col-md-4">
                                <div class="form-group">
                                    <label for="inputMatauang">Mata Uang</label>
                                    <input readonly="" type="text" class="form-control" name="po" id="inputBerlaku" placeholder="" value="{{$data->NamaMataUang}}">
                                </div>
                                <div class="form-group">
                                    <label for="inputGudang">Gudang</label>
                                    <input readonly="" type="text" class="form-control" name="po" id="inputBerlaku" placeholder="" value="{{$data->NamaLokasi}}">
                                </div>
                                <div class="form-group">
                                    <label for="inputPelanggan">Pelanggan</label>
                                    <input readonly="" type="text" class="form-control" name="po" id="inputBerlaku" placeholder="" value="{{$data->NamaPelanggan}}">
                                </div>
                                <div class="form-group">
                                    <label for="inputPelanggan">Diskon</label>
                                    <input readonly="" type="number" onchange="disc()" class="diskon form-control" name="diskon" id="inputBerlaku" placeholder="%" value="{{$data->Diskon}}">
                                </div>
                                <div class="form-group">
                                    <label for="inputPelanggan">PPn</label>
                                        @if($data->PPN == "ya")
                                          <input type="text" readonly="" class="form-control" name="po" id="inputBerlaku" placeholder="" value="Ya">
                                        @else
                                          <input type="text" readonly="" class="form-control" name="po" id="inputBerlaku" placeholder="" value="Tidak">
                                        @endif
                                </div>
                            </div>
                            <!-- pembatas -->
                            <div class="form-group col-md-1"></div>
                            <!-- column 3 -->
                            <div class="form-group col-md-3">
                                <label for="inputKeterangan">Keterangan</label>
                                <textarea readonly="" class="form-control" name="Keterangan" id="inputKeterangan" rows="5">{{$data->Keterangan}}</textarea>
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
                                            <input readonly="" type="text" onchange="qty(1)" class="form-control qty1" required="" value="{{$item->NamaItem}}">
                                        </td>
                                        <td>
                                            <input readonly="" type="number" onchange="qty(1)" class="form-control qty1" required="" value="{{$item->Qty}}">
                                        </td>
                                        <td>
                                            <input readonly="" type="text" class="form-control satuan1" required="" value="{{$item->NamaSatuan}}">
                                        </td>
                                        <td>
                                            <input readonly="" type="text" class="form-control price1" required="" value="{{$item->Harga}}">
                                        </td>
                                        <td>
                                            <input readonly="" type="text" class="form-control keterangan1" required=""  value="{{$item->Keterangan}}">
                                        </td>
                                        <td>
                                            <input readonly="" readonly="" type="text"  class="form-control total1" required=""  value="{{$item->Subtotal}}">
                                        </td>
                                    </tr>
                                    @endforeach
                                </table>
                                <div class="col-md-9">
                                    <button type="submit" class="btn btn-success">Konfirmasi</button>
                                </div>
                                <div class="col-md-3">
                                    <label for="inputPelanggan">Subtotal</label>
                                    <input type="text" readonly="" class="form-control subtotal" name="subtotal" id="inputBerlaku" placeholder="" value="{{$data->Subtotal - $data->NilaiPPN}}">
                                    <label for="inputPelanggan">Nilai PPN</label>
                                    <input type="text" readonly="" name="ppnval" class="ppnval form-control" value="{{$data->NilaiPPN}}">
                                    <input type="hidden" name="diskonval" class="diskonval">
                                    <label for="inputPelanggan">Total</label>
                                    <input type="text" readonly="" class="form-control subtotal" name="subtotal" id="inputBerlaku" placeholder="" value="{{$data->Subtotal}}">
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
