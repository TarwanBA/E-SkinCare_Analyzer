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
                @php $no = 1; @endphp
                @foreach($associationRules as $rule)
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
            
            <!-- Tambahkan Pagination -->
            {{-- <div class="d-flex justify-content-center">
                {{ $associationRules->links('pagination::bootstrap-4') }}
            </div> --}}

        </div>
    </div>
</div>

  @include('komponen.footer')

@endsection