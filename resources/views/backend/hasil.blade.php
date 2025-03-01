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
                <a href="{{route('cetak.hasil')}}" class="btn btn-outline-dark align-items-center" target="_blank">
                    <i class="mdi mdi-printer"></i> Cetak Data
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
        <p data-aos="fade-up" data-aos-duration="4000"> Item-item dengan nilai support yang dimilikinya
            dengan menetapkan minimum support sebesar 2% maka item-item yang memiliki nilai support
            kurang dari 2% dihilangkan.</p>
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
            
            <!-- Tambahkan Pagination -->
            <div class="d-flex justify-content-center">
                {{ $itemsetone->links('pagination::bootstrap-4') }}
            </div>    
        </div>

        <br><br>

        <h4 class="card-title" data-aos="fade-up" data-aos-duration="5000">Daftar produk Calon 2-Itemset</h4>
        <p data-aos="fade-up" data-aos-duration="5000"> Pembentukan pola kombinasi 2-itemset dibentuk dari item-item produk yang memenu
            memenuhi minimum support yaitu dengan cara mengkombinasikan semua item kedalam
            pola kombinasi 2-Itemset kemudian hitung nilai supportnya  </p>
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
        <p data-aos="fade-up" data-aos-duration="6000"> </p>
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
            
            <!-- Tambahkan Pagination -->
            <div class="d-flex justify-content-center">
                {{ $twoItemSetsPaginated->links('pagination::bootstrap-4') }}
            </div>    
        </div>


        <br><br>


        <h4 class="card-title" data-aos="fade-up" data-aos-duration="7000">Hasil Confidence</h4>
        <p data-aos="fade-up" data-aos-duration="7000"> confidence dengan aturan minimum confidence 15%
            ditentukan dari setiap kombinasi item </p>
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
            
            <!-- Tambahkan Pagination -->
            {{-- <div class="d-flex justify-content-center">
                {{ $filteredTwoItemsetWithConfidence->links('pagination::bootstrap-4') }}
            </div> --}}
            
        </div>

        <br><br>


        <h4 class="card-title" data-aos="fade-up" data-aos-duration="8000">Aturan Hasil Memenuhi Minimum Confidence</h4>
        <p data-aos="fade-up" data-aos-duration="8000"> Dengan nilai confidence yang didapat, kemudian dihilangkan nilai confidence yang
            tidak memenuhi ketentuan kurang dari confidence 15% yaitu sebagai berikut: </p>
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
            
            <!-- Tambahkan Pagination -->
            {{-- <div class="d-flex justify-content-center">
                {{ $filteredTwoItemsetWithConfidencemin->links('pagination::bootstrap-4') }}
            </div> --}}
            

        </div>

        <br><br>


        <h4 class="card-title" data-aos="fade-up" data-aos-duration="9000">Aturan Asosiasi yang Terbentuk</h4>
        <p data-aos="fade-up" data-aos-duration="9000"> Pola kombinasi 2-Itemset,
            dengan ketentuan minimum support 2% dan minimum confidence 15% maka aturan
            asosiasi yang terbentuk </p>
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
                    // Ambil nilai support & confidence tertinggi
                    $highestSupport = $sortedRules->max('support');
                    $highestConfidence = $sortedRules->max('confidence');

                    // Ambil aturan yang memiliki support tertinggi
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
                <h5>Berdasarkan Hasil Analisis</h5>
                <p>
                    Produk Skincare dengan nilai <strong>Support</strong> tertinggi sebesar ({{ $highestSupport }}), dari 
                    pasangan produk yang sering dibeli adalah produk **{{ $topSupportRule['pair'] }}**. 
                </p>
                <p>
                    Diikuti dengan nilai <strong>Confidence</strong> tertinggi ({{ $highestConfidence }}) adalah 
                    pasangan **{{ $topConfidenceRule['pair'] }}**. Ini juga menunjukkan bahwa kombinasi ini sering muncul atau paling banyak dibeli berdarakan data transaksi.
                </p>

                <div class="mt-4 p-3 bg-light border rounded">
                    <h5>Berdasarkan aturan asosiasi yang terbentuk dapat disimpulkan bahwa:</h5>
                
                    @foreach($sortedRules as $index => $rule)
                        <p>
                            <strong>{{ $index + 1 }}.</strong> 
                            Pasangan **{{ $rule['pair'] }}** memiliki nilai 
                            <strong>Support</strong> sebesar {{ $rule['support'] }} dan 
                            <strong>Confidence</strong> sebesar {{ $rule['confidence'] }}.
                        </p>
                    @endforeach
                    <br>
                  
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Bootstrap -->
<!-- Modal Bootstrap dengan Ukuran Lebar -->
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
                <h5>Berdasarkan aturan asosiasi yang terbentuk dapat disimpulkan bahwa:</h5>
               
                @foreach($sortedRules as $index => $rule)
                    <p>
                        <strong>{{ $index + 1 }}.</strong> 
                        Pasangan produk "<strong>{{ $rule['pair'] }}</strong>" memiliki nilai 
                        <strong>Support</strong> sebesar {{ $rule['support'] }} dan 
                        <strong>Confidence</strong> sebesar {{ $rule['confidence'] }}.
                    </p>
                @endforeach
                <div class="mt-4 p-3 bg-light border rounded">
                    <p>
                        Dari hasil perhitungan, kombinasi produk skincare di atas merupakan produk yang memenuhi nilai minimum 
                        <strong>support</strong> & <strong>confidence</strong>. Ini menunjukkan bahwa pasangan produk ini sering muncul dalam transaksi pelanggan. 
                        Semakin tinggi nilai support dan confidence, semakin sering kombinasi produk ini ditemukan dalam data transaksi penjualan produk skincare.
                    </p>
                    <p>
                        Hal ini mengindikasikan bahwa produk-produk skincare dalam kombinasi ini memiliki keterkaitan yang kuat dan cenderung dibeli secara bersamaan. 
                        Dengan kata lain, pelanggan yang membeli salah satu produk dalam pasangan ini kemungkinan besar juga membeli produk lainnya.
                    </p>
                    <p>
                        Informasi ini dapat dimanfaatkan untuk meningkatkan strategi pemasaran, seperti dengan menawarkan diskon bundling 
                        atau menampilkan rekomendasi produk yang lebih relevan bagi pelanggan. Selain itu, analisis ini juga berguna untuk 
                        mengoptimalkan stok barang, memastikan ketersediaan produk yang sering dibeli bersamaan, serta meningkatkan pengalaman belanja pelanggan.
                    </p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="mdi mdi-eye"></i> Lihat Detail
                </button>                
            </div>
        </div>
    </div>
</div>

<!-- Script untuk Menampilkan Modal Saat Halaman Dimuat -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var myModal = new bootstrap.Modal(document.getElementById('welcomeModal'));
        myModal.show();
    });
</script>



  @include('komponen.footer')

@endsection