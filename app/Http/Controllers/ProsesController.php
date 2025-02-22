<?php

namespace App\Http\Controllers;

use Phpml\Association\Apriori;
use App\Models\DataTransaksi;
use App\Models\Dataproduk;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class ProsesController extends Controller
{
    public function index()
    {
        // Ambil Data Transaksi dan Produk dengan Paginate
        $datapagi = DataTransaksi::paginate(10);
        $produk = Dataproduk::paginate(10);

        // Mengirimkan data kosong untuk pengujian
            // $datapagi = new LengthAwarePaginator([], 0, 10);
            // $produk = new LengthAwarePaginator([], 0, 10);
            // $datapagi = request()->has('test_empty') ? new LengthAwarePaginator([], 0, 10) : DataTransaksi::paginate(10);
            // $produk = request()->has('test_empty') ? new LengthAwarePaginator([], 0, 10) : Dataproduk::paginate(10);
            
    
        // Bangun Data Transaksi untuk Apriori
        $transactions = [];
        foreach (DataTransaksi::all() as $transaksi) {
            // Asumsikan `nama_produk` adalah string dengan produk yang dipisahkan oleh koma
            $transactions[] = explode(", ", $transaksi->nama_produk);
        }
    
        // Jalankan Algoritma Apriori
        $apriori = new Apriori(0.4, 0.6);
        $apriori->train($transactions, []);
    
        // Menghitung Frekuensi Kemunculan Item
        $itemCounts = [];
        $totalTransactions = count($transactions);
        foreach ($transactions as $items) {
            foreach ($items as $item) {
                $itemCounts[$item] = ($itemCounts[$item] ?? 0) + 1;
            }
        }

     

        // Daftar produk Calon Itemset
        $datacalonitemset = [];
        foreach ($itemCounts as $item => $count) {
            $support = ($count / $totalTransactions) * 100;
            if ($support >= 0) {
                $datacalonitemset[$item] = [
                    'count' => $count,
                    'support' => number_format($support, 2) . '%'
                ];
            }
        }

        //Hasil 1-Itemset memenuhi minimum support
        $Itemset1 = [];
        foreach ($itemCounts as $item => $count) {
            $support = ($count / $totalTransactions) * 100;
            if ($support >= 2) {
                $Itemset1[$item] = [
                    'count' => $count,
                    'support' => number_format($support, 2) . '%'
                ];
            }
        }

        
        //Tidak terpakai
        $twoItemSets = [];
        foreach ($transactions as $items) {
            // Buat kombinasi 2-itemset untuk setiap transaksi
            $combinations = $this->getCombinations($items, 2);
            foreach ($combinations as $combination) {
                $pair = implode(", ", $combination);
                $twoItemSets[$pair] = ($twoItemSets[$pair] ?? 0) + 1;
            }
        }
        //___________________________

        
        // Daftar produk Calon 2-Itemset
        $Itemset2 = [];
        foreach ($twoItemSets as $pair => $count) {
            $support = ($count / $totalTransactions) * 100;
            if ($support >= 0) {
                $Itemset2[$pair] = [
                    'count' => $count,
                    'support' => number_format($support, 2) . '%'
                ];
            }
        }

        // Hasil 2-Itemset Memenuhi Minimum Support
        $filteredTwoItemset = [];
        foreach ($twoItemSets as $pair => $count) {
            $support = ($count / $totalTransactions) * 100;
            if ($support >= 2) {
                $filteredTwoItemset[$pair] = [
                    'count' => $count,
                    'support' => number_format($support, 2) . '%'
                ];
            }
        }


        // Hasil Confidence
        $filteredTwoItemsetWithConfidence = [];
        foreach ($filteredTwoItemset as $pair => $data) {
            // Mengambil item dari pasangan
            $items = explode(", ", $pair);
            $item1 = $items[0];
            $item2 = $items[1];

            // Menghitung Support untuk item B
            $supportItem2 = ($itemCounts[$item2] ?? 0) / $totalTransactions;

            // Menghitung Support untuk A ∩ B (supportBoth adalah jumlah transaksi yang mengandung kedua item)
            $supportBoth = ($data['count'] / $totalTransactions);

            // Confidence untuk B → A (P(A|B))
            $confidenceBA = ($supportBoth / $supportItem2) * 100; // Confidence B → A

            // Menyaring hanya yang memiliki confidence ≥ 60%
            if ($confidenceBA >= 0) {
                // Menyusun data pola 2-itemset, frekuensi B, frekuensi A & B, dan nilai confidence
                $filteredTwoItemsetWithConfidence[$pair] = [
                    'item1' => $item1, // Item A
                    'item2' => $item2, // Item B
                    'frekuensi_item1' => $itemCounts[$item1] ?? 0, // Frekuensi item A
                    'frekuensi_item2' => $itemCounts[$item2] ?? 0, // Frekuensi item B
                    'frekuensi_item1_and_item2' => $data['count'], // Frekuensi item A & B
                    'confidenceBA' => number_format($confidenceBA, 2) . '%' // Nilai Confidence B → A
                ];
            }
        }

        // Aturan Hasil Memenuhi Minimum Confidence
        $filteredTwoItemsetWithConfidencemin = [];
        foreach ($filteredTwoItemset as $pair => $data) {
            // Mengambil item dari pasangan
            $items = explode(", ", $pair);
            $item1 = $items[0];
            $item2 = $items[1];

            // Menghitung Support untuk item B
            $supportItem2 = ($itemCounts[$item2] ?? 0) / $totalTransactions;

            // Menghitung Support untuk A ∩ B (supportBoth adalah jumlah transaksi yang mengandung kedua item)
            $supportBoth = ($data['count'] / $totalTransactions);

            // Confidence untuk B → A (P(A|B))
            $confidenceBA = ($supportBoth / $supportItem2) * 100; // Confidence B → A

            // Menyaring hanya yang memiliki confidence ≥ 60%
            if ($confidenceBA >= 20) {
                // Menyusun data pola 2-itemset, frekuensi B, frekuensi A & B, dan nilai confidence
                $filteredTwoItemsetWithConfidencemin[$pair] = [
                    'item1' => $item1, // Item A
                    'item2' => $item2, // Item B
                    'frekuensi_item1' => $itemCounts[$item1] ?? 0, // Frekuensi item A
                    'frekuensi_item2' => $itemCounts[$item2] ?? 0, // Frekuensi item B
                    'frekuensi_item1_and_item2' => $data['count'], // Frekuensi item A & B
                    'confidenceBA' => number_format($confidenceBA, 2) . '%' // Nilai Confidence B → A
                ];
            }
        }

        // Aturan Hasil Memenuhi Minimum Confidence
        $associationRules = [];
        foreach ($filteredTwoItemset as $pair => $data) {
            // Mengambil item dari pasangan
            $items = explode(", ", $pair);
            $item1 = $items[0];
            $item2 = $items[1];

             // Menghitung Confidence untuk A → B
            $supportItem1 = ($itemCounts[$item1] ?? 0) / $totalTransactions;
            $supportBoth = ($data['count'] / $totalTransactions);
            $confidenceAB = ($supportBoth / $supportItem1) * 100; // Confidence A → B

            // Menghitung Confidence untuk B → A
            $supportItem2 = ($itemCounts[$item2] ?? 0) / $totalTransactions;
            $confidenceBA = ($supportBoth / $supportItem2) * 100; // Confidence B → A

            if ($confidenceAB >= 20 || $confidenceBA >= 20) {
                $associationRules[] = [
                    'pair' => "$item1, $item2",
                    'support' => number_format(($data['count'] / $totalTransactions) * 100, 2) . '%', // Support A & B
                    'confidence' => number_format($confidenceAB >= 20 ? $confidenceAB : $confidenceBA, 2) . '%'  // Menampilkan Confidence
                ];
            }
        }


    
       // Hanya Ambil Produk dengan Support ≥ 20%
        $filteredItemset = $this->filterHighSupportItems($itemCounts, $totalTransactions, 8);


        // Paginate hasil itemCounts
        $calonitemset = $this->paginateArray($datacalonitemset, 5);
        $itemsetone = $this->paginateArray($Itemset1, 5);

        $itemsettwo = $this->paginateArray($Itemset2, 5);

        $filteredItemsetPaginated = $this->paginateArray($filteredItemset, 10);
        $twoItemSetsPaginated = $this->paginateArray($filteredTwoItemset, 10);
    

        // dd(vars: $associationRules);


        // Kirim Data ke View
        return view('backend.proses-data', compact('produk',
         'datapagi', 'calonitemset',
          'filteredItemsetPaginated', 'twoItemSetsPaginated', 'itemsetone', 
          'itemsettwo', 'filteredTwoItemsetWithConfidence', 'filteredTwoItemsetWithConfidencemin', 'associationRules'));
    }
    
    /**
     * Fungsi untuk membuat paginate dari array.
     */
    private function paginateArray(array $items, $perPage)
    {
        $page = request()->get('page', 1);
        $collection = new Collection($items);
        $currentPageItems = $collection->slice(($page - 1) * $perPage, $perPage)->all();
        
        return new LengthAwarePaginator($currentPageItems, count($items), $perPage, $page, [
            'path' => request()->url(),
            'query' => request()->query(),
        ]);
    }

    private function filterHighSupportItems(array $itemCounts, $totalTransactions, $threshold)
    {
    $highSupportItems = [];
    foreach ($itemCounts as $item => $count) {
        $support = ($count / $totalTransactions) * 100;
        if ($support >= $threshold) { // **Hanya tampilkan jika support ≥ threshold**
            $highSupportItems[$item] = number_format($support, 2) . "%";
        }
    }
    return $highSupportItems;
    }

    private function getCombinations(array $items, int $size)
    {
        $combinations = [];
        $numItems = count($items);
        
        for ($i = 0; $i < $numItems; $i++) {
            for ($j = $i + 1; $j < $numItems; $j++) {
                $combinations[] = [$items[$i], $items[$j]];
            }
        }
        
        return $combinations;
    }


    public function hasil(){

           
        // Hapus session agar pengguna harus memulai ulang proses setelah keluar
        session()->forget('status_proses');

        // Ambil Data Transaksi dan Produk dengan Paginate
        $datapagi = DataTransaksi::paginate(10);
        $produk = Dataproduk::paginate(10);

        // Mengirimkan data kosong untuk pengujian
            // $datapagi = new LengthAwarePaginator([], 0, 10);
            // $produk = new LengthAwarePaginator([], 0, 10);
            // $datapagi = request()->has('test_empty') ? new LengthAwarePaginator([], 0, 10) : DataTransaksi::paginate(10);
            // $produk = request()->has('test_empty') ? new LengthAwarePaginator([], 0, 10) : Dataproduk::paginate(10);
            
        //  dd($datapagi);

        // Mengirimkan data kosong untuk pengujian
            // $transactions = request()->has('test_empty') ? [] : DataTransaksi::all()->map(function ($transaksi) {
            //     return explode(", ", $transaksi->nama_produk);
            // })->toArray();
            

        // Bangun Data Transaksi untuk Apriori
        $transactions = [];
        foreach (DataTransaksi::all() as $transaksi) {
            // Asumsikan `nama_produk` adalah string dengan produk yang dipisahkan oleh koma
            $transactions[] = explode(", ", $transaksi->nama_produk);
        }
    
        // Jalankan Algoritma Apriori
        $apriori = new Apriori(0.4, 0.6);
        $apriori->train($transactions, []);
    
        // Menghitung Frekuensi Kemunculan Item
        $itemCounts = [];
        $totalTransactions = count($transactions);
        foreach ($transactions as $items) {
            foreach ($items as $item) {
                $itemCounts[$item] = ($itemCounts[$item] ?? 0) + 1;
            }
        }

        // Cek apakah dalam mode pengujian kosong
            // if (request()->has('test_empty')) {
            //     $transactions = [];
            //     $itemCounts = [];
            //     $totalTransactions = 0;
            //     $datacalonitemset = [];
            //     $Itemset1 = [];
            //     $Itemset2 = [];
            //     $filteredTwoItemset = [];
            //     $filteredTwoItemsetWithConfidence = [];
            //     $filteredTwoItemsetWithConfidencemin = [];
            //     $associationRules = [];
            // } else {
            //     // Bangun Data Transaksi untuk Apriori
            //     $transactions = [];
            //     foreach (DataTransaksi::all() as $transaksi) {
            //         $transactions[] = explode(", ", $transaksi->nama_produk);
            //     }

            //     // Jalankan Algoritma Apriori
            //     $apriori = new Apriori(0.4, 0.6);
            //     $apriori->train($transactions, []);

            //     // Menghitung Frekuensi Kemunculan Item
            //     $itemCounts = [];
            //     $totalTransactions = count($transactions);
            //     foreach ($transactions as $items) {
            //         foreach ($items as $item) {
            //             $itemCounts[$item] = ($itemCounts[$item] ?? 0) + 1;
            //         }
            //     }
            // }


        // Daftar produk Calon Itemset
        $datacalonitemset = [];
        foreach ($itemCounts as $item => $count) {
            $support = ($count / $totalTransactions) * 100;
            if ($support >= 0) {
                $datacalonitemset[$item] = [
                    'count' => $count,
                    'support' => number_format($support, 2) . '%'
                ];
            }
        }

        //Hasil 1-Itemset memenuhi minimum support
        $Itemset1 = [];
        foreach ($itemCounts as $item => $count) {
            $support = ($count / $totalTransactions) * 100;
            if ($support >= 2) {
                $Itemset1[$item] = [
                    'count' => $count,
                    'support' => number_format($support, 2) . '%'
                ];
            }
        }

        
        //Tidak terpakai
        $twoItemSets = [];
        foreach ($transactions as $items) {
            // Buat kombinasi 2-itemset untuk setiap transaksi
            $combinations = $this->getCombinations($items, 2);
            foreach ($combinations as $combination) {
                $pair = implode(", ", $combination);
                $twoItemSets[$pair] = ($twoItemSets[$pair] ?? 0) + 1;
            }
        }
        //___________________________

        
        // Daftar produk Calon 2-Itemset
        $Itemset2 = [];
        foreach ($twoItemSets as $pair => $count) {
            $support = ($count / $totalTransactions) * 100;
            if ($support >= 0) {
                $Itemset2[$pair] = [
                    'count' => $count,
                    'support' => number_format($support, 2) . '%'
                ];
            }
        }

        // Hasil 2-Itemset Memenuhi Minimum Support
        $filteredTwoItemset = [];
        foreach ($twoItemSets as $pair => $count) {
            $support = ($count / $totalTransactions) * 100;
            if ($support >= 2) {
                $filteredTwoItemset[$pair] = [
                    'count' => $count,
                    'support' => number_format($support, 2) . '%'
                ];
            }
        }


        // Hasil Confidence
        $filteredTwoItemsetWithConfidence = [];
        foreach ($filteredTwoItemset as $pair => $data) {
            // Mengambil item dari pasangan
            $items = explode(", ", $pair);
            $item1 = $items[0];
            $item2 = $items[1];

            // Menghitung Support untuk item B
            $supportItem2 = ($itemCounts[$item2] ?? 0) / $totalTransactions;

            // Menghitung Support untuk A ∩ B (supportBoth adalah jumlah transaksi yang mengandung kedua item)
            $supportBoth = ($data['count'] / $totalTransactions);

            // Confidence untuk B → A (P(A|B))
            $confidenceBA = ($supportBoth / $supportItem2) * 100; // Confidence B → A

            // Menyaring hanya yang memiliki confidence ≥ 60%
            if ($confidenceBA >= 10) {
                // Menyusun data pola 2-itemset, frekuensi B, frekuensi A & B, dan nilai confidence
                $filteredTwoItemsetWithConfidence[$pair] = [
                    'item1' => $item1, // Item A
                    'item2' => $item2, // Item B
                    'frekuensi_item1' => $itemCounts[$item1] ?? 0, // Frekuensi item A
                    'frekuensi_item2' => $itemCounts[$item2] ?? 0, // Frekuensi item B
                    'frekuensi_item1_and_item2' => $data['count'], // Frekuensi item A & B
                    'confidenceBA' => number_format($confidenceBA, 2) . '%' // Nilai Confidence B → A
                ];
            }
        }

        // Aturan Hasil Memenuhi Minimum Confidence
        $filteredTwoItemsetWithConfidencemin = [];
        foreach ($filteredTwoItemset as $pair => $data) {
            // Mengambil item dari pasangan
            $items = explode(", ", $pair);
            $item1 = $items[0];
            $item2 = $items[1];

            // Menghitung Support untuk item B
            $supportItem2 = ($itemCounts[$item2] ?? 0) / $totalTransactions;

            // Menghitung Support untuk A ∩ B (supportBoth adalah jumlah transaksi yang mengandung kedua item)
            $supportBoth = ($data['count'] / $totalTransactions);

            // Confidence untuk B → A (P(A|B))
            $confidenceBA = ($supportBoth / $supportItem2) * 100; // Confidence B → A

            // Menyaring hanya yang memiliki confidence ≥ 60%
            if ($confidenceBA >= 20) {
                // Menyusun data pola 2-itemset, frekuensi B, frekuensi A & B, dan nilai confidence
                $filteredTwoItemsetWithConfidencemin[$pair] = [
                    'item1' => $item1, // Item A
                    'item2' => $item2, // Item B
                    'frekuensi_item1' => $itemCounts[$item1] ?? 0, // Frekuensi item A
                    'frekuensi_item2' => $itemCounts[$item2] ?? 0, // Frekuensi item B
                    'frekuensi_item1_and_item2' => $data['count'], // Frekuensi item A & B
                    'confidenceBA' => number_format($confidenceBA, 2) . '%' // Nilai Confidence B → A
                ];
            }
        }

        // Aturan Hasil Memenuhi Minimum Confidence
        $associationRules = [];
        foreach ($filteredTwoItemset as $pair => $data) {
            // Mengambil item dari pasangan
            $items = explode(", ", $pair);
            $item1 = $items[0];
            $item2 = $items[1];

             // Menghitung Confidence untuk A → B
            $supportItem1 = ($itemCounts[$item1] ?? 0) / $totalTransactions;
            $supportBoth = ($data['count'] / $totalTransactions);
            $confidenceAB = ($supportBoth / $supportItem1) * 100; // Confidence A → B

            // Menghitung Confidence untuk B → A
            $supportItem2 = ($itemCounts[$item2] ?? 0) / $totalTransactions;
            $confidenceBA = ($supportBoth / $supportItem2) * 100; // Confidence B → A

            if ($confidenceAB >= 20 || $confidenceBA >= 20) {
                $associationRules[] = [
                    'pair' => "$item1, $item2",
                    'support' => number_format(($data['count'] / $totalTransactions) * 100, 2) . '%', // Support A & B
                    'confidence' => number_format($confidenceAB >= 20 ? $confidenceAB : $confidenceBA, 2) . '%'  // Menampilkan Confidence
                ];
            }
        }


    
       // Hanya Ambil Produk dengan Support ≥ 20%
        $filteredItemset = $this->filterHighSupportItems($itemCounts, $totalTransactions, 8);


        // Paginate hasil itemCounts
        $calonitemset = $this->paginateArray($datacalonitemset, 5);
        $itemsetone = $this->paginateArray($Itemset1, 5);

        $itemsettwo = $this->paginateArray($Itemset2, 5);

        $filteredItemsetPaginated = $this->paginateArray($filteredItemset, 10);
        $twoItemSetsPaginated = $this->paginateArray($filteredTwoItemset, 10);
    

        // dd(vars: $associationRules);


        // Kirim Data ke View
        return view('backend.hasil', compact('produk',
         'datapagi', 'calonitemset',
          'filteredItemsetPaginated', 'twoItemSetsPaginated', 'itemsetone', 
          'itemsettwo', 'filteredTwoItemsetWithConfidence', 'filteredTwoItemsetWithConfidencemin', 'associationRules'));
   
    }

    public function analyzer()
    {
        // Menetapkan status proses di session sebagai "berlangsung"
        session(['status_proses' => 'berlangsung']);
    
        // Mulai proses analisis data
        $this->prosesData();
    
        // Setelah proses selesai, ubah status menjadi selesai
        session(['status_proses' => 'selesai']);
    
        // Kembalikan respons sukses
        return response()->json([
            'status' => 'success',
            'message' => 'Proses selesai. Silakan lihat hasil.'
        ]);
    }
    
    
    private function prosesData()
    {
        // Logika untuk analisis atau proses data Anda, seperti menjalankan algoritma
        // Misalnya Apriori atau proses lainnya yang memakan waktu.
        sleep(5); // Misalnya simulasi proses yang memakan waktu 5 detik
    }


    public function cetak()
    {
        // Ambil Data Transaksi dan Produk dengan Paginate
        $datapagi = DataTransaksi::all();
        $produk = Dataproduk::all();

        // Pengujian aktifkan ini
            // $datapagi = request()->has('test_empty') ? new LengthAwarePaginator([], 0, 10) : DataTransaksi::paginate(10);
            // $produk = request()->has('test_empty') ? new LengthAwarePaginator([], 0, 10) : Dataproduk::paginate(10);

    
        // Bangun Data Transaksi untuk Apriori
        $transactions = [];
        foreach (DataTransaksi::all() as $transaksi) {
            // Asumsikan `nama_produk` adalah string dengan produk yang dipisahkan oleh koma
            $transactions[] = explode(", ", $transaksi->nama_produk);
        }
    
        // Jalankan Algoritma Apriori
        $apriori = new Apriori(0.4, 0.6);
        $apriori->train($transactions, []);
    
        // Menghitung Frekuensi Kemunculan Item
        $itemCounts = [];
        $totalTransactions = count($transactions);
        foreach ($transactions as $items) {
            foreach ($items as $item) {
                $itemCounts[$item] = ($itemCounts[$item] ?? 0) + 1;
            }
        }

     
        // Daftar produk Calon Itemset
        $datacalonitemset = [];
        foreach ($itemCounts as $item => $count) {
            $support = ($count / $totalTransactions) * 100;
            if ($support >= 0) {
                $datacalonitemset[$item] = [
                    'count' => $count,
                    'support' => number_format($support, 2) . '%'
                ];
            }
        }

        //Hasil 1-Itemset memenuhi minimum support
        $Itemset1 = [];
        foreach ($itemCounts as $item => $count) {
            $support = ($count / $totalTransactions) * 100;
            if ($support >= 10) {
                $Itemset1[$item] = [
                    'count' => $count,
                    'support' => number_format($support, 2) . '%'
                ];
            }
        }

        
        //Tidak terpakai
        $twoItemSets = [];
        foreach ($transactions as $items) {
            // Buat kombinasi 2-itemset untuk setiap transaksi
            $combinations = $this->getCombinations($items, 2);
            foreach ($combinations as $combination) {
                $pair = implode(", ", $combination);
                $twoItemSets[$pair] = ($twoItemSets[$pair] ?? 0) + 1;
            }
        }
        //___________________________

        
        // Daftar produk Calon 2-Itemset
        $Itemset2 = [];
        foreach ($twoItemSets as $pair => $count) {
            $support = ($count / $totalTransactions) * 100;
            if ($support >= 0) {
                $Itemset2[$pair] = [
                    'count' => $count,
                    'support' => number_format($support, 2) . '%'
                ];
            }
        }

        // Hasil 2-Itemset Memenuhi Minimum Support
        $filteredTwoItemset = [];
        foreach ($twoItemSets as $pair => $count) {
            $support = ($count / $totalTransactions) * 100;
            if ($support >= 2) {
                $filteredTwoItemset[$pair] = [
                    'count' => $count,
                    'support' => number_format($support, 2) . '%'
                ];
            }
        }


        // Hasil Confidence
        $filteredTwoItemsetWithConfidence = [];
        foreach ($filteredTwoItemset as $pair => $data) {
            // Mengambil item dari pasangan
            $items = explode(", ", $pair);
            $item1 = $items[0];
            $item2 = $items[1];

            // Menghitung Support untuk item B
            $supportItem2 = ($itemCounts[$item2] ?? 0) / $totalTransactions;

            // Menghitung Support untuk A ∩ B (supportBoth adalah jumlah transaksi yang mengandung kedua item)
            $supportBoth = ($data['count'] / $totalTransactions);

            // Confidence untuk B → A (P(A|B))
            $confidenceBA = ($supportBoth / $supportItem2) * 100; // Confidence B → A

            // Menyaring hanya yang memiliki confidence ≥ 60%
            if ($confidenceBA >= 10) {
                // Menyusun data pola 2-itemset, frekuensi B, frekuensi A & B, dan nilai confidence
                $filteredTwoItemsetWithConfidence[$pair] = [
                    'item1' => $item1, // Item A
                    'item2' => $item2, // Item B
                    'frekuensi_item1' => $itemCounts[$item1] ?? 0, // Frekuensi item A
                    'frekuensi_item2' => $itemCounts[$item2] ?? 0, // Frekuensi item B
                    'frekuensi_item1_and_item2' => $data['count'], // Frekuensi item A & B
                    'confidenceBA' => number_format($confidenceBA, 2) . '%' // Nilai Confidence B → A
                ];
            }
        }

        // Aturan Hasil Memenuhi Minimum Confidence
        $filteredTwoItemsetWithConfidencemin = [];
        foreach ($filteredTwoItemset as $pair => $data) {
            // Mengambil item dari pasangan
            $items = explode(", ", $pair);
            $item1 = $items[0];
            $item2 = $items[1];

            // Menghitung Support untuk item B
            $supportItem2 = ($itemCounts[$item2] ?? 0) / $totalTransactions;

            // Menghitung Support untuk A ∩ B (supportBoth adalah jumlah transaksi yang mengandung kedua item)
            $supportBoth = ($data['count'] / $totalTransactions);

            // Confidence untuk B → A (P(A|B))
            $confidenceBA = ($supportBoth / $supportItem2) * 100; // Confidence B → A

            // Menyaring hanya yang memiliki confidence ≥ 60%
            if ($confidenceBA >= 20) {
                // Menyusun data pola 2-itemset, frekuensi B, frekuensi A & B, dan nilai confidence
                $filteredTwoItemsetWithConfidencemin[$pair] = [
                    'item1' => $item1, // Item A
                    'item2' => $item2, // Item B
                    'frekuensi_item1' => $itemCounts[$item1] ?? 0, // Frekuensi item A
                    'frekuensi_item2' => $itemCounts[$item2] ?? 0, // Frekuensi item B
                    'frekuensi_item1_and_item2' => $data['count'], // Frekuensi item A & B
                    'confidenceBA' => number_format($confidenceBA, 2) . '%' // Nilai Confidence B → A
                ];
            }
        }

        // Aturan Hasil Memenuhi Minimum Confidence
        $associationRules = [];
        foreach ($filteredTwoItemset as $pair => $data) {
            // Mengambil item dari pasangan
            $items = explode(", ", $pair);
            $item1 = $items[0];
            $item2 = $items[1];

             // Menghitung Confidence untuk A → B
            $supportItem1 = ($itemCounts[$item1] ?? 0) / $totalTransactions;
            $supportBoth = ($data['count'] / $totalTransactions);
            $confidenceAB = ($supportBoth / $supportItem1) * 100; // Confidence A → B

            // Menghitung Confidence untuk B → A
            $supportItem2 = ($itemCounts[$item2] ?? 0) / $totalTransactions;
            $confidenceBA = ($supportBoth / $supportItem2) * 100; // Confidence B → A

            if ($confidenceAB >= 20 || $confidenceBA >= 20) {
                $associationRules[] = [
                    'pair' => "$item1, $item2",
                    'support' => number_format(($data['count'] / $totalTransactions) * 100, 2) . '%', // Support A & B
                    'confidence' => number_format($confidenceAB >= 20 ? $confidenceAB : $confidenceBA, 2) . '%'  // Menampilkan Confidence
                ];
            }
        }

    
       // Hanya Ambil Produk dengan Support ≥ 20%
        $filteredItemset = $this->filterHighSupportItems($itemCounts, $totalTransactions, 8);


        // Paginate hasil itemCounts
        $calonitemset = $this->paginateArray($datacalonitemset, 500);
        $itemsetone = $this->paginateArray($Itemset1, 500);

        $itemsettwo = $this->paginateArray($Itemset2, 500);

        $filteredItemsetPaginated = $this->paginateArray($filteredItemset, 500);
        $twoItemSetsPaginated = $this->paginateArray($filteredTwoItemset, 500);
    

        // dd(vars: $associationRules);


        // Render ke dalam view report-pdf.blade.php
        $pdf = Pdf::loadView('backend.cetak-hasil-analisis', compact('data', 'datapagi', 'calonitemset',
          'filteredItemsetPaginated', 'twoItemSetsPaginated', 'itemsetone', 
          'itemsettwo', 'filteredTwoItemsetWithConfidence', 'filteredTwoItemsetWithConfidencemin', 'associationRules'));

        // return $pdf->download('laporan.pdf'); // Unduh file PDF
        return $pdf->stream('laporan-data-hasil-analisis.pdf');

    }
    


}
