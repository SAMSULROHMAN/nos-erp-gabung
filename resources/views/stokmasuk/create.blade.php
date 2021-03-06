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
                        <h1>Stok Masuk</h1>
                        
                           
                        <h3>{{$newID}}</h3>
                    </div>
                    <div class="x_content">
                      <form action="/stokmasuk/store" method="post">
                        @csrf
                            <!-- Contents -->
                            <br>
                            <div class="form-row">
                               <div class="form-group">
                                    <input type="hidden" class="form-control" name="KodeStokMasuk" value="{{$newID}}">
                                   <label for="">Nama Gudang</label>
                                    <select name="KodeLokasi" id="" class="form-control">
                                        <option value="">-- Pilih Gudang --</option>
                                        @foreach ($lokasi as $l)
                                            <option value="{{ $l->KodeLokasi}}">{{ $l->NamaLokasi}}</option>
                                        @endforeach
                                    </select>
                               </div>
                               <div class="form-group">
                                   <label for="">Tanggal</label>
                                   <input type="date" name="Tanggal" id="" class="form-control">
                               </div>
                            </div>
                            <br>
                            <div class="form-row">
                            <div class="form-group col-md-12">
                                <a href="#" class="btn btn-success" onclick="addrow()">
                                    <i class="fa fa-plus" aria-hidden="true"></i>Tambah Item
                                </a>
                                <input type="hidden" value="1" name="totalItem" id="totalItem">
                                @foreach($item as $itemData)
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
                                        <td></td>
                                    </tr>
                                    <tr class="rowinput">
                                        <td>
                                            <select name="item[]" onchange="barang(this,1);" class="form-control item1">
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
                                        <td></td>
                                    </tr>
                                </table>
                                <div class="col-md-9">
                                    <button type="submit" class="btn btn-success">Simpan</button>
                                    <button type="submit" class="btn btn-danger">Batal</button>
                                </div>
                                <div class="col-md-3">
                                    
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

    function ppnfunc(){
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
        if(ppn=="ya"){
            ppn = parseInt(befDis)*10/100;
        }
        $(".ppnval").val(ppn);
        $(".diskonval").val(diskon);
        $(".subtotal").val(parseInt($(".subtotal").val())+ppn);
    }
</script>
@endsection
