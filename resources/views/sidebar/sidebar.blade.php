<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    <div class="menu_section">
        <ul class="nav side-menu">
            <li><a><i class="fa fa-database"></i> Master <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="{{ url('/datagudang') }}">Data gudang </a></li>
                    <li><a href="{{ url('/dataklasifikasi') }}">Data klasifikasi</a></li>
                    <li><a href="{{ url('/datasatuan') }}">Data satuan</a></li>
                    <li><a href="{{ url('/dataitem') }}">Data item</a></li>
                    <li><a href="{{ url('/datapelanggan') }}">Data pelanggan</a></li>
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
            {{-- <li><a>Penjualan Langsung<span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                <li><a href="{{ url('/penjualanLangsung') }}">Penjualan Langsung (kasir)</a></li>
            <li><a href="{{ url('/returnPenjualanLangsung') }}">Return Penjualan Langsung</a></li>
        </ul>
        </li> --}}
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

        <li><a><i class="fa fa-bar-chart"></i>Laporan<span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
                {{-- <li>
                    <a href="/stokmasuk">Stok Masuk</a>
                </li> --}}
                <li>
                    <a href="{{ url('/kartustok')}}">Kartu Stok</a>
                </li>
            </ul>
        </li>
        </ul>
    </div>
</div>
