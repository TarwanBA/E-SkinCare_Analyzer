<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Hasil Analisis Produk SkinCare</title>
    <link rel="icon" href="{{ asset('assets/images/logo-Umi.ico') }}" />
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .header { text-align: left; margin-bottom: 10px; }
        .header img { width: 80px; height: auto; }
        .header h2, .header h4 { margin: 3px 0; }
        
        .line { border-bottom: 2px solid black; margin-bottom: 10px; }

        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table, th, td { border: 1px solid black; padding: 6px; text-align: left; }
        th { background-color: #f2f2f2; font-size: 12px; }
        td { font-size: 11px; }

        .table-title {
            font-size: 14px;
            font-weight: bold;
            text-align: left;
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Ternate Kosmetik</h2>
        <h4>Jln. Raya Jati Depan Toko Dua Sekawan Kel. Jati </h4>
        <h4>Ternate Selatan, Kota Ternate Maluku Utara</h4>
    </div>
    <div class="line"></div>

    <h3 style="text-align: center; margin-bottom: 5px;">Laporan Hasil Analisis Data</h3>
    <h4 style="text-align: center; margin-top: 2px;">Produk Skincare - Ternate Kosmetik</h4>
    
    <div class="table-title">Daftar produk Calon Itemset</div>
    <table>
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

    <div class="line"></div>

    <div class="table-title">Hasil 1-Itemset memenuhi minimum support {{$FpSupport}}%</div>
    <p data-aos="fade-up" data-aos-duration="4000"> Berikut item-item dengan nilai minimum support sebesar {{$FpSupport}}%, selebihnya item-item yang memiliki nilai support
        kurang dari {{$FpSupport}}% otomatis dihilangkan sehingga menghasilkan data hasil 1 itemset sebagai berikut:</p>
    <table>
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

        <div class="line"></div>

    <div class="table-title">Daftar produk Calon 2-Itemset</div>
    <p data-aos="fade-up" data-aos-duration="5000"> Berikut daftar pembentukan pola kombinasi 2-itemset dibentuk dari item-item produk yang telah memenuhi minimum support pada hasil 1 itemset.</p>
    <table>
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

        <div class="line"></div>

    <div class="table-title">Hasil 2-Itemset Memenuhi Minimum Support {{$FpSupport}}%</div>
    <p data-aos="fade-up" data-aos-duration="6000">Berikut item-item dengan nilai minimum support sebesar {{$FpSupport}}%, selebihnya item-item yang memiliki nilai support
        kurang dari {{$FpSupport}}% otomatis dihilangkan sehingga menghasilkan data hasil pola kombinasi 2 itemset sebagai berikut:</p>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Produk</th>
                <th>Frekuensi</th>
                <th>Support</th>
            </tr>
            <thead>
                <tbody>
            @php $no = 1; @endphp
            @foreach($twoItemSetsPaginated as $item => $set)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $item }}</td>
                <td>{{ $set['count'] }}</td>
                <td>{{ $set['support'] }}</td>
            </tr>
            @endforeach
        </tbody>
        </table>

        <div class="line"></div>

        <div class="table-title">Hasil Confidence</div>
        <p style="text-align: justify">
            Confidence menggambarkan seberapa besar kemungkinan suatu item muncul jika item lain sudah ada dalam transaksi. 
            Jika sebelumnya terdapat 1-itemset, confidence dihitung berdasarkan hubungan satu item dengan item lain, 
            sedangkan dengan 2-itemset, confidence mempertimbangkan kombinasi dua item sebelumnya. 
            Nilai confidence yang tinggi menunjukkan bahwa item dalam konsekuen sangat mungkin terjadi jika antecedent sudah ada, 
            Beriktu merupakan hasil Confidance yg didapatkan. </p>
        <table>
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

            <div class="line"></div>

        <div class="table-title">Aturan Hasil Memenuhi Minimum Confidence {{$FpConfidance}}%</div>
        <p style="text-align: justify"> Dengan nilai confidence yang didapat, kemudian dihilangkan nilai confidence yang
            tidak memenuhi ketentuan kurang dari confidence {{$FpConfidance}}% yaitu sebagai berikut: </p>
        <table>
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
            
            <div class="line"></div>

            <div class="table-title">Aturan Asosiasi yang Terbentuk</div>
            <p style="text-align: justify"> Pola kombinasi 2-Itemset,
                dengan ketentuan minimum support {{$FpSupport}}% dan minimum confidence {{$FpConfidance}}% maka aturan
                asosiasi yang terbentuk sebagai berikut:  </p>
            <table>
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
                        <h3 class="mb-3"><strong>Berdasarkan aturan asosiasi yang terbentuk, dapat disimpulkan bahwa:</strong></h3>                      
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
                    
                    <p style="text-align: justify;">
                        Ini juga menunjukkan bahwa kombinasi produk ini sering muncul dalam transaksi dan memiliki keterkaitan yang kuat. Dengan nilai <strong>support</strong> dan <strong>confidence</strong> yang tinggi, produk-produk ini cenderung dibeli bersamaan, sehingga dapat dijadikan rekomendasi untuk strategi pemasaran, promosi bundling, atau penataan produk yang lebih efektif.
                    </p>
    
                   
                </div>
</body>
</html>
