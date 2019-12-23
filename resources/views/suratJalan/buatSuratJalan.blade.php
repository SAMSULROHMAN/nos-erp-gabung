@extends('index')
@section('content')
  <style type="text/css">
    form {
      margin: 20px 0;
    }

    form input, button {
      padding: 5px;
    }

    table {
      width: 100%;
      margin-bottom: 20px;
      border-collapse: collapse;
    }

    table, th, td {
      border: 1px solid #cdcdcd;
    }

    table th, table td {
      padding: 10px;
      text-align: left;
    }
  </style>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="x_panel">
          <div class="x_title">
            <h1>Surat Jalan</h1>
          </div>
          <div class="x_content">


            <div class="form-row">
              <div class="form-group col-md-4">
                <div class="form-group">
                  <label for="">Nama Pelanggan</label>
                  <select name="custId" class="form-control" id="custId">
                    <option value="0">Pilih Pelanggan</option>
                    @foreach($customers as $customer)
                      <option value="{{$customer->KodePelanggan}}">{{$customer->NamaPelanggan}}</option>
                    @endforeach
                  </select>
                  <div class="so-select-container">
                  </div>
                </div>
              </div>

            </div>
            <div class="so-detail-container">
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
  <script type="text/javascript">
      $('#custId').on('change', function () {
          var nameId = $('#custId option:selected').attr('value');
          if (nameId == 0) {
              $('.so-select-container').html('')
          } else {
              var my_url = '/suratJalan/searchsobycustid/' + nameId;
              $.get(my_url, function (datas, status) {
                  var html = '';
                  if ($.isEmptyObject(datas)) {
                      html = '<label for="">Tidak Ada SO untuk Pelanggan {{$customer->NamaPelanggan}}</label>';
                  } else {
                      $('.so-select-empty').removeClass('hidden');
                      var options = ''
                      $.each(datas, function (i, val) {
                          options = options + '<option value="' + val + '">' + val + '</option>'
                      });
                      html = '<label for="">Kode So</label>' +
                          '<select name="soId" class="form-control" id="soId">' +
                          '<option  selected="selected" value="0">Pilih kode So</option>' +
                          options
                          +
                          '</select>';
                  }
                  $('.so-select-container').html(html)
              });
          }
      });
      $('body').on('change', '#soId', function () {
          var soId = $('#soId option:selected').attr('value');
          if (soId == 0) {
              $('.so-detail-container').html('')
          } else {
              var my_url = '/suratJalan/createbasedso/' + soId;
              $.get(my_url, function (datas, status) {
                  $('.so-detail-container').html(datas)
              });
          }

      });

      function refresh(val) {
          var base = "{{ url('/') }}" + "/suratJalan/create/" + val.value;
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
          }
          $(".ppnval").val(ppn);
          $(".diskonval").val(diskon);
          $(".befDis").val(parseInt($(".subtotal").val()));
          $(".subtotal").val(parseInt($(".subtotal").val()) + ppn);
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

      $('.formsub').submit(function (event) {
          tot = $(".tot").val();
          for (var i = 1; i <= tot; i++) {
              if (typeof $(".qty" + i).val() === 'undefined') {
              } else {
                  if ($(".qty" + i).val() == 0) {
                      event.preventDefault();
                      $(".qty" + i).focus();
                  }
              }

          }

      });
  </script>
@endsection
