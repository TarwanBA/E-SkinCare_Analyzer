<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class HasilAnalisisExport implements WithMultipleSheets
{
    protected $calonitemset;
    protected $Hasilitemsetone;
    protected $calonitemsettwo;
    protected $filteredTwoItemset;
    protected $twoItemSetsPaginated;
   
    
    protected $filteredTwoItemsetWithConfidence;
    protected $filteredTwoItemsetWithConfidencemin;
    protected $associationRules;

    public function __construct(
        $calonitemset,
        $Hasilitemsetone, 
        $calonitemsettwo,
        $filteredTwoItemset, 

        $twoItemSetsPaginated,        
        $filteredTwoItemsetWithConfidence, 
        $filteredTwoItemsetWithConfidencemin, 
        $associationRules
    ) {
        $this->calonitemset = $calonitemset;
        $this->Hasilitemsetone = $Hasilitemsetone;
        $this->calonitemsettwo = $calonitemsettwo;
        $this->filteredTwoItemset = $filteredTwoItemset;

        $this->twoItemSetsPaginated = $twoItemSetsPaginated;
        $this->filteredTwoItemsetWithConfidence = $filteredTwoItemsetWithConfidence;
        $this->filteredTwoItemsetWithConfidencemin = $filteredTwoItemsetWithConfidencemin;
        $this->associationRules = $associationRules;
    }

    public function sheets(): array
    {
        return [
            new SheetExport($this->calonitemset, ['Produk', 'Frekuensi', 'Support'], 'Calon Itemset'),
            new SheetExport($this->Hasilitemsetone, ['Produk', 'Frekuensi', 'Support'], 'Hasil Itemset 1'),
            new SheetExport($this->calonitemsettwo, ['Produk', 'Frekuensi', 'Support'], 'Calon Itemset 2'),
            new SheetExport($this->filteredTwoItemset, ['Produk', 'Frekuensi', 'Support'], 'Hasil Itemset 2'),
            new SheetExport($this->filteredTwoItemsetWithConfidence, ['Pola 2-Itemset', 'Frekuensi A', 'Frekuensi A&B', 'Confidence'], 'Hasil Confidence'),
            new SheetExport($this->filteredTwoItemsetWithConfidencemin, ['Pola 2-Itemset', 'Frekuensi A', 'Frekuensi A&B', 'Confidence'], 'Hasil Min Confidence'),
            new SheetExport($this->associationRules, ['Aturan', 'Support', 'Confidence'], 'Aturan Asosiasi'),
       
        ];
    }
}
