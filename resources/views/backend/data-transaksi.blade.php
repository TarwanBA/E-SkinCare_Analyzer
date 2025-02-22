@extends('layout.be')

@section('dashboard')

<div class="row">
    <div class="col-sm-12">
      <div class="home-tab">
        <div class="d-sm-flex align-items-center justify-content-between border-bottom">
          <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
              <a class="nav-link active ps-0" id="home-tab" data-bs-toggle="tab" href="#overview" role="tab" aria-controls="overview" aria-selected="true">Data Transaksi</a>
            </li>
          </ul>
          <div class="d-flex">
            <div class="btn-wrapper mr-2">
                <a href="{{route('data-transaksi.cetak')}}" class="btn btn-outline-dark align-items-center" target="_blank">
                    <i class="mdi mdi-printer"></i> Cetak Data
                </a>
            </div>
            <div class="btn-wrapper mr-2">
                <a class="btn btn-outline-dark align-items-center" data-toggle="modal" data-target="#modalUpload">
                    <i class="mdi mdi-upload"></i> Upload Data
                </a>
            </div>
            <div class="btn-wrapper">
                <a class="btn btn-outline-dark align-items-center" data-toggle="modal" data-target="#modalTambah">
                    <i class="mdi mdi-plus"></i> Tambah Data
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
        <h4 class="card-title">Daftar Data Transaksi</h4>
        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Produk</th>
                <th style="text-align: center;">Aksi</th>

              </tr>
            </thead>
            <tbody>
                @foreach($datapagi as $data)
                    <tr>
                        <td>{{ $loop->iteration }}</td> 
                        <td>{{ $data->tanggal_transaksi }}</td> 
                        <td>{{ $data->nama_produk }}</td>

                        <td>
                            <button type="button" class="badge badge-warning border-0" data-toggle="modal" data-target="#modalEdit{{ $data->id }}">
                                <i class="mdi mdi-pencil"></i> 
                            </button>
                        
                            <form action="{{ route('data-transaksi.destroy', $data->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="badge badge-danger border-0" onclick="return confirm('Apakah Anda yakin ingin menghapus transaksi ini?')">
                                    <i class="mdi mdi-trash-can"></i> 
                                </button>
                            </form>
                        </td>
                        
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

  @include('komponen.footer')


<!-- Modal Upload Data -->
<div class="modal fade" id="modalUpload" tabindex="-1" role="dialog" aria-labelledby="modalUploadLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalUploadLabel">Tambah Data Transaksi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <form action="{{ route('data-transaksi.upload') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="file">Upload File Excel</label>
                        <input type="file" name="file" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Tambah Data -->
<div class="modal fade" id="modalTambah" tabindex="-1" role="dialog" aria-labelledby="modalTambahLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTambahLabel">Tambah Data Transaksi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('data-transaksi.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="tanggal_transaksi">Tanggal Transaksi</label>
                        <input type="date" class="form-control" name="tanggal_transaksi" required>
                    </div>
                    <div class="form-group">
                        <label for="nama_produk">Produk Skincare</label>
                        <input type="text" class="form-control" name="nama_produk" placeholder="Masukkan nama produk" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>


 
<!-- Modal Edit Data -->
@foreach ($datatransaksi as $data)
<div class="modal fade" id="modalEdit{{ $data->id }}" tabindex="-1" role="dialog" aria-labelledby="modalEditLabel{{ $data->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditLabel{{ $data->id }}">Edit Data Transaksi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('data-transaksi.update', $data->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="tanggal_transaksi">Tanggal Transaksi</label>
                        <input type="date" class="form-control" name="tanggal_transaksi" value="{{ $data->tanggal_transaksi }}" required>
                    </div>
                    <div class="form-group">
                        <label for="nama_produk">Produk Skincare</label>
                        <input type="text" class="form-control" name="nama_produk" value="{{ $data->nama_produk }}" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach


@endsection