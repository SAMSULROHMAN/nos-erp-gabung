<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="images/favicon.ico" type="image/ico" />

  <title>NOS-ERP</title>

  <!-- Bootstrap -->
  {{-- <link  href="{{ asset('css/datatables.min.css')}}" rel="stylesheet">
  <script src="{{ asset('js/datatables.min.js')}}"></script> --}}
  <!-- jQuery -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
  <!-- Bootstrap -->
  <script src="{{ asset('vendors/bootstrap/dist/js/bootstrap.min.js') }}"></script>
  <link href="{{ asset('vendors/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="{{ asset('vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
  <!-- NProgress -->
  <link href="{{ asset('vendors/nprogress/nprogress.css') }}" rel="stylesheet">
  <!-- iCheck -->
  <link href="{{ asset('vendors/iCheck/skins/flat/green.css') }}" rel="stylesheet">


  <!-- Custom Theme Style -->
  <link href="{{ url('css/custom.min.css') }}" rel="stylesheet">
</head>

<body class="nav-md">
  <div class="container body">
    <div class="main_container">
      <div class="col-md-3 left_col">
        <div class="left_col scroll-view">
          <div class="navbar nav_title" style="border: 0;">
            <a href="{{ url('/') }}'" class="site_title"><i class="fa fa-paw"></i> <span>NOS-ERP</span></a>
          </div>

          <div class="clearfix"></div>

          <!-- menu profile quick info -->
          <div class="profile clearfix">
            <div class="profile_pic">
              <img src="{{ url('img/img.jpg') }}" alt="..." class="img-circle profile_img">
            </div>
            <div class="profile_info">
              <span>Welcome,</span>
              <h2>{{ Auth::user()->name }}</h2>
            </div>
          </div>

          <!-- sidebar menu -->
          <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
              <ul class="nav side-menu">
                <li><a><i class="fa fa-edit"></i> Master <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu">
                    <li><a href="{{ url('/datagudang') }}">Data gudang </a></li>
                    <li><a href="{{ url('/dataitem') }}">Data item</a></li>
                    <li><a href="{{ url('/dataklasifikasi') }}">Data klasifikasi</a></li>
                    <li><a href="{{ url('/datamatauang') }}">Data mata uang</a></li>
                    <li><a href="{{ url('/datapelanggan') }}">Data pelanggan</a></li>
                    <li><a href="{{ url('/datasatuan') }}">Data satuan</a></li>
                    <li><a href="{{ url('/datasupplier') }}">Data supplier</a></li>
                    <li><a href="{{ url('/datakaryawan')}}">Data Karyawan</a></li>
                  </ul>
                </li>
                <li><a><i class="fa fa-edit"></i> Penjualan <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu">
                    <li><a>Pemesanan penjualan<span class="fa fa-chevron-down"></span></a>
                      <ul class="nav child_menu">
                        <li><a href="{{ url('/sopenjualan')}}">S.O Penjualan</a></li>
                        <li><a href="{{ url('/konfirmasipemesananPenjualan') }}">S.O Konfirmasi</a></li>
                        {{-- <li><a href="{{ url('/dikirimpemesananPenjualan') }}">S.O Dikirim</a>
                    </li> --}}
                    <li><a href="{{ url('/batalpemesananPenjualan') }}">S.O Batal</a></li>
                  </ul>
                </li>
                <li><a>Surat jalan<span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu">
                    <li><a href="{{ url('/suratJalan/create/0') }}">Buat Surat Jalan </a></li>
                    <li><a href="{{ url('/suratJalan') }}">Surat Jalan </a></li>
                    <li><a href="{{ url('/konfirmasisuratJalan') }}">Konfirmasi Surat jalan</a></li>
                  </ul>
                </li>
                <li><a>Return Surat jalan<span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu">
                    <li><a href="{{ url('/returnSuratJalan/add/0') }}">Buat Return Surat Jalan </a></li>
                    <li><a href="{{ url('/returnSuratJalan') }}">Return Surat Jalan </a></li>
                    <li><a href="{{ url('/konfirmasireturnSuratJalan') }}">Konfirmasi Surat jalan</a></li>
                  </ul>
                </li>
                <li><a>Penjualan Langsung<span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu">
                    <li><a href="{{ url('/penjualanLangsung') }}">Penjualan Langsung (kasir)</a></li>
                    <li><a href="{{ url('/returnPenjualanLangsung/0') }}">Return Penjualan Langsung</a></li>
                  </ul>
                </li>
                <li><a>Invoice<span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu">
                    <li><a href="{{ url('/invoicepiutang') }}">Invoice Piutang </a></li>
                  </ul>
                </li>
                <li><a>Pelunasan<span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu">
                    <li><a href="{{ url('/pelunasanpiutang') }}">Pelunasan Piutang </a></li>
                  </ul>
                </li>
              </ul>
              </li>

              <li><a><i class="fa fa-shopping-cart"></i> Pembelian<span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                  <li><a>Pemesanan Pembelian<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{ url('/popembelian') }}">P.O Pembelian</a></li>
                      <li><a href="{{ url('/pokonfirmasi') }}">P.O Konfirmasi</a></li>
                      <li><a href="{{ url('/poditerima') }}">P.O Diterima</a></li>
                      <li><a href="{{ url('/pobatal') }}">P.O Batal</a></li>
                    </ul>
                  </li>
                  <li><a>Penerimaan Barang<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{ url('/penerimaanBarang') }}">Penerimaan Barang</a></li>
                      <li><a href="{{ url('/konfirmasiPenerimaanBarang') }}">Penerimaan Konfirmasi</a></li>
                      <li><a href="{{ url('/batalPenerimaanBarang') }}">Penerimaan Batal</a></li>
                    </ul>
                  </li>
                  <li><a>Return Penerimaan<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{ url('/returnPenerimaanBarang') }}">Return Penerimaan Barang</a></li>
                      <li><a href="{{ url('/konfirmasiReturnPenerimaanBarang') }}">Return Penerimaan Konfirmasi</a></li>
                      <li><a href="{{ url('/batalReturnPenerimaanBarang') }}">Return Penerimaan Batal</a></li>
                    </ul>
                  </li>
                  <li><a>Hutang<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{ url('/invoicehutang') }}">Invoice</a></li>
                      <li><a href="{{ url('/pelunasanhutang') }}">Pelunasan</a></li>
                    </ul>
                  </li>
                </ul>
              </li>

              <li><a><i class="fa fa-edit"></i> Stok <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                  <li>
                    <a href="/stokmasuk">Stok Masuk</a>
                  </li>
                  <li>
                    <a href="/kartustok">Kartu Stok</a>
                  </li>
                </ul>
              </li>
              </ul>
            </div>
          </div>
          <!-- /sidebar menu -->

        </div>
      </div>

      <!-- top navigation -->
      <div class="top_nav">
        <div class="nav_menu">
          <nav>
            <div class="nav toggle">
              <a id="menu_toggle"><i class="fa fa-bars"></i></a>
            </div>

            <ul class="nav navbar-nav navbar-right">
              <li class="">
                <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                  <img src="{{ asset('images/img.jpg')}}" alt="">{{ Auth::user()->name }}
                  <span class=" fa fa-angle-down"></span>
                </a>
                <ul class="dropdown-menu dropdown-usermenu pull-right">
                  <li>
                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                      <i class="fa fa-sign-out" aria-hidden="true"></i> Log out
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                      @csrf
                    </form>
                  </li>
                </ul>
              </li>
            </ul>
            </li>
            </ul>
          </nav>
        </div>
      </div>
      <!-- /top navigation -->

      <!-- page content -->

      <div class="right_col">
        @yield('content')
      </div>
      <!-- /page content -->
    </div>
  </div>
  <footer>
    erp-dnz
  </footer>

  <!-- FastClick -->
  <script src="{{ asset('vendors/fastclick/lib/fastclick.js') }}"></script>
  <!-- NProgress -->
  <script src="{{ asset('vendors/nprogress/nprogress.js') }}"></script>
  <!-- Chart.js -->
  <script src="{{ asset('vendors/Chart.js/dist/Chart.min.js') }}"></script>
  <!-- gauge.js -->
  <script src="{{ asset('vendors/gauge.js/dist/gauge.min.js') }}"></script>
  <!-- bootstrap-progressbar -->
  <script src="{{ asset('/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js') }}"></script>
  <!-- iCheck -->
  <script src="{{ asset('vendors/iCheck/icheck.min.js') }}"></script>
  <!-- Skycons -->
  <script src="{{ asset('vendors/skycons/skycons.js') }}"></script>
  <!-- Flot -->
  <script src="{{ asset('vendors/Flot/jquery.flot.js') }}"></script>
  <script src="{{ asset('vendors/Flot/jquery.flot.pie.js') }}"></script>
  <script src="{{ asset('vendors/Flot/jquery.flot.time.js') }}"></script>
  <script src="{{ asset('/vendors/Flot/jquery.flot.stack.js') }}"></script>
  <script src="{{ asset('vendors/Flot/jquery.flot.resize.js') }}"></script>
  <!-- Flot plugins -->
  <script src="{{ asset('vendors/flot.orderbars/js/jquery.flot.orderBars.js') }}"></script>
  <script src="{{ asset('vendors/flot-spline/js/jquery.flot.spline.min.js') }}"></script>
  <script src="{{ asset('/vendors/flot.curvedlines/curvedLines.js') }}"></script>
  <!-- DateJS -->
  <script src="{{ asset('/vendors/DateJS/build/date.js') }}"></script>
  <!-- JQVMap -->
  <script src="{{ asset('/vendors/jqvmap/dist/jquery.vmap.js') }}"></script>
  <script src="{{ asset('/vendors/jqvmap/dist/maps/jquery.vmap.world.js') }}"></script>
  <script src="{{ asset('/vendors/jqvmap/examples/js/jquery.vmap.sampledata.js' ) }}"></script>
  <!-- bootstrap-daterangepicker -->
  <script src="{{ asset('/vendors/moment/min/moment.min.js' ) }}"></script>
  <script src="{{ asset('/vendors/bootstrap-daterangepicker/daterangepicker.js') }}"></script>

  <!-- Custom Theme Scripts -->
  <script src="{{ url('js/custom.min.js') }}"></script>
  @yield('scripts')
</body>

</html>