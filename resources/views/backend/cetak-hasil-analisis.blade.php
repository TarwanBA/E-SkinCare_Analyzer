<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Hasil Analisis</title>
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

        /* Title table */
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
        <h2>E-Skincare_Analyzer</h2>
        <h4>Jl. Jati Metro No. 123, Ternate Tengah, Indonesia</h4>
        <h4>Email: umi@unkhair.ac.id | Telp: (021) 123456</h4>
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

    <div class="table-title">Hasil 1-Itemset memenuhi minimum support 2%</div>
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

    <div class="table-title">Hasil 2-Itemset Memenuhi Minimum Support 2%</div>
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

        <div class="table-title">Aturan Hasil Memenuhi Minimum Confidence</div>
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
                    @php $no = 1; @endphp
                    @foreach($associationRules as $rule)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $rule['pair'] }}</td>
                            <td>{{ $rule['pair'] }}</td>  <!-- Aturan ditampilkan lagi sebagai pasangan -->
                            <td>{{ $rule['support'] }}</td>
                            <td>{{ $rule['confidence'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
                </table>
</body>
</html>
