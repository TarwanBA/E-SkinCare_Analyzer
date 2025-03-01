@extends('layout.be')

@section('dashboard')

<div class="row">
    <div class="col-sm-12">
        <div class="home-tab">
          <div class="d-sm-flex align-items-center justify-content-between border-bottom">
            <ul class="nav nav-tabs" role="tablist">
              <li class="nav-item">
                <a class="nav-link active ps-0" id="home-tab" data-bs-toggle="tab" href="#overview" role="tab" aria-controls="overview" aria-selected="true">Fp-Growth</a>
              </li>
            </ul>
            <div class="d-flex">
              <div class="btn-wrapper mr-2">
                  {{-- <a href="{{route('data-produk.cetak')}}" class="btn btn-outline-dark align-items-center" target="_blank">
                      <i class="mdi mdi-printer"></i> Cetak Data
                  </a> --}}
              </div>
              <div class="btn-wrapper">
                  {{-- <a class="btn btn-outline-dark align-items-center" data-toggle="modal" data-target="#modalTambah">
                      <i class="mdi mdi-plus"></i> Tambah Data
                  </a> --}}
              </div>
          </div>
          
          </div>
        </div>
      </div>
  </div>
<div class="col-lg-12 grid-margin stretch-card mt-3">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Data Nilai Support & Confidance</h4>
        <div class="table-responsive">
                <!-- Form Pencarian -->
                <!-- Form Pencarian -->
              
                <!-- Tabel Produk -->
                <table class="table">
                    <thead>
                        <tr>
                            <th style="text-align: center;">No</th>
                            <th style="text-align: center;">Nilai Min Support</th>
                            <th style="text-align: center;">Nilai Min Confidance</th>
                            <th style="text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($fp as $data)
                            <tr>
                                <td style="text-align: center;">{{ $loop->iteration }}</td>
                                <td style="text-align: center;">{{ $data->support }} %</td>
                                <td style="text-align: center;">{{ $data->confidance }} %</td>
                                <td style="text-align: center;">
                                    <button type="button" class="badge badge-warning border-0" data-toggle="modal" data-target="#modalEdit{{ $data->id }}">
                                        <i class="mdi mdi-pencil"></i> 
                                    </button>
            
                                    <form action="{{ route('data-produk.destroy', $data->id) }}" method="POST" style="display:inline;">
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
                {{-- <div class="d-flex justify-content-center">
                    {{ $produk->links('pagination::bootstrap-4') }}
                </div>             --}}
        </div>
      </div>
    </div>
  </div>

  @include('komponen.footer')


<!-- Modal Tambah Data -->
{{-- <div class="modal fade" id="modalTambah" tabindex="-1" role="dialog" aria-labelledby="modalTambahLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTambahLabel">Tambah Data Produk Skincare</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('data-produk.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="kode_produk">Kode Produk</label>
                        <input type="text" class="form-control" name="kode_produk" required>
                    </div>
                    <div class="form-group">
                        <label for="nama_produk">Nama Produk</label>
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
</div> --}}


 
<!-- Modal Edit Data -->
@foreach ($fp as $data)
<div class="modal fade" id="modalEdit{{ $data->id }}" tabindex="-1" role="dialog" aria-labelledby="modalEditLabel{{ $data->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditLabel{{ $data->id }}">Edit Nilai Support & Confidance</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('fp.update', $data->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="support">Nilai Min Support</label>
                        <input type="number" class="form-control" name="support" value="{{ $data->support }}" required>
                    </div>
                    <div class="form-group">
                        <label for="confidance">Nilai Min Confidance</label>
                        <input type="text" class="form-control" name="confidance" value="{{ $data->confidance }}" required>
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