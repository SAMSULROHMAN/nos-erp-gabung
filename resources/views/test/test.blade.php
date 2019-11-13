<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Format Rupiah</title>
  </head>
  <style type="text/css">
    	body {
    		font-family: sans-serif;
    	}
    	.kotak {
    		width: 350px;
    		margin: auto;
    		margin-top: 15px;
    		padding: 10px;
    	}

    	p{
    		margin-bottom: 20px;
    		color: #0004ff;
    	}

    	input {
    		text-align: right;
    		width: 100%;
    		margin-bottom: 20px;
    		margin-top: 10px;
    		padding: 7px 10px;
    		font-size: 18px;
    	}
	</style>
  <body>
    <div class="kotak">
  		<p>Ketik jumlah nominal pada form di bawah ini.</p>
  		<span>Nominal Rupiah. :</span>
  		<input type="text" id="rupiah"/>
  	</div>
    <script type="text/javascript">
        const rupiah = document.getElementById('rupiah');
        rupiah.addEventListener('keyup',function(e){
          rupiah.value = formatRupiah(this.value,'Rp. ');
        });

        function formatRupiah(angka,prefix){
          let number_string = angka.replace(/[^,\d]/g,'').toString(),
          split   		      = number_string.split(','),
    			sisa     		      = split[0].length % 3,
    			rupiah     		    = split[0].substr(0, sisa),
    			ribuan     		    = split[0].substr(sisa).match(/\d{3}/gi);

          if(ribuan){
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
          }

          rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
			    return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
        }

    </script>
  </body>
</html>
