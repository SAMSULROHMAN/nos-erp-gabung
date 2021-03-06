<!DOCTYPE html>
<html>

<head>
	<title></title>
	<style>
		* {
			box-sizing: border-box;
		}

		/* Create two equal columns that floats next to each other */
		.column {
			float: left;
			width: 50%;
			padding: 10px;
			height: 300px;
			/* Should be removed. Only for demonstration */
		}

		/* Clear floats after the columns */
		.row:after {
			content: "";
			display: table;
			clear: both;
		}
	</style>
</head>

<body>
	<p>Kode PO : {{$data->KodePO}}</p>
    <p>Kode Penerimaan Barang : {{$data->KodePenerimaanBarang}}</p>
    @foreach($supplier as $sup)
    <p>Supplier : {{$sup->NamaSupplier}}</p>
    @endforeach
    @foreach($lokasi as $lok)
    <p>Gudang : {{$lok->NamaLokasi}}</p>
    @endforeach
	<br>
	<p>Daftar Barang:</p>
	<table width="100%" class="tb" border="1px solid red">
		<thead>
			<tr>
				<td>Kode Item</td>
				<td>Nama Barang</td>
				<td>Jumlah</td>
				<td>Harga</td>
				<td>Subtotal</td>
			</tr>
		</thead>
		<tbody>
			@foreach($items as $item)
			<tr>
				<td>{{$item->KodeItem}}</td>
				<td>{{$item->NamaItem}}</td>
				<td>{{$item->jml}}</td>
				<td>{{$item->HargaBeli}}</td>
				<td>{{$item->HargaBeli*$item->jml}}</td>
			</tr>
			@endforeach
		</tbody>
	</table>
	<div class="row">
		<div class="column">
			<p>Total Barang : {{$jml}}</p>
			<p>Keterangan : {{$data->Keterangan}}</p>
		</div>
		<div class="column">
			<p>Diskon : {{$data->NilaiDiskon}}</p>
			<p>PPn : {{$data->NilaiPPN}}</p>
			<p>Subtotal : {{$data->Subtotal}}</p>
		</div>
	</div>
</body>

</html>