 <!-- 📌 Tabel 2-Itemset -->
 <h3>📊 Tabel 2-Itemset (Support ≥ 20%)</h3>
 <table border="1" cellpadding="10" cellspacing="0">
     <tr>
         <th>No</th>
         <th>2-Itemset</th>
         <th>Frekuensi</th>
         <th>Support</th>
     </tr>
     @php $no = 1; @endphp
     @foreach($twoItemSetsPaginated as $pair => $data)
     <tr>
         <td>{{ $no++ }}</td>
         <td>{{ $pair }}</td>
         <td>{{ $data['count'] }}</td>
         <td>{{ $data['support'] }}</td>
     </tr>
     @endforeach
 </table>
<!-- Tambahkan Pagination -->
<div class="d-flex justify-content-center">
    {{ $twoItemSetsPaginated->links('pagination::bootstrap-4') }}
</div> 
<br><br>
<!-- 📌 Tabel Confidence 2-Itemset (Confidence ≥ 60%) -->
<h3>📊 Tabel Confidence 2-Itemset (Confidence ≥ 60%)</h3>
<table border="1" cellpadding="10" cellspacing="0">
    <tr>
        <th>No</th>
        <th>2-Itemset</th>
        <th>Confidence A </th>
        <th>Confidence A&B</th>
    </tr>
    @php $no = 1; @endphp
    @foreach($twoItemSetsPaginated as $pair => $data)
    <tr>
        <td>{{ $no++ }}</td>
        <td>{{ $pair }}</td>
        <td>{{ $data['confidenceAB'] ?? 'N/A' }}</td>
        <td>{{ $data['confidenceBA'] ?? 'N/A' }}</td>
    </tr>
    @endforeach
</table>

<!-- Pagination -->
<div class="d-flex justify-content-center">
    {{ $twoItemSetsPaginated->links('pagination::bootstrap-4') }}
</div> 

<br><br>
<h2>Tabel Itemset (Support ≥ 20%)</h2>
<table border="1">
    <tr>
        <th>Produk</th>
        <th>Support</th>
    </tr>
    @foreach($filteredItemsetPaginated as $item => $support)
        <tr>
            <td>{{ $item }}</td>
            <td>{{ $support }}</td>
        </tr>
    @endforeach
</table>

<!-- Tambahkan Pagination -->
<div class="d-flex justify-content-center">
    {{ $filteredItemsetPaginated->links('pagination::bootstrap-4') }}
</div> 


$filteredTwoItemsetWithConfidence = [];
        foreach ($filteredTwoItemset as $pair => $data) {
            $items = explode(", ", $pair);
            $item1 = $items[0];
            $item2 = $items[1];
    
            // Menghitung confidence (A → B) = Support(A ∩ B) / Support(A)
            $supportItem1 = ($itemCounts[$item1] ?? 0) / $totalTransactions;
            $supportItem2 = ($itemCounts[$item2] ?? 0) / $totalTransactions;
            $supportBoth = ($data['count'] / $totalTransactions);
    
            // Confidence for A -> B
            $confidenceAB = ($supportBoth / $supportItem1) * 100;
    
            // Confidence for B -> A
            $confidenceBA = ($supportBoth / $supportItem2) * 100;
    
            // Filter hanya yang memiliki confidence ≥ 60%
            if ($confidenceAB >= 8) {
                $filteredTwoItemsetWithConfidence[$pair]['confidenceAB'] = number_format($confidenceAB, 2) . '%';
            }
            if ($confidenceBA >= 8) {
                $filteredTwoItemsetWithConfidence[$pair]['confidenceBA'] = number_format($confidenceBA, 2) . '%';
            }
        }