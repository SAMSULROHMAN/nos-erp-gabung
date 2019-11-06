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
                    <form action="{{ url('/sopenjualan/update',$id)}}" class="formsub" method="post">
                        @csrf

                        <!-- Contents -->
                        <br>
                        <div class="form-row">
                            <!-- column 1 -->
                            <div class="form-group col-md-3">
                                <input type="hidden" class="form-control" name="KodeSO" value="{{$id}}">
                                <div class="form-group">
                                    <label for="inputDate">Tanggal</label>
                                    <input type="date" class="form-control" name="Tanggal" id="inputDate" value="{{$data->Tanggal}}">
                                </div>
                                <div class="form-group">
                                    <label for="inputDate2">Tanggal Kirim</label>
                                    <input type="date" class="form-control" name="TanggalKirim" id="inputDate2" value="{{$data->tgl_kirim}}">
                                </div>
                                <div class="form-group">
                                    <label for="inputBerlaku">Masa Berlaku</label>
                                    <input type="text" class="form-control" name="Expired" id="inputBerlaku" placeholder="/hari" value="{{$data->Expired}}">
                                </div>
                                <div class="form-group">
                                    <label for="inputTerm">Term</label>
                                    <input type="text" class="form-control" name="Term" id="inputTerm" placeholder="/hari" value="{{$data->term}}">
                                </div>
                                <div class="form-group">
                                    <label for="inputPelanggan">P.O. Customer</label>
                                    <input type="text" class="form-control" name="po" id="inputBerlaku" placeholder="" value="{{$data->POPelanggan}}">
                                </div>
                            </div>
                            <!-- pembatas -->
                            <div class="form-group col-md-1"></div>
                            <!-- column 2 -->
                            <div class="form-group col-md-4">
                                <div class="form-group">
                                    <label for="inputMatauang">Mata Uang</label>
                                    <select class="form-control" required="required" name="KodeMataUang" id="inputMatauang" placeholder="Pilih mata uang">
                                        @foreach($matauang as $mu)
                                            @if($data->KodeMataUang == $mu->KodeMataUang)
                                                <option value="{{$mu->KodeMataUang}}" selected="">{{$mu->NamaMataUang}}</option>
                                            @else
                                                <option value="{{$mu->KodeMataUang}}">{{$mu->NamaMataUang}}</option>
                                            @endif

                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="inputGudang">Gudang</label>
                                    <select class="form-control" required="required" name="KodeLokasi" id="inputGudang">
                                        @foreach($lokasi as $lok)
                                            @if($data->KodeLokasi == $lok->KodeLokasi)
                                                <option value="{{$lok->KodeLokasi}}" selected="" >{{$lok->NamaLokasi}}</option>
                                            @else
                                                <option value="{{$lok->KodeLokasi}}">{{$lok->NamaLokasi}}</option>
                                            @endif

                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="inputPelanggan">Pelanggan</label>
                                    <select class="form-control" name="KodePelanggan" id="inputPelanggan">
                                        @foreach($pelanggan as $pel)
                                            @if($data->KodePelanggan == $pel->KodePelanggan)
                                                <option value="{{$pel->KodePelanggan}}" selected="">{{$pel->NamaPelanggan}}</option>
                                            @else
                                                <option value="{{$pel->KodePelanggan}}">{{$pel->NamaPelanggan}}</option>
                                            @endif
                                        @endforeach
                                    </select>

                                </div>
                                <div class="form-group">
                                    <label for="inputPelanggan">Diskon</label>
                                    <input type="number" onchange="disc()" class="diskon form-control" name="diskon" id="inputBerlaku" placeholder="%" value="{{$data->Diskon}}">
                                </div>
                                <div class="form-group">
                                    <label for="inputPelanggan">PPn</label>
                                    <select class="form-control ppn" onchange="ppnfunc(this)" name="ppn" id="ppn">
                                        @if($data->PPN == "ya")
                                            <option selected="" value="ya">Ya</option>
                                            <option value="tidak">Tidak</option>
                                        @else
                                            <option value="ya">Ya</option>
                                            <option selected="" value="tidak">Tidak</option>
                                        @endif

                                    </select>

                                </div>
                            </div>
                            <!-- pembatas -->
                            <div class="form-group col-md-1"></div>
                            <!-- column 3 -->
                            <div class="form-group col-md-3">
                                <label for="inputKeterangan">Keterangan</label>
                                <textarea class="form-control" name="Keterangan" id="inputKeterangan" rows="5">{{$data->Keterangan}}</textarea>
                                <br><br>

                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <a href="#" class="btn btn-success" onclick="addrow()">
                                    <i class="fa fa-plus" aria-hidden="true"></i>Tambah Item
                                </a>
                                <input type="hidden" value="{{count($items)}}" name="totalItem" id="totalItem">
                                @foreach($itemSelect as $itemData)
                                    <input type="hidden" id="{{$itemData->KodeItem}}" value="{{$itemData->HargaJual}}">
                                    <input type="hidden" id="{{$itemData->KodeItem}}Ket" value="{{$itemData->Keterangan}}">
                                    <input type="hidden" id="{{$itemData->KodeItem}}Sat" value="{{$itemData->NamaSatuan}}">
                                @endforeach
                                <table id="items">
                                    <tr>
                                        <td>nama barang</td>
                                        <td>qty</td>
                                        <td>satuan</td>
                                        <td>harga</td>
                                        <td>keterangan</td>
                                        <td>total</td>
                                        <td></td>
                                    </tr>
                                    @foreach($items as $a => $item)
                                    @if($a==0)
                                        <tr class="rowinput">
                                    @else
                                        <tr class="tambah{{$a+1}}">
                                    @endif
                                        <td>
                                            <select name="item[]" onchange="barang(this,{{$a+1}});" class="form-control item{{$a+1}}">
                                                @foreach($itemSelect as $itemData)
                                                    @if($itemData->KodeItem == $item->KodeItem)
                                                        <option value="{{$itemData->KodeItem}}" selected="">{{$itemData->NamaItem}}</option>
                                                    @else
                                                        <option value="{{$itemData->KodeItem}}">{{$itemData->NamaItem}}</option>
                                                    @endif
                                                @endforeach
                                            </select>

                                        </td>
                                        <td>
                                            <input type="number" onchange="qty({{$a+1}})" class="form-control qty{{$a+1}}" name="qty[]" required="" value="{{$item->Qty}}">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control satuan{{$a+1}}" required="" readonly="" value="{{$item->NamaSatuan}}">
                                        </td>
                                        <td>
                                            <input readonly="" type="text" class="form-control price{{$a+1}}" name="price[]" required="" value="{{$item->Harga}}">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control keterangan{{$a+1}}" required=""  value="{{$item->Keterangan}}">
                                        </td>
                                        <td>
                                            <input readonly="" type="text"  class="form-control total{{$a+1}}" name="total[]" required=""  value="{{$item->Subtotal}}">
                                        </td>
                                        @if($a==0)
                                            <td></td>
                                        @else
                                            <td><i onclick="del({{$a+1}})" class="fa fa-trash"></i></td>
                                        @endif

                                    </tr>
                                    @endforeach
                                </table>
                                <div class="col-md-9">
                                    <button type="submit" class="btn btn-success">Update</button>
                                </div>
                                <div class="col-md-3">
                                    <label for="inputPelanggan">Subtotal</label>
                                    <input type="text" readonly="" class="form-control befDis" name="subtotal" id="inputBerlaku" placeholder="" value="{{$data->Subtotal - $data->NilaiPPN}}">
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
@section('scripts')
<script type="text/javascript">

    var item =$(".item"+1).val();
    var sat =$("#"+item+"Sat").val();
    $(".satuan"+1).val(sat);
    var ket =$("#"+item+"Ket").val();
    $(".keterangan"+1).val(ket);

    function qty(int){
        var qty =$(".qty"+int).val();
        var item =$(".item"+int).val();
        var price =$("#"+item).val();
        $(".price"+int).val(price);
        $(".total"+int).val(price*qty);
        var count =$("#totalItem").val();
        updatePrice(count);
    }

    function addrow(){
        $("#totalItem").val(parseInt($("#totalItem").val())+1);
        var count =$("#totalItem").val();
        var markup = $(".rowinput").html();
        var res = "<tr class='tambah"+count+"'>"+markup+"</tr>";
        res = res.replace("qty1", "qty"+count);
        res = res.replace("item1", "item"+count);
        res = res.replace("price1", "price"+count);
        res = res.replace("total1", "total"+count);
        res = res.replace("qty(1)", "qty("+count+")");
        res = res.replace("barang(this,1", "barang(this,"+count);
        res = res.replace("satuan1", "satuan"+count);
        res = res.replace("keterangan1", "keterangan"+count);
        res = res.replace("<td></td>", '<td><i onclick="del('+count+')" class="fa fa-trash"></i></td>');

        $("#items tbody").append(res);
        var item =$(".item"+count).val();
        var sat =$("#"+item+"Sat").val();
        $(".satuan"+count).val(sat);
        var ket =$("#"+item+"Ket").val();
        $(".keterangan"+count).val(ket);
    }

    function barang(val,int){
        var sat =$("#"+val.value+"Sat").val();
        $(".satuan"+int).val(sat);
        var ket =$("#"+val.value+"Ket").val();
        $(".keterangan"+int).val(ket);
        $(".price"+int).val(0);
        $(".total"+int).val(0);
        $(".qty"+int).val(0);
    }

    function del(int){
        $(".tambah"+int).remove();
        var count =$("#totalItem").val();
        updatePrice(count);
    }

    function disc(){
        var count =$("#totalItem").val();
        updatePrice(count);
    }

    function ppnfunc(val){

        if(val.value=='ya'){
            $(".a").hide();
            $(".b").show();
            $(".idp").val($(".b").text());
        }else{
            $(".a").show();
            $(".b").hide();
            $(".idp").val($(".a").text());
        }

        var count =$("#totalItem").val();
        updatePrice(count);
    }

    function updatePrice(tot){
        $(".subtotal").val(0);
        var diskon=0;
        if($(".diskon").val()!=""){
            diskon = parseInt($(".diskon").val());
        }
        for(var i=1; i<=tot;i++){
            if($(".total"+i).val()!=undefined){
                $(".subtotal").val(parseInt($(".subtotal").val())+parseInt($(".total"+i).val()));
            }
        }
        var befDis = $(".subtotal").val();
        diskon = parseInt($(".subtotal").val())*diskon/100;
        $(".subtotal").val(parseInt($(".subtotal").val())-diskon);
        var ppn =$(".ppn").val();
        console.log(ppn);
        if(ppn=="ya"){
            ppn = parseInt(befDis)*10/100;
        }else{
            ppn = parseInt(0);
        }
        console.log(ppn);
        $(".ppnval").val(ppn);
        $(".diskonval").val(diskon);
        $(".befDis").val(parseInt($(".subtotal").val()));
        $(".subtotal").val(parseInt($(".subtotal").val())+ppn);
    }

    $('.formsub').submit(function(event){
        tot = $("#totalItem").val();
        console.log(tot);
        for (var i = 1; i <= tot; i++) {
            if (typeof $(".qty"+i).val()=== 'undefined'){
            }else{
                if ($(".qty"+i).val() == 0){
                    event.preventDefault();
                    $(".qty"+i).focus();
                }
            }

        }

    });
</script>
@endsection
