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
                    <h3 class="a" style="display: none;">{{$newID}}</h3>
                    <h3 class="b">{{$newID_tax}}</h3>
                </div>
                <div class="x_content">
                    <form action="{{ url('/popembelian/store') }}" method="get" class="formsub">
                        @csrf
                        <!-- Contents -->
                        <br>
                        <div class="form-row">
                            <!-- column 1 -->
                            <div class="form-group col-md-3">
                                <div class="form-group">
                                    <input type="hidden" class="form-control idp" name="KodePO" value="{{$newID_tax}}">
                                </div>
                                <div class="form-group">
                                    <label for="inputDate">Tanggal</label>
                                    <input type="date" class="form-control" name="Tanggal" id="inputDate" value="{{$dateNow}}">
                                </div>
                                <div class="form-group">
                                    <label for="inputBerlaku">Masa Berlaku</label>
                                    <input type="text" class="form-control" name="Expired" id="inputBerlaku" placeholder="/hari">
                                </div>
                                <div class="form-group">
                                    <label for="inputDiskon">Diskon</label>
                                    <input type="number" onchange="disc()" class="diskon form-control" name="diskon" id="inputDiskon" placeholder="%">
                                </div>
                                <div class="form-group">
                                    <label for="inputPPN">PPN</label>
                                    <select class="form-control ppn" onchange="ppnfunc(this)" name="ppn" id="ppn">
                                        <option value="ya">Ya</option>
                                        <option value="tidak">Tidak</option>
                                    </select>
                                </div>
                            </div>
                            <!-- pembatas -->
                            <div class="form-group col-md-1"></div>
                            <!-- column 2 -->
                            <div class="form-group col-md-4">
                                <div class="form-group">
                                    <label for="inputMatauang">Mata Uang</label>
                                    <select class="form-control" name="KodeMataUang" id="inputMatauang" placeholder="Pilih mata uang">
                                        @foreach($matauang as $mu)
                                        <option value="{{$mu->KodeMataUang}}">{{$mu->NamaMataUang}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="inputGudang">Gudang</label>
                                    <select class="form-control" name="KodeLokasi" id="inputGudang">
                                        @foreach($lokasi as $lok)
                                        <option value="{{$lok->KodeLokasi}}">{{$lok->NamaLokasi}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="inputSupplier">Supplier</label>
                                    <select class="form-control" name="KodeSupplier" id="inputSupplier">
                                        @foreach($supplier as $sup)
                                        <option value="{{$sup->KodeSupplier}}">{{$sup->NamaSupplier}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <!-- pembatas -->
                            <div class="form-group col-md-1"></div>
                            <!-- column 3 -->
                            <div class="form-group col-md-3">
                                <label for="inputKeterangan">Keterangan</label>
                                <textarea class="form-control" name="Keterangan" id="inputKeterangan" rows="5"></textarea>
                                <br><br>
                                <!-- <button type="submit" class="btn btn-success">Simpan</button> -->
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <br>
                                <a href="#" class="btn btn-success" onclick="addrow()">
                                    <i class="fa fa-plus" aria-hidden="true"></i>Tambah Item
                                </a>
                                <br><br>
                                <input type="hidden" value="1" name="totalItem" id="totalItem">
                                @foreach($item as $itemData)
                                <input type="hidden" id="{{$itemData->KodeItem}}" value="{{$itemData->HargaBeli}}">
                                <input type="hidden" id="{{$itemData->KodeItem}}Ket" value="{{$itemData->Keterangan}}">
                                <input type="hidden" id="{{$itemData->KodeItem}}Sat" value="{{$itemData->NamaSatuan}}">
                                @endforeach
                                <table id="items">
                                    <tr>
                                        <td>Nama Barang</td>
                                        <td>Qty</td>
                                        <td>Satuan</td>
                                        <td>Harga</td>
                                        <td>Keterangan</td>
                                        <td>Total</td>
                                        <td>Hapus</td>
                                    </tr>
                                    <tr class="rowinput">
                                        <td>
                                            <select id="select" name="item[]" onchange="barang(this,1);" class="form-control item1">
                                                @foreach($item as $itemData)
                                                <option value="{{$itemData->KodeItem}}">{{$itemData->NamaItem}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <input type="number" onchange="qty(1)" name="qty[]" class="form-control qty1" required="" value="0">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control satuan1" required="" value="0">
                                        </td>
                                        <td>
                                            <input readonly="" type="text" name="price[]" class="form-control price1" required="" value="0">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control keterangan1" required="" value="0">
                                        </td>
                                        <td>
                                            <input readonly="" type="text" name="total[]" class="form-control total1" required="" value="0">
                                        </td>
                                        <td></td>
                                    </tr>
                                </table>
                                <div class="col-md-9">
                                    <button type="submit" class="btn btn-success">Simpan</button>
                                    <button type="submit" class="btn btn-danger">Batal</button>
                                </div>
                                <div class="col-md-3">
                                    <br>
                                    <label>Subtotal</label>
                                    <input type="text" readonly class="form-control befDis" value="0" placeholder="">
                                    <label class="c">Nilai PPN</label>
                                    <input type="text" readonly value="0" name="NilaiPPN" class="c NilaiPPN form-control">
                                    <label>Diskon</label>
                                    <input type="text" readonly value="0" name="NilaiDiskon" class="NilaiDiskon form-control">
                                    <label>Total</label>
                                    <input type="text" readonly class="form-control subtotal" value="0" name="subtotal" id="inputBerlaku" placeholder="">
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

@section('scripts')
<script type="text/javascript">
    $(document).ready(function() {
        $("#select").select2();
    });
    var item = $(".item" + 1).val();
    var sat = $("#" + item + "Sat").val();
    $(".satuan" + 1).val(sat);
    var ket = $("#" + item + "Ket").val();
    $(".keterangan" + 1).val(ket);

    function qty(int) {
        var qty = $(".qty" + int).val();
        var item = $(".item" + int).val();
        var price = $("#" + item).val();
        $(".price" + int).val(price);
        $(".total" + int).val(price * qty);
        var count = $("#totalItem").val();
        updatePrice(count);
    }

    function addrow() {
        $("#totalItem").val(parseInt($("#totalItem").val()) + 1);
        var count = $("#totalItem").val();
        var markup = $(".rowinput").html();
        var res = "<tr class='tambah" + count + "'>" + markup + "</tr>";
        res = res.replace("qty1", "qty" + count);
        res = res.replace("item1", "item" + count);
        res = res.replace("price1", "price" + count);
        res = res.replace("total1", "total" + count);
        res = res.replace("qty(1)", "qty(" + count + ")");
        res = res.replace("barang(this,1", "barang(this," + count);
        res = res.replace("satuan1", "satuan" + count);
        res = res.replace("keterangan1", "keterangan" + count);
        res = res.replace("<td></td>", '<td><i onclick="del(' + count + ')" class="fa fa-trash"></i></td>');

        $("#items tbody").append(res);
        var item = $(".item" + count).val();
        var sat = $("#" + item + "Sat").val();
        $(".satuan" + count).val(sat);
        var ket = $("#" + item + "Ket").val();
        $(".keterangan" + count).val(ket);
    }

    function barang(val, int) {
        var sat = $("#" + val.value + "Sat").val();
        $(".satuan" + int).val(sat);
        var ket = $("#" + val.value + "Ket").val();
        $(".keterangan" + int).val(ket);
        $(".price" + int).val(0);
        $(".total" + int).val(0);
        $(".qty" + int).val(0);
    }

    function del(int) {
        $(".tambah" + int).remove();
        var count = $("#totalItem").val();
        updatePrice(count);
    }

    function disc() {
        var count = $("#totalItem").val();
        updatePrice(count);
    }

    function ppnfunc(val) {
        if (val.value == 'ya') {
            $(".a").hide();
            $(".b").show();
            $(".c").show();
            $(".idp").val($(".b").text());
        } else {
            $(".a").show();
            $(".b").hide();
            $(".c").hide();
            $(".idp").val($(".a").text());
        }

        var count = $("#totalItem").val();
        updatePrice(count);
    }

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
        } else if (ppn == "tidak") {
            ppn = 0;
        }
        $(".NilaiPPN").val(ppn);
        $(".NilaiDiskon").val(diskon);
        $(".befDis").val(parseInt($(".subtotal").val()));
        $(".subtotal").val(parseInt($(".subtotal").val()) + ppn);
    }
    $('.formsub').submit(function(event) {
        tot = $("#totalItem").val();
        for (var i = 1; i <= tot; i++) {
            if (typeof $(".qty" + i).val() === 'undefined') {} else {
                if ($(".qty" + i).val() == 0) {
                    event.preventDefault();
                    $(".qty" + i).focus();
                }
            }
        }
    });
</script>
@endsection