<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Data Produk</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .header { text-align: left; margin-bottom: 10px; }
        .header img { width: 80px; height: auto; }
        .header h2, .header h4 { margin: 3px 0; }
        
        .line { border-bottom: 2px solid black; margin-bottom: 10px; }

        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table, th, td { border: 1px solid black; padding: 6px; text-align: left; }
        th { background-color: #f2f2f2; font-size: 12px; text-align: center}
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

    <h3 style="text-align: center; margin-bottom: 5px;">Laporan Data Produk</h3>
    <h4 style="text-align: center; margin-top: 2px;">Produk Skincare - Ternate Kosmetik</h4>
    
    <table>
        <thead>
            <tr>
              <th>No</th>
              <th>Kode Produk</th>
              <th>Nama Produk</th>
            </tr>
        </thead>
        <tbody>
            @foreach($dataproduk as $data)
            <tr>
                <td style="text-align: center">{{ $loop->iteration }}</td> 
                <td style="text-align: center">{{ $data->kode_produk }}</td> 
                <td>{{ $data->nama_produk }}</td>
                </tr>
            @endforeach
        </tbody>
           
    </table>   
</body>
</html>
