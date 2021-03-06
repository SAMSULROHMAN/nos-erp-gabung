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
	  height: 300px; /* Should be removed. Only for demonstration */
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
	<p>Kode SO : {{$data->KodeSO}}</p>
	<p>Kode Surat Jalan : {{$data->KodeSuratJalan}}</p>
	<p>Kode Surat Jalan Return : {{$data->KodeSuratJalanReturn}}</p>
	<br><br>
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
				<td>Kode Item</td>
				<td>{{$item->NamaItem}}</td>
				<td>{{$item->jml}}</td>
				<td>{{$item->HargaJual}}</td>
				<td>{{$item->HargaJual*$item->jml*-1}}</td>
			</tr>
			@endforeach
		</tbody>
	</table>
	<div class="row">
	  <div class="column" >
	    <p>Total Barang : {{$jml}}</p>
	    <p>Keterangan : {{$data->Keterangan}}</p>
	  </div>
	  <div class="column" >
	    <p>Subtotal : {{($data->Subtotal - $data->NilaiPPN)*-1}}</p>
	    <p>PPn : {{$data->NilaiPPN*-1}}</p>
	    <p>Total : {{$data->Subtotal*-1}}</p>
	  </div>
	</div>
	
</body>
</html>