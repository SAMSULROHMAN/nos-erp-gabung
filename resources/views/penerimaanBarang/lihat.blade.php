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
                    <h1>Penerimaan Barang</h1>
                </div>
                <div class="x_content">
                    <form action="#" method="post">
                        @csrf
                        <!-- Contents -->
                        <br>
                        <div class="form-row">
                            <!-- column 1 -->
                            <div class="form-group col-md-3">
                                <div class="form-group">
                                    <label for="">Nomor PO</label>
                                    <input type="text" class="form-control" name="KodePO" readonly="readonly" value="{{$penerimaanbarang->KodePO}}" id="inputBerlaku">
                                </div>
                                <div class="form-group">
                                    <label for="inputDate">Tanggal</label>
                                    <input type="date" class="form-control" name="Tanggal" id="inputDate" readonly="readonly" value="{{$penerimaanbarang->Tanggal}}">
                                </div>
                            </div>
                            <!-- pembatas -->
                            <div class="form-group col-md-1"></div>
                            <!-- column 2 -->
                            <div class="form-group col-md-4">
                                <div class="form-group">
                                    <label for="inputGudang">Gudang</label>
                                    <input type="text" class="form-control" name="KodeLokasi" readonly="readonly" value="{{$lokasi->NamaLokasi}}">
                                </div>
                                <div class="form-group">
                                    <label for="inputPelanggan">Supplier</label>
                                    <input type="text" class="form-control" name="KodeSupplier" readonly="readonly" value="{{$supplier->NamaSupplier}}">
                                </div>
                                <div class="form-group">
                                    <label for="inputPelanggan">Diskon</label>
                                    <input type="number" readonly="readonly" class="diskon form-control diskon" name="diskon" id="inputBerlaku" value="{{$penerimaanbarang->Diskon}}">
                                </div>
                                <div class="form-group">
                                    <label for="inputPelanggan">PPN</label>
                                    <input type="text" readonly="readonly" class="diskon form-control ppn" name="ppn" id="inputBerlaku" value="{{$penerimaanbarang->PPN}}">
                                </div>
                            </div>
                            <!-- pembatas -->
                            <div class="form-group col-md-1"></div>
                            <!-- column 3 -->
                            <!-- <div class="form-group col-md-3">
                                <label for="inputKeterangan">Keterangan</label>
                                <textarea class="form-control" name="Keterangan" id="inputKeterangan" rows="5"></textarea>
                                <br><br>
                            </div> -->
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <table id="items">
                                    <tr>
                                        <td>nama barang</td>
                                        <td>qty</td>
                                        <td>satuan</td>
                                        <td>harga</td>
                                        <td>keterangan</td>
                                        <td>total</td>
                                    </tr>
                                    @foreach($items as $key => $data)
                                    <tr class="rowinput">
                                        <td>
                                            {{$data->NamaItem}}
                                            <input type="hidden" readonly="readonly" name="item[]" value="{{$data->KodeItem}}">
                                        </td>
                                        <td>
                                            {{$data->jml}}
                                            <input type="hidden" class="max{{$key+1}}" value="{{$data->jml}}">
                                        </td>
                                        <td>
                                            {{$data->NamaSatuan}}
                                        </td>
                                        <td>
                                            Rp. {{number_format($data->HargaBeli)}},-
                                            <input type="hidden" name="price[]" class="form-control price{{$key+1}}" required="" value="{{$data->HargaBeli}}">
                                        </td>
                                        <td>
                                            {{$data->Keterangan}}
                                        </td>
                                        <td>
                                            Rp. {{number_format($data->HargaBeli * $data->jml)}},-
                                            <input type="hidden" name="total[]" class="form-control total{{$key+1}}" required="" value="{{$data->HargaBeli * $data->jml}}">
                                        </td>
                                    </tr>
                                    @endforeach

                                </table>
                                <div class="col-md-9">
                                    @if($OPN == true)
                                    <button type="submit" class="btn btn-success" formaction="{{ url('/penerimaanBarang/confirm/'.$id) }}">Konfirmasi</button>
                                    <button type="submit" class="btn btn-danger" formaction="{{ url('/penerimaanBarang/cancel/'.$id) }}">Batal</button>
                                    @endif
                                    @if($OPN == false)
                                    <button type="submit" class="btn btn-primary" formaction="{{ url('/penerimaanBarang/print/'.$id) }}">Print</button>
                                    @endif
                                </div>
                                <div class="col-md-3">
                                    <label for="inputPelanggan">PPN</label>
                                    <input type="text" readonly="" name="ppnval" class="ppnval form-control">
                                    <label for="inputPelanggan">Subtotal</label>
                                    <input type="hidden" value="{{sizeof($items)}}" name="" class="tot">
                                    <input type="text" readonly="" class="form-control befDis" id="inputBerlaku" placeholder="">
                                    <label for="inputPelanggan">Diskon</label>
                                    <input type="text" readonly="" class="form-control diskonval" name="diskonval">
                                    <label for="inputPelanggan">Total</label>
                                    <input type="text" readonly="" class="form-control subtotal" name="subtotal" id="inputBerlaku" placeholder="">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function refresh(val) {
        var base = "{{ url('/') }}" + "/penerimaanBarang/create/" + val.value;
        window.location.href = base;
    }

    updatePrice($(".tot").val());

    function updatePrice(tot) {

        $(".subtotal").val(0);
        var diskon = 0;
        if ($(".diskon").val() != "") {
            diskon = parseInt($(".diskon").val());
        }
        for (var i = 1; i <= tot; i++) {
            if ($(".total" + i).val() != undefined) {
                $(".subtotal").val(parseInt($(".subtotal").val()) + parseInt($(".total" + i).val()));
            }
        }
        var befDis = $(".subtotal").val();
        diskon = parseInt($(".subtotal").val()) * diskon / 100;
        $(".subtotal").val(parseInt($(".subtotal").val()) - diskon);
        var ppn = $(".ppn").val();
        if (ppn == "ya") {
            ppn = parseInt(befDis) * 10 / 100;
        } else {
            ppn = 0;
        }
        $(".ppnval").val(parseInt(ppn).toLocaleString('en'));
        $(".diskonval").val(parseInt(diskon).toLocaleString('en'));
        $(".befDis").val(parseInt($(".subtotal").val()).toLocaleString('en'));
        $(".subtotal").val(parseInt(parseInt($(".subtotal").val()) + ppn).toLocaleString('en'));
    }

    function qty(int) {
        var qty = $(".qty" + int).val();
        var max = $(".max" + int).val();
        if (parseInt(qty) > parseInt(max)) {
            $(".qty" + int).val(max);
        }
        var qty = $(".qty" + int).val();
        var price = $(".price" + int).val();
        $(".total" + int).val(price * qty);
        var count = $(".tot").val();
        updatePrice(count);
    }
</script>
@endsection