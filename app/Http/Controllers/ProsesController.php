<?php

namespace App\Http\Controllers;

use Phpml\Association\Fgrowth;
use App\Models\DataTransaksi;
use App\Models\Dataproduk;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use App\Exports\HasilAnalisisExport;
use App\Models\Fpgrowth;
use Maatwebsite\Excel\Facades\Excel;

class ProsesController extends Controller
{
    public function index()
    {

        $datatransaksi = DataTransaksi::all();
    
        // Kirim Data ke View
        return view('backend.proses-data', compact( 'datatransaksi'));
    }
    
    
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

        // Hapus session
        session()->forget('status_proses');

        // Ambil Data Transaksi dan Produk dengan Paginate
        $datapagi = DataTransaksi::paginate(10);
        $produk = Dataproduk::paginate(10);
        $fp = Fpgrowth::all();
        $FpSupport = Fpgrowth::value('support');
        $FpConfidance = Fpgrowth::value('confidance');
       
        $transactions = [];
        foreach (DataTransaksi::all() as $transaksi) {
           
            $items = array_map('trim', explode(",", $transaksi->nama_produk));

            if (count($items) > 1) {
                sort($items);
                $transactions[] = $items;
            }
        }

        $fgrowth = new Fgrowth(0.4, 0.6);
        $fgrowth->train($transactions, []);
    
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
            if ($support >= $FpSupport) {
                $Itemset1[$item] = [
                    'count' => $count,
                    'support' => number_format($support, 2) . '%',
                    'support_value' => $support
                ];
            }
        }
        
        // Urutkan berdasarkan support tertinggi
        uasort($Itemset1, function ($a, $b) {
            return $b['support_value'] <=> $a['support_value'];
        });
        
        // Hapus key nilai support
        foreach ($Itemset1 as &$item) {
            unset($item['support_value']);
        }

        $twoItemSets = [];

        // Ambil daftar item dari Itemset1
        $itemsFromItemset1 = array_keys($Itemset1);

        // Buat kombinasi 2-itemset
        $combinations = $this->getCombinations($itemsFromItemset1, 2);

        foreach ($combinations as $combination) {
            $pair = implode(", ", $combination);
            $twoItemSets[$pair] = 0;
        }

        // Hitung frekuensi kombinasi
        foreach ($transactions as $items) {
            foreach ($combinations as $combination) {
                $pair = implode(", ", $combination);

                if (in_array($combination[0], $items) && in_array($combination[1], $items)) {
                    $twoItemSets[$pair]++;
                }
            }
        }

        $Itemset2 = [];
        $minSupport = 0;

        foreach ($twoItemSets as $pair => $count) {
            if ($totalTransactions > 0) { 
                $support = ($count / $totalTransactions) * 100;

                if ($support >= $minSupport) {
                    $Itemset2[$pair] = [
                        'count' => $count,
                        'support' => number_format($support, 2) . '%'
                    ];
                }
            }
        }

        // Hasil 2-Itemset Memenuhi Minimum Support
        $filteredTwoItemset = [];
        foreach ($twoItemSets as $pair => $count) {
            $support = ($count / $totalTransactions) * 100;
            if ($support >= $FpSupport) {
                $filteredTwoItemset[$pair] = [
                    'count' => $count,
                    'support' => number_format($support, 2) . '%'
                ];
            }
        }

        // Hasil Confidence
        $filteredTwoItemsetWithConfidence = [];
        foreach ($filteredTwoItemset as $pair => $data) {

            $items = explode(", ", $pair);
            $item1 = $items[0];
            $item2 = $items[1];

            $supportItem2 = ($itemCounts[$item2] ?? 0) / $totalTransactions;

            $supportItem2 = ($itemCounts[$item2] ?? 0) / $totalTransactions;
        

            $confidenceAB = ($data['count'] / $itemCounts[$item1]) * 100;

            // Menyaring hanya yang memiliki confidence
            if ($confidenceAB >= 0) {
                $filteredTwoItemsetWithConfidence[$pair] = [
                    'item1' => $item1, 
                    'item2' => $item2, 
                    'frekuensi_A' => $itemCounts[$item1] ?? 0, 
                    'frekuensi_A_&_B' => $data['count'], 
                    'confidenceAB' => number_format($confidenceAB, 2) . '%' 
                ];
            }
        }

        // Aturan Hasil Memenuhi Minimum Confidence
        $filteredTwoItemsetWithConfidencemin = [];
        foreach ($filteredTwoItemset as $pair => $data) {

            $items = explode(", ", $pair);
            $item1 = $items[0];
            $item2 = $items[1];
          
            $confidenceAB = ($data['count'] / $itemCounts[$item1]) * 100; 

            // Menyaring
            if ($confidenceAB >= $FpConfidance) {
                $filteredTwoItemsetWithConfidencemin[$pair] = [
                    'item1' => $item1, // Item A
                    'item2' => $item2, // Item B
                    'frekuensi_A' => $itemCounts[$item1] ?? 0, 
                    'frekuensi_A_&_B' => $data['count'], 
                    'confidenceAB' => number_format($confidenceAB, 2) . '%' 
                ];
            }
        }

        // Hasil Aturan Asosiasi yang Terbentuk
        $associationRules = [];
        foreach ($filteredTwoItemset as $pair => $data) {

            $items = explode(", ", $pair);
            $item1 = $items[0];
            $item2 = $items[1];

            $supportItem1 = ($itemCounts[$item1] ?? 0) / $totalTransactions;
            $supportBoth = ($data['count'] / $totalTransactions);
            $confidenceAB = ($supportBoth / $supportItem1) * 100; 

            if ($confidenceAB >= $FpConfidance || $confidenceAB >= $FpConfidance) {
                $associationRules[] = [
                    'pair' => "$item1, $item2",
                    'support' => number_format(($data['count'] / $totalTransactions) * 100, 2) . '%', // Support A & B
                    'confidence' => number_format($confidenceAB >= $FpConfidance ? $confidenceAB : $confidenceAB, 2) . '%'  // Menampilkan Confidence
                ];
            }
        }


       // Hanya Ambil Produk dengan Support
        $filteredItemset = $this->filterHighSupportItems($itemCounts, $totalTransactions, 8);

        $calonitemset = $this->paginateArray($datacalonitemset, perPage: 2000);
        $itemsetone = $this->paginateArray($Itemset1, 2000);

        $itemsettwo = $this->paginateArray($Itemset2, 2000);

        $filteredItemsetPaginated = $this->paginateArray($filteredItemset, 2000);
        $twoItemSetsPaginated = $this->paginateArray($filteredTwoItemset, 2000);

        // Kirim Data ke View
        return view('backend.hasil', compact('produk',
         'datapagi', 'calonitemset',
          'filteredItemsetPaginated', 'twoItemSetsPaginated', 'itemsetone', 
          'itemsettwo', 'filteredTwoItemsetWithConfidence', 'filteredTwoItemsetWithConfidencemin', 'associationRules', 'FpConfidance', 'FpSupport'));
   
    }

    public function analyzer()
    {
        session(['status_proses' => 'berlangsung']);
    
        $this->prosesData();
        session(['status_proses' => 'selesai']);
    
        return response()->json([
            'status' => 'success',
            'message' => 'Proses selesai. Silakan lihat hasil.'
        ]);
    }
    
    
    private function prosesData()
    {
        sleep(5); 
    }


    public function cetak()
    {
          // Hapus session
          session()->forget('status_proses');

          // Ambil Data Transaksi dan Produk
          $datapagi = DataTransaksi::paginate(10);
          $produk = Dataproduk::paginate(10);
          $fp = Fpgrowth::all();
          $FpSupport = Fpgrowth::value('support');
          $FpConfidance = Fpgrowth::value('confidance');            
  
          $transactions = [];
          foreach (DataTransaksi::all() as $transaksi) {

              $items = array_map('trim', explode(",", $transaksi->nama_produk));

              if (count($items) > 1) {
                  sort($items);
                  $transactions[] = $items;
              }
          }
  

          $fgrowth = new Fgrowth(0.4, 0.6);
          $fgrowth->train($transactions, []);
      
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
              if ($support >= $FpSupport) {
                  $Itemset1[$item] = [
                      'count' => $count,
                      'support' => number_format($support, 2) . '%',
                      'support_value' => $support
                  ];
              }
          }
          
          // Urutkan berdasarkan support tertinggi
          uasort($Itemset1, function ($a, $b) {
              return $b['support_value'] <=> $a['support_value'];
          });
          
          // Hapus key nilai support'support_value' setelah sorting
          foreach ($Itemset1 as &$item) {
              unset($item['support_value']);
          }
  
          
  
          $twoItemSets = [];
  
          // Ambil daftar item dari Itemset1
          $itemsFromItemset1 = array_keys($Itemset1);
  
          // Buat kombinasi 2-itemset
          $combinations = $this->getCombinations($itemsFromItemset1, 2);
  
          foreach ($combinations as $combination) {
              $pair = implode(", ", $combination);
              $twoItemSets[$pair] = 0;
          }
  
          // Hitung frekuensi kombinasi dalam transaksi
          foreach ($transactions as $items) {
              foreach ($combinations as $combination) {
                  $pair = implode(", ", $combination);
  
                  if (in_array($combination[0], $items) && in_array($combination[1], $items)) {
                      $twoItemSets[$pair]++;
                  }
              }
          }
  
  
          $Itemset2 = [];
          $minSupport = 0;
  
          foreach ($twoItemSets as $pair => $count) {
              if ($totalTransactions > 0) { 
                  $support = ($count / $totalTransactions) * 100;
  
                  if ($support >= $minSupport) {
                      $Itemset2[$pair] = [
                          'count' => $count,
                          'support' => number_format($support, 2) . '%'
                      ];
                  }
              }
          }
  
          // Hasil 2-Itemset Memenuhi Minimum Support
          $filteredTwoItemset = [];
          foreach ($twoItemSets as $pair => $count) {
              $support = ($count / $totalTransactions) * 100;
              if ($support >= $FpSupport) {
                  $filteredTwoItemset[$pair] = [
                      'count' => $count,
                      'support' => number_format($support, 2) . '%'
                  ];
              }
          }
  
  
          // Hasil Confidence
          $filteredTwoItemsetWithConfidence = [];
          foreach ($filteredTwoItemset as $pair => $data) {

              $items = explode(", ", $pair);
              $item1 = $items[0];
              $item2 = $items[1];

              $supportItem2 = ($itemCounts[$item2] ?? 0) / $totalTransactions;
  
              $supportItem2 = ($itemCounts[$item2] ?? 0) / $totalTransactions;
          
  
              $confidenceAB = ($data['count'] / $itemCounts[$item1]) * 100;

              if ($confidenceAB >= 0) {
                  $filteredTwoItemsetWithConfidence[$pair] = [
                      'item1' => $item1,
                      'item2' => $item2,
                      'frekuensi_A' => $itemCounts[$item1] ?? 0, 
                      'frekuensi_A_&_B' => $data['count'], 
                      'confidenceAB' => number_format($confidenceAB, 2) . '%' 
                  ];
              }
          }
  
          // Aturan Hasil Memenuhi Minimum Confidence
          $filteredTwoItemsetWithConfidencemin = [];
          foreach ($filteredTwoItemset as $pair => $data) {

              $items = explode(", ", $pair);
              $item1 = $items[0];
              $item2 = $items[1];
            
              $confidenceAB = ($data['count'] / $itemCounts[$item1]) * 100; 

              if ($confidenceAB >= $FpConfidance) {
                  $filteredTwoItemsetWithConfidencemin[$pair] = [
                      'item1' => $item1,
                      'item2' => $item2,
                      'frekuensi_A' => $itemCounts[$item1] ?? 0, 
                      'frekuensi_A_&_B' => $data['count'], 
                      'confidenceAB' => number_format($confidenceAB, 2) . '%' 
                  ];
              }
          }
  
          // Hasil Aturan Asosiasi yang Terbentuk
          $associationRules = [];
          foreach ($filteredTwoItemset as $pair => $data) {
  
              $items = explode(", ", $pair);
              $item1 = $items[0];
              $item2 = $items[1];

              $supportItem1 = ($itemCounts[$item1] ?? 0) / $totalTransactions;
              $supportBoth = ($data['count'] / $totalTransactions);
              $confidenceAB = ($supportBoth / $supportItem1) * 100; 
  
              if ($confidenceAB >= $FpConfidance || $confidenceAB >= $FpConfidance) {
                  $associationRules[] = [
                      'pair' => "$item1, $item2",
                      'support' => number_format(($data['count'] / $totalTransactions) * 100, 2) . '%', // Support A & B
                      'confidence' => number_format($confidenceAB >= $FpConfidance ? $confidenceAB : $confidenceAB, 2) . '%'  // Menampilkan Confidence
                  ];
              }
          }
  
  
         // Hanya Ambil Produk dengan Support
          $filteredItemset = $this->filterHighSupportItems($itemCounts, $totalTransactions, 8);
  
          $calonitemset = $this->paginateArray($datacalonitemset, perPage: 2000);
          $itemsetone = $this->paginateArray($Itemset1, 2000);
  
          $itemsettwo = $this->paginateArray($Itemset2, 2000);
  
          $filteredItemsetPaginated = $this->paginateArray($filteredItemset, 2000);
          $twoItemSetsPaginated = $this->paginateArray($filteredTwoItemset, 2000);

        $pdf = Pdf::loadView('backend.cetak-hasil-analisis', compact('data', 'datapagi', 'calonitemset',
          'filteredItemsetPaginated', 'twoItemSetsPaginated', 'itemsetone', 
          'itemsettwo', 'filteredTwoItemsetWithConfidence', 'filteredTwoItemsetWithConfidencemin', 'associationRules', 'FpConfidance', 'FpSupport'));

        // return $pdf->download('laporan.pdf'); // Unduh file PDF
        return $pdf->stream('laporan-data-hasil-analisis.pdf');

    }


// public function exportExcel()
// {
//      // Ambil Data Transaksi dan Produk dengan Paginate
//      $datapagi = DataTransaksi::paginate(10);
//      $produk = Dataproduk::paginate(10);  
//      $FpSupport = Fpgrowth::value('support');
//      $FpConfidance = Fpgrowth::value('confidance');          

//      // Bangun Data Transaksi untuk Fgrowth
//      $transactions = [];
//      foreach (DataTransaksi::all() as $transaksi) {
//          // Asumsikan `nama_produk` adalah string dengan produk yang dipisahkan oleh koma
//          $transactions[] = explode(", ", $transaksi->nama_produk);
//      }
 
//      // Jalankan Algoritma Fgrowth
//      $fgrowth = new Fgrowth(0.4, 0.6);
//      $fgrowth->train($transactions, []);
 
//      // Menghitung Frekuensi Kemunculan Item
//      $itemCounts = [];
//      $totalTransactions = count($transactions);
//      foreach ($transactions as $items) {
//          foreach ($items as $item) {
//              $itemCounts[$item] = ($itemCounts[$item] ?? 0) + 1;
//          }
//      }


//      // Daftar produk Calon Itemset
//     $datacalonitemset = [];
//     foreach ($itemCounts as $item => $count) {
//         $support = ($count / $totalTransactions) * 100;

//         if ($support >= 0) {
//             $datacalonitemset[$item] = [
//                 'item'    => $item,
//                 'count'   => $count,
//                 'support' => number_format($support, 2) . '%'
//             ];
//         }
//     }

//      // dd($totalTransactions);

//      //Hasil 1-Itemset memenuhi minimum support
//      $Itemset1 = [];
//      foreach ($itemCounts as $item => $count) {
//          $support = ($count / $totalTransactions) * 100;
//          if ($support >= $FpSupport) {
//              $Itemset1[$item] = [
//                  'item'    => $item,
//                  'count' => $count,
//                  'support' => number_format($support, 2) . '%'
//              ];
//          }
//      }

     
//      //Tidak terpakai
//      $twoItemSets = [];
//      foreach ($transactions as $items) {
//          // Buat kombinasi 2-itemset untuk setiap transaksi
//          $combinations = $this->getCombinations($items, 2);
//          foreach ($combinations as $combination) {
//              $pair = implode(", ", $combination);
//              $twoItemSets[$pair] = ($twoItemSets[$pair] ?? 0) + 1;
//          }
//      }
//      //___________________________

     
//      // Daftar produk Calon 2-Itemset
//      $Itemset2 = [];
//      foreach ($twoItemSets as $pair => $count) {
//          $support = ($count / $totalTransactions) * 100;
//          if ($support >= 0) {
//              $Itemset2[$pair] = [
//                  'pair'    => $pair,
//                  'count' => $count,
//                  'support' => number_format($support, 2) . '%'
//              ];
//          }
//      }

//      // Hasil 2-Itemset Memenuhi Minimum Support
//      $HasilItemset2 = [];
//      foreach ($twoItemSets as $pair => $count) {
//          $support = ($count / $totalTransactions) * 100;
//          if ($support >= $FpSupport) {
//              $HasilItemset2[$pair] = [
//                  'pair'    => $pair,
//                  'count' => $count,
//                  'support' => number_format($support, 2) . '%'
//              ];
//          }
//      }

//      // Hasil 2-Itemset Memenuhi Minimum Support
//     //  $filteredTwoItemset = [];
//     //  foreach ($twoItemSets as $pair => $count) {
//     //      $support = ($count / $totalTransactions) * 100;
//     //      if ($support >= $FpSupport) {
//     //          $filteredTwoItemset[$pair] = [
//     //              'pair'    => $pair,
//     //              'count' => $count,
//     //              'support' => number_format($support, 2) . '%'
//     //          ];
//     //      }
//     //  }


//      // Hasil Confidence
//      $filteredTwoItemsetWithConfidence = [];
//      foreach ($HasilItemset2 as $pair => $data) {
//          // Mengambil item dari pasangan
//          $items = explode(", ", $pair);
//          $item1 = $items[0];
//          $item2 = $items[1];

//          // Menghitung Support untuk item B    

//          $confidenceAB = ($data['count'] / $itemCounts[$item1]) * 100;

//          // Menyaring hanya yang memiliki confidence
//          if ($confidenceAB >= 0) {
//             $filteredTwoItemsetWithConfidence[$pair] = [
//                 'item_pair' => $item1 . ',' . $item2,
//                 'frekuensi_A' => $itemCounts[$item1] ?? 0, 
//                 'frekuensi_A_&_B' => $data['count'], 
//                 'confidenceAB' => number_format($confidenceAB, 2) . '%' 
//             ];
//         }
        
//      }

//      // Aturan Hasil Memenuhi Minimum Confidence
//      $filteredTwoItemsetWithConfidencemin = [];
//      foreach ($HasilItemset2 as $pair => $data) {

//          // Mengambil item dari pasangan
//          $items = explode(", ", $pair);
//          $item1 = $items[0];
//          $item2 = $items[1];
       
//          $confidenceAB = ($data['count'] / $itemCounts[$item1]) * 100; 

//          // Menyaring hanya yang memiliki confidence ≥ 15%
//          if ($confidenceAB >= $FpConfidance) {
//              $filteredTwoItemsetWithConfidencemin[$pair] = [
//                  'item_pair' => $item1 . ',' . $item2,
//                  'frekuensi_A' => $itemCounts[$item1] ?? 0, 
//                  'frekuensi_A_&_B' => $data['count'], 
//                  'confidenceAB' => number_format($confidenceAB, 2) . '%' 
//              ];
//          }
//      }

//      // Hasil Aturan Asosiasi yang Terbentuk
//      $associationRules = [];
//      foreach ($HasilItemset2 as $pair => $data) {

//          $items = explode(", ", $pair);
//          $item1 = $items[0];
//          $item2 = $items[1];

//           // Menghitung Confidence untuk A → B
//          $supportItem1 = ($itemCounts[$item1] ?? 0) / $totalTransactions;
//          $supportBoth = ($data['count'] / $totalTransactions);
//          $confidenceAB = ($supportBoth / $supportItem1) * 100; 

//          if ($confidenceAB >= $FpConfidance || $confidenceAB >= $FpConfidance) {
//              $associationRules[] = [
//                  'pair' => "$item1, $item2",
//                  'support' => number_format(($data['count'] / $totalTransactions) * 100, 2) . '%', // Support A & B
//                  'confidence' => number_format($confidenceAB >= $FpConfidance ? $confidenceAB : $confidenceAB, 2) . '%'  // Menampilkan Confidence
//              ];
//          }
//      }


//     // Hanya Ambil Produk dengan Support ≥ 2%
//      $filteredItemsetPaginated = $this->filterHighSupportItems($itemCounts, $totalTransactions, 8);

    
//      $calonitemset = $datacalonitemset;
//      $Hasilitemsetone = $Itemset1;
//      $calonitemsettwo = $Itemset2;

//      $hasil2itemset = $HasilItemset2;
 

//      // dd(vars: $associationRules);

//     return Excel::download(new HasilAnalisisExport(
//         $calonitemset ,
//         $Hasilitemsetone, 
//         $calonitemsettwo, 
//         $HasilItemset2, 

//     $filteredItemsetPaginated, 
//     $filteredTwoItemsetWithConfidence, 
//     $filteredTwoItemsetWithConfidencemin, 
//     $associationRules
// ), 'laporan-hasil-analisis.xlsx');

// }

    


}
