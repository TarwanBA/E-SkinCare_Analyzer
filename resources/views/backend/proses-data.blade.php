@extends('layout.be')

@section('dashboard')

<div class="row">
    <div class="col-sm-12">
      <div class="home-tab">
        <div class="d-sm-flex align-items-center justify-content-between border-bottom">
          <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
              <a class="nav-link active ps-0" id="home-tab" data-bs-toggle="tab" href="#overview" role="tab" aria-controls="overview" aria-selected="true">Proses Data</a>
            </li>
          </ul>
          <div class="d-flex">
            <div class="btn-wrapper">
                <a id="btnAnalyze" class="btn btn-outline-dark align-items-center" data-toggle="modal" data-target="#modalTambah">
                    <span>Analyzer</span> Data
                </a>
            </div>
        </div>            
        </div>
        </div>
      </div>
</div>
<div class="col-lg-12 grid-margin stretch-card mt-3">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Daftar Data Produk</h4>
        <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Produk</th>
                            <th>Nama Produk</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($produk as $data)
                            <tr>
                                <td>{{ $loop->iteration + ($produk->currentPage() - 1) * $produk->perPage() }}</td>
                                <td>{{ $data->kode_produk }}</td>
                                <td>{{ $data->nama_produk }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            
                <!-- Pagination -->
                <div class="d-flex justify-content-center">
                    {{ $produk->links('pagination::bootstrap-4') }}
                </div>            
        </div>
      </div>
    </div>
  </div>

<div class="col-lg-12 grid-margin stretch-card mt-3">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Daftar Data Transaksi</h4>
        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Produk</th>
              </tr>
            </thead>
            <tbody>
                @foreach($datapagi as $data)
                    <tr>
                        <td>{{ $loop->iteration }}</td> 
                        <td>{{ $data->tanggal_transaksi }}</td> 
                        <td>{{ $data->nama_produk }}</td>                        
                    </tr>
                @endforeach
            </tbody>
            
          </table>
            <!-- Pagination -->
            <div class="d-flex justify-content-center">
                {{ $datapagi->links('pagination::bootstrap-4') }}
            </div>   
        </div>
      </div>
    </div>
</div>

<!-- Modal Status Proses -->
<div class="modal fade" id="modalTambah" tabindex="-1" role="dialog" aria-labelledby="modalTambahLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTambahLabel">Proses Analyzer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="progressStatus">Sedang mengolah data, harap tunggu...</div>
                <div class="progress mt-3">
                    <div id="progressBar" class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>
    </div>
</div>


{{-- +++++++++++++++++++++++++++++++ --}}






  @include('komponen.footer')

@endsection