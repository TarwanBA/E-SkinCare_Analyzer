@extends('layout.be')

@section('dashboard')


<div class="row">
    <div class="col-sm-12">
      <div class="home-tab">
        <div class="d-sm-flex align-items-center justify-content-between border-bottom">
          <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
              <a class="nav-link active ps-0" id="home-tab" data-bs-toggle="tab" href="#overview" role="tab" aria-controls="overview" aria-selected="true">Hasil Analyzer Data</a>
            </li>
          </ul>
          <div class="d-flex">
            <div class="btn-wrapper">
                <a href="{{ route('cetakpdf.hasil') }}" class="btn btn-outline-dark align-items-center" target="_blank">
                    <i class="mdi mdi-file-pdf-box"></i> Cetak PDF
                </a>
                <a href="{{ route('exportExcel.hasil') }}" class="btn btn-outline-dark align-items-center" target="_blank">
                    <i class="mdi mdi-file-excel-box"></i> Cetak Excel
                </a>
                
            </div>
        </div>            
        </div>
        </div>
      </div>
</div>


<div class="col-lg-12 grid-margin stretch-card mt-3" data-aos="fade-up" data-aos-duration="3000">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title" data-aos="fade-up" data-aos-duration="3000">Daftar produk Calon Itemset</h4>
        <div class="table-responsive"data-aos="fade-up" data-aos-duration="3000">
          <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Produk</th>
                    <th>Frekuensi</th>
                    <th>Support</th>
                </tr>
                @php $no = 1; @endphp
                @foreach($calonitemset as $item => $data)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $item }}</td>
                    <td>{{ $data['count'] }}</td>
                    <td>{{ $data['support'] }}</td>
                </tr>
                @endforeach
            </table>
            
            <!-- Tambahkan Pagination -->
            <div class="d-flex justify-content-center">
                {{ $calonitemset->links('pagination::bootstrap-4') }}
            </div>    
        </div>

        <br><br>


        <h4 class="card-title" data-aos="fade-up" data-aos-duration="4000">Hasil 1-Itemset memenuhi minimum support</h4>
        <p data-aos="fade-up" data-aos-duration="4000"> Berikut item-item dengan nilai minimum support sebesar {{$FpSupport}}%, selebihnya item-item yang memiliki nilai support
            kurang dari {{$FpSupport}}% otomatis dihilangkan sehingga menghasilkan data hasil 1 itemset sebagai berikut:</p>
        <div class="table-responsive" data-aos="fade-up" data-aos-duration="4000">
          <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Produk</th>
                    <th>Frekuensi</th>
                    <th>Support</th>
                </tr>
                @php $no = 1; @endphp
                @foreach($itemsetone as $item => $set)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $item }}</td>
                    <td>{{ $set['count'] }}</td>
                    <td>{{ $set['support'] }}</td>
                </tr>
                @endforeach
            </table>
        </div>

        <br><br>

        <h4 class="card-title" data-aos="fade-up" data-aos-duration="5000">Daftar produk Calon 2-Itemset</h4>
        <p data-aos="fade-up" data-aos-duration="5000"> Berikut daftar pembentukan pola kombinasi 2-itemset dibentuk dari item-item produk yang telah memenuhi minimum support pada hasil 1 itemset.</p>
        <div class="table-responsive" data-aos="fade-up" data-aos-duration="5000">
          <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Produk</th>
                    <th>Frekuensi</th>
                    <th>Support</th>
                </tr>
                @php $no = 1; @endphp
                @foreach($itemsettwo as $item => $set)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $item }}</td>
                    <td>{{ $set['count'] }}</td>
                    <td>{{ $set['support'] }}</td>
                </tr>
                @endforeach
            </table>
            
            <!-- Tambahkan Pagination -->
            <div class="d-flex justify-content-center">
                {{ $itemsettwo->links('pagination::bootstrap-4') }}
            </div>    
        </div>

        <br><br>


        <h4 class="card-title" data-aos="fade-up" data-aos-duration="6000">Hasil 2-Itemset Memenuhi Minimum Support</h4>
        <p data-aos="fade-up" data-aos-duration="6000">Berikut item-item dengan nilai minimum support sebesar {{$FpSupport}}%, selebihnya item-item yang memiliki nilai support
            kurang dari {{$FpSupport}}% otomatis dihilangkan sehingga menghasilkan data hasil pola kombinasi 2 itemset sebagai berikut:</p>
        <div class="table-responsive" data-aos="fade-up" data-aos-duration="6000">
          <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Produk</th>
                    <th>Frekuensi</th>
                    <th>Support</th>
                </tr>
                @php $no = 1; @endphp
                @foreach($twoItemSetsPaginated as $item => $set)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $item }}</td>
                    <td>{{ $set['count'] }}</td>
                    <td>{{ $set['support'] }}</td>
                </tr>
                @endforeach
            </table>
        </div>


        <br><br>


        <h4 class="card-title" data-aos="fade-up" data-aos-duration="7000">Hasil Confidence</h4>
        <p data-aos="fade-up" data-aos-duration="7000" style="text-align: justify">
            Confidence menggambarkan seberapa besar kemungkinan suatu item muncul jika item lain sudah ada dalam transaksi. 
            Jika sebelumnya terdapat 1-itemset, confidence dihitung berdasarkan hubungan satu item dengan item lain, 
            sedangkan dengan 2-itemset, confidence mempertimbangkan kombinasi dua item sebelumnya. 
            Nilai confidence yang tinggi menunjukkan bahwa item dalam konsekuen sangat mungkin terjadi jika antecedent sudah ada, 
            Beriktu merupakan hasil Confidance yg didapatkan. </p>
        <div class="table-responsive" data-aos="fade-up" data-aos-duration="7000">
          <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Pola 2-Itemset</th>
                    <th>Frekuensi A</th>
                    <th>Frekuensi A & B</th>
                    <th>Nilai Confidence</th>
                </tr>
            </thead>
            <tbody>
                @php $no = 1; @endphp
                @foreach($filteredTwoItemsetWithConfidence as $pair => $set)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $pair }}</td>
                     <td>{{ $set['frekuensi_A'] }}</td>
                    <td>{{ $set['frekuensi_A_&_B'] }}</td> 
                    <td>{{ $set['confidenceAB'] }}</td> 
                </tr>
                @endforeach
            </tbody>
            </table>            
        </div>

        <br><br> 
        <h4 class="card-title" data-aos="fade-up" data-aos-duration="8000">Aturan Hasil Memenuhi Minimum Confidence {{$FpConfidance}}% </h4>
        <p style="text-align: justify"> Dengan nilai confidence yang didapat, kemudian dihilangkan nilai confidence yang
            tidak memenuhi ketentuan kurang dari confidence {{$FpConfidance}}% yaitu sebagai berikut: </p>
        <div class="table-responsive" data-aos="fade-up" data-aos-duration="8000">
          <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Pola 2-Itemset</th>
                    <th>Frekuensi A</th>
                    <th>Frekuensi A & B</th>
                    <th>Nilai Confidence</th>
                </tr>
            </thead>
            <tbody>
                @php $no = 1; @endphp
                @foreach($filteredTwoItemsetWithConfidencemin as $pair => $set)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $pair }}</td>
                    <td>{{ $set['frekuensi_A'] }}</td>  
                    <td>{{ $set['frekuensi_A_&_B'] }}</td> 
                    <td>{{ $set['confidenceAB'] }}</td> 
                </tr>
                @endforeach
            </tbody>
            </table>           
        </div>

        <br><br>


        <h4 class="card-title" data-aos="fade-up" data-aos-duration="9000">Aturan Asosiasi yang Terbentuk</h4>
        <p data-aos="fade-up" data-aos-duration="9000"> Pola kombinasi 2-Itemset,
            dengan ketentuan minimum support {{$FpSupport}}% dan minimum confidence {{$FpConfidance}}% maka aturan
            asosiasi yang terbentuk sebagai berikut: </p>
        <div class="table-responsive" data-aos="fade-up" data-aos-duration="9000">
          <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Item</th>
                    <th>Aturan</th>
                    <th>Support</th>
                    <th>Confidence</th>
                </tr>
            </thead>
            <tbody>
                @php 
                    $no = 1; 
                    $sortedRules = collect($associationRules)->sortByDesc('support')->values();

                    $highestSupport = $sortedRules->max('support');
                    $highestConfidence = $sortedRules->max('confidence');

                    $topSupportRule = $sortedRules->firstWhere('support', $highestSupport);
                    $topConfidenceRule = $sortedRules->firstWhere('confidence', $highestConfidence);
                @endphp
                @foreach($sortedRules as $rule)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $rule['pair'] }}</td>
                        <td>{{ $rule['pair'] }}</td> 
                        <td>{{ $rule['support'] }}</td>
                        <td>{{ $rule['confidence'] }}</td>
                    </tr>
                @endforeach
            </tbody>
            </table>
            <div class="mt-4 p-3 bg-light border rounded">
                <div class="mt p-3 bg-light border rounded" style="text-align: justify; line-height: 1.6;">  
                    <h5 class="mb-3"><strong>Berdasarkan aturan asosiasi yang terbentuk, dapat disimpulkan bahwa:</strong></h5>                      
                    <ol class="ps-3">
                        @foreach($sortedRules as $index => $rule)
                            @php
                                $data_item = explode(', ', $rule['pair']);
                            @endphp
                
                            <li class="mb-3">
                                Pasangan produk <strong>{{ $rule['pair'] }}</strong> memiliki nilai 
                                <strong>Support</strong> sebesar {{ $rule['support'] }} dan 
                                <strong>Confidence</strong> sebesar {{ $rule['confidence'] }}.
                                <br>
                                Jika pelanggan membeli <strong>{{ $data_item[0] }}</strong>, maka pelanggan juga akan membeli 
                                <strong>{{ $data_item[1] }}</strong>.
                            </li>
                        @endforeach
                    </ol>
                </div>
                <br>
                <p style="text-align: justify;">
                    Ini juga menunjukkan bahwa kombinasi produk ini sering muncul dalam transaksi dan memiliki keterkaitan yang kuat. Dengan nilai <strong>support</strong> dan <strong>confidence</strong> yang tinggi, produk-produk ini cenderung dibeli bersamaan, sehingga dapat dijadikan rekomendasi untuk strategi pemasaran, promosi bundling, atau penataan produk yang lebih efektif.
                </p>

               
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="welcomeModal" tabindex="-1" role="dialog" aria-labelledby="welcomeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document"> <!-- Gunakan modal-lg untuk ukuran besar -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="welcomeModalLabel">Hasil Analisis Produk SkinCare</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span> <!-- Tombol X -->
                </button>
            </div>
            <div class="modal-body">
                <div class="mt p-3 bg-light border rounded" style="text-align: justify; line-height: 1.6;">  
                    <h5 class="mb-3"><strong>Berdasarkan aturan asosiasi yang terbentuk, dapat disimpulkan bahwa:</strong></h5>                      
                    <ol class="ps-3">
                        @foreach($sortedRules as $index => $rule)
                            @php
                                $data_item = explode(', ', $rule['pair']);
                            @endphp
                
                            <li class="mb-3">
                                Pasangan produk <strong>{{ $rule['pair'] }}</strong> memiliki nilai 
                                <strong>Support</strong> sebesar {{ $rule['support'] }} dan 
                                <strong>Confidence</strong> sebesar {{ $rule['confidence'] }}.
                                <br>
                                Jika pelanggan membeli <strong>{{ $data_item[0] }}</strong>, maka pelanggan juga akan membeli 
                                <strong>{{ $data_item[1] }}</strong>.
                            </li>
                        @endforeach
                    </ol>
                </div>
                <br>
                <p style="text-align: justify;">
                    Ini juga menunjukkan bahwa kombinasi produk ini sering muncul dalam transaksi dan memiliki keterkaitan yang kuat. Dengan nilai <strong>support</strong> dan <strong>confidence</strong> yang tinggi, produk-produk ini cenderung dibeli bersamaan, sehingga dapat dijadikan rekomendasi untuk strategi pemasaran, promosi bundling, atau penataan produk yang lebih efektif.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="mdi mdi-eye"></i> Lihat Detail
                </button>                
            </div>
        </div>
    </div>
</div>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        var myModal = new bootstrap.Modal(document.getElementById('welcomeModal'));
        myModal.show();
    });
</script>



  @include('komponen.footer')

@endsection