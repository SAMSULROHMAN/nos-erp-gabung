@extends('index')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h1>Pelunasan Hutang</h1><br>
                    </div>
                    <div class="x_body">
                        <table class="table table-light">
                            <thead class="thead-light">
                                <tr>
                                    <th>Kode Supplier</th>
                                    <th>Nama Supplier</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($suppliers as $sup)
                                    <tr>
                                        <td>{{ $sup->KodeSupplier}}</td>
                                        <td>{{ $sup->NamaSupplier}}</td>
                                        <td><a href="{{url('pelunasanhutang/invoice/'.$sup->KodeSupplier)}}" class="btn btn-primary">Select Invoice</a></td>
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
