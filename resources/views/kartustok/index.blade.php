@extends('index')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h1>Kartu Stok</h1><br>
                        <h2>Filter</h2><br>
                        <div class="row">
                            <form action="{{ url('/kartustok/filter') }}" method="post">
                                @csrf
                                <div class="col-md-3">
                                    <label>Start date</label>
                                    <input type="date" class="form-control" name="start" required="">
                                    <label>End date</label>
                                    <input type="date" class="form-control" name="finish" required="">
                                </div>
                                <div class="col-md-3">
                                    <label>Store</label>
                                    <select class="form-control" name="lokasi">
                                        @foreach($store as $l)
                                            <option value="{{$l->KodeLokasi}}">{{$l->NamaLokasi}}</option>
                                        @endforeach
                                    </select>
                                    <label>Item</label>
                                    <select class="form-control" name="item">
                                        @foreach($item as $l)
                                            <option value="{{$l->KodeItem}}">{{$l->NamaItem}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label>Satuan</label>
                                    <select class="form-control" name="satuan">
                                        @foreach($satuan as $l)
                                            <option value="{{$l->KodeSatuan}}">{{$l->NamaSatuan}}</option>
                                        @endforeach
                                    </select>
                                    <label></label>
                                    <input type="submit" class="form-control btn btn-primary" value="search" name="">
                                </div>
                            </form>
                            <form action="{{ url('/kartustok/print') }}" method="post">
                                @csrf
                                <div class="row pull-right">
                                    @if($filter)
                                        <input type="hidden" value="{{$start}}" name="start">
                                        <input type="hidden" value="{{$finish}}" name="finish">
                                        <input type="hidden" value="{{$itemfil}}" name="item">
                                        <input type="hidden" value="{{$lokasifil}}" name="lokasi">
                                        <input type="hidden" value="{{$satuanfil}}" name="satuan">
                                    @endif
                                    <input type="submit" name="" value="Print" class="btn btn-danger">
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="x_body">
                        <table class="table table-light">
                            <thead class="thead-light">
                                <tr>
                                    <th>Tanggal Transaksi</th>
                                    <th>ID Item</th>
                                    <th>ID Gudang</th>
                                    <th>Jenis Transaksi</th>
                                    <th>Kode Transaksi</th>
                                    <th>QTY</th>
                                    <th>User</th>
                                    <th>Saldo</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($stok as $stokmasuk)
                                    <tr>
                                        <td>{{ $stokmasuk->Tanggal}}</td>
                                        <td>{{ $stokmasuk->KodeItem}}</td>
                                        <td>{{ $stokmasuk->KodeLokasi}}</td>
                                        <td>{{ $stokmasuk->JenisTransaksi }}</td>
                                        <td>{{ $stokmasuk->KodeTransaksi}}</td>
                                        <td>{{ $stokmasuk->Qty}}</td>
                                        <td>{{ $stokmasuk->KodeUser}}</td>
                                        <td>{{ $stokmasuk->saldo}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
