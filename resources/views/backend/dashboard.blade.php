@extends('layout.be')

@section('dashboard')

      <div class="row " data-aos="zoom-in" data-aos-duration="5500">
        <div class="col-sm-12">
          <div class="home-tab">
            <div class="tab-content tab-content-basic">
              <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview">
                <div class="row">
                  <div class="col-lg-12 d-flex flex-column">
                    <div class="row flex-grow">
                      <div class="col-12 grid-margin stretch-card">
                        <div class="card card-rounded table-darkBGImg">
                          <div class="card-body">
                            <div class="col-sm-8">
                              <h3 class="text-white upgrade-info mb-0"> Aplikasi Analyzer Produk Skincare </h3>
                              <p class="text-white">ANALISIS MINAT PELANGGAN TERHADAP PRODUK SKINCARE
                                MENGGUNAKAN ALGORITMA FP-GROWTH (STUDI KASUS: TERNATE
                                KOSMETIK)</p>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row" data-aos="zoom-in" data-aos-duration="1500">
        <div class="col-sm-12">
          <div class="statistics-details d-flex align-items-center justify-content-left" style="gap: 50px;">
            <!-- Data Produk dengan Icon Skincare -->
            <div class="text-center">
                <i class="mdi mdi-face-woman-outline" style="font-size: 40px; color: #f39c12;"></i>
                <p class="statistics-title">Data Produk</p>
                <h3 class="rate-percentage">{{ $data_produk }}</h3>
            </div>
        
            <!-- Data Transaksi dengan Icon Transaksi -->
            <div class="text-center">
                <i class="mdi mdi-cash-multiple" style="font-size: 40px; color: #28a745;"></i>
                <p class="statistics-title">Data Transaksi</p>
                <h3 class="rate-percentage">{{ $data_transaksi }}</h3>
            </div>
        </div>
        
        </div>
      </div>
<div class="mt-5">
  @include('komponen.footer')

</div>

@endsection