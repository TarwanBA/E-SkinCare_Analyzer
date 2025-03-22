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
                
              </div>
              <div class="btn-wrapper">
                 
              </div>
          </div>
          
          </div>
        </div>
      </div>
  </div>

<div class="col-lg-12 grid-margin stretch-card mt-3">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Pengaturan Nilai Support & Confidance</h4>
        <div class="table-responsive">
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
        </div>
      </div>
    </div>
  </div>
  <p style="text-align: justify;">
    Dengan mengatur nilai minimum support dan confidence dalam analisis aturan asosiasi menggunakan metode FP-Growth. Minimum support menentukan seberapa sering suatu kombinasi produk muncul dalam transaksi agar dianggap sebagai aturan yang valid, sementara minimum confidence mengukur seberapa kuat hubungan antara produk dalam aturan tersebut. Jika nilai support tinggi, hanya kombinasi produk yang sering muncul yang dianalisis, sedangkan nilai rendah memungkinkan lebih banyak pola ditemukan. Begitu juga dengan confidence, nilai tinggi memastikan hanya aturan dengan hubungan kuat yang dipertahankan, sementara nilai rendah bisa menghasilkan lebih banyak aturan, termasuk yang hubungannya lemah. 
    <br>
    <br>
    Misalnya, jika minimum support ditetapkan {{ $support }}%, hanya kombinasi produk yang muncul di minimal {{ $support }}% dari total transaksi yang akan diproses, dan jika minimum confidence {{ $confidence }}%, hanya aturan dengan tingkat confidance minimal {{ $confidence }}% yang dianggap relevan. Pengaturan ini sangat penting untuk menyaring aturan yang tidak signifikan dan memastikan hasil analisis yang lebih akurat, sehingga dapat digunakan secara efektif dalam strategi pemasaran dan rekomendasi produk.
  </p>

  @include('komponen.footer')


 
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
                        <input type="number" class="form-control" name="confidance" value="{{ $data->confidance }}" required>
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