<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DataProdukSeeder extends Seeder
{
    public function run()
{
    DB::table('data_produk')->insert([
        ['kode_produk' => 'TC1', 'nama_produk' => 'Serum skintific'],
        ['kode_produk' => 'TC2', 'nama_produk' => 'Cream emina'],
        ['kode_produk' => 'TC3', 'nama_produk' => 'Sunscreen facetology'],
        ['kode_produk' => 'TC4', 'nama_produk' => 'Moisturizer skintific'],
        ['kode_produk' => 'TC5', 'nama_produk' => 'Day cream wardah'],
        ['kode_produk' => 'TC6', 'nama_produk' => 'Toner emina'],
        ['kode_produk' => 'TC7', 'nama_produk' => 'Micellarwater glod2glow'],
        ['kode_produk' => 'TC8', 'nama_produk' => 'Moisturizer the originote'],
        ['kode_produk' => 'TC9', 'nama_produk' => 'Serum hanasui'],
        ['kode_produk' => 'TC10', 'nama_produk' => 'Masker skintific'],
        ['kode_produk' => 'TC11', 'nama_produk' => 'Sunscreen emina'],
        ['kode_produk' => 'TC12', 'nama_produk' => 'Moisturizer glad2glow'],
        ['kode_produk' => 'TC13', 'nama_produk' => 'Night cream emina'],
        ['kode_produk' => 'TC14', 'nama_produk' => 'Serum wardah'],
        ['kode_produk' => 'TC15', 'nama_produk' => 'Facial wash skintific'],
        ['kode_produk' => 'TC16', 'nama_produk' => 'Night cream wardah'],
        ['kode_produk' => 'TC17', 'nama_produk' => 'Sunscreen garnier'],
        ['kode_produk' => 'TC18', 'nama_produk' => 'Face wash emina'],
        ['kode_produk' => 'TC19', 'nama_produk' => 'Serum the originote'],
        ['kode_produk' => 'TC20', 'nama_produk' => 'Micellarwater facetology'],
        ['kode_produk' => 'TC21', 'nama_produk' => 'Facial wash garnier'],
        ['kode_produk' => 'TC22', 'nama_produk' => 'Serum garnier'],
        ['kode_produk' => 'TC23', 'nama_produk' => 'Masker the originote'],
        ['kode_produk' => 'TC24', 'nama_produk' => 'Sunscreen azarine'],
        ['kode_produk' => 'TC25', 'nama_produk' => 'Toner glad2glow'],
        ['kode_produk' => 'TC26', 'nama_produk' => 'Micellarwater azarine'],
        ['kode_produk' => 'TC27', 'nama_produk' => 'Sunscreen wardah'],
        ['kode_produk' => 'TC28', 'nama_produk' => 'Toner wardah'],
        ['kode_produk' => 'TC29', 'nama_produk' => 'Masker glad2glow'],
        ['kode_produk' => 'TC30', 'nama_produk' => 'Day cream scarlett'],
        ['kode_produk' => 'TC31', 'nama_produk' => 'Night cream scarlett'],
        ['kode_produk' => 'TC32', 'nama_produk' => 'Facial wash scora'],
        ['kode_produk' => 'TC33', 'nama_produk' => 'Facial wash kahf'],
        ['kode_produk' => 'TC34', 'nama_produk' => 'Serum implora'],
        ['kode_produk' => 'TC35', 'nama_produk' => 'Facial wash scarlett'],
        ['kode_produk' => 'TC36', 'nama_produk' => 'Sunscreen the originote'],
        ['kode_produk' => 'TC37', 'nama_produk' => 'Sunscreen implora'],
        ['kode_produk' => 'TC38', 'nama_produk' => 'Serum temulawak'],
        ['kode_produk' => 'TC39', 'nama_produk' => 'Toner temulawak'],
        ['kode_produk' => 'TC40', 'nama_produk' => 'Night cream animate'],
        ['kode_produk' => 'TC41', 'nama_produk' => 'Facial wash animate'],
        ['kode_produk' => 'TC42', 'nama_produk' => 'Serum pond’s'],
        ['kode_produk' => 'TC43', 'nama_produk' => 'Micellarwater garnier'],
        ['kode_produk' => 'TC44', 'nama_produk' => 'Serum animate'],
        ['kode_produk' => 'TC45', 'nama_produk' => 'Micellarwater pond’s'],
        ['kode_produk' => 'TC46', 'nama_produk' => 'Day cream animate'],
        ['kode_produk' => 'TC47', 'nama_produk' => 'Toner animate'],
        ['kode_produk' => 'TC48', 'nama_produk' => 'Toner yeppu'],
        ['kode_produk' => 'TC49', 'nama_produk' => 'Sunscreen yeppu'],
        ['kode_produk' => 'TC50', 'nama_produk' => 'Facial wash kleveru'],
        ['kode_produk' => 'TC51', 'nama_produk' => 'Sunscreen amaterasun'],
        ['kode_produk' => 'TC52', 'nama_produk' => 'Cream bioaqua'],
        ['kode_produk' => 'TC53', 'nama_produk' => 'Toner scarlett'],
        ['kode_produk' => 'TC54', 'nama_produk' => 'Serum scarlett'],
        ['kode_produk' => 'TC55', 'nama_produk' => 'Facial wash facetology'],
        ['kode_produk' => 'TC56', 'nama_produk' => 'Facial wash pond’s'],
        ['kode_produk' => 'TC57', 'nama_produk' => 'Serum somethinc'],
        ['kode_produk' => 'TC58', 'nama_produk' => 'Serum kahf'],
        ['kode_produk' => 'TC59', 'nama_produk' => 'Toner azarine'],
        ['kode_produk' => 'TC60', 'nama_produk' => 'Night cream hanasui'],
        ['kode_produk' => 'TC61', 'nama_produk' => 'Day cream hanasui'],
        ['kode_produk' => 'TC62', 'nama_produk' => 'Facial wash the originote'],
        ['kode_produk' => 'TC63', 'nama_produk' => 'Sunscreen hanasui'],
        ['kode_produk' => 'TC64', 'nama_produk' => 'Moisturizer hanasui'],
        ['kode_produk' => 'TC65', 'nama_produk' => 'Moisturizer somethinc'],
        ['kode_produk' => 'TC66', 'nama_produk' => 'Micellarwater the originote'],
        ['kode_produk' => 'TC67', 'nama_produk' => 'Toner the originote'],
        ['kode_produk' => 'TC68', 'nama_produk' => 'Cream temulawak'],
        ['kode_produk' => 'TC69', 'nama_produk' => 'Toner skintific'],
        ['kode_produk' => 'TC70', 'nama_produk' => 'Facial wash wardah'],
        ['kode_produk' => 'TC71', 'nama_produk' => 'Day cream yeppu'],
        ['kode_produk' => 'TC72', 'nama_produk' => 'Night cream yeppu'],
        ['kode_produk' => 'TC73', 'nama_produk' => 'Masker azrina'],
        ['kode_produk' => 'TC74', 'nama_produk' => 'Moisturizer kahf'],
        ['kode_produk' => 'TC75', 'nama_produk' => 'Day cream garnier'],
        ['kode_produk' => 'TC76', 'nama_produk' => 'Night cream garnier'],
        ['kode_produk' => 'TC77', 'nama_produk' => 'Moisturizer azarine'],
        ['kode_produk' => 'TC78', 'nama_produk' => 'Facial wash azarine'],
        ['kode_produk' => 'TC79', 'nama_produk' => 'Night cream pond’s'],
        ['kode_produk' => 'TC80', 'nama_produk' => 'Day cream pond’s'],
        ['kode_produk' => 'TC81', 'nama_produk' => 'Facial wash bioaqua'],
        ['kode_produk' => 'TC82', 'nama_produk' => 'Facial wash hanasui'],
        ['kode_produk' => 'TC83', 'nama_produk' => 'Facial wash glad2glow'],
        ['kode_produk' => 'TC84', 'nama_produk' => 'Serum reglow'],
        ['kode_produk' => 'TC85', 'nama_produk' => 'Serum scora'],
        ['kode_produk' => 'TC86', 'nama_produk' => 'Moisturizer scora'],
        ['kode_produk' => 'TC87', 'nama_produk' => 'Toner bioaqua'],
        ['kode_produk' => 'TC88', 'nama_produk' => 'Sunscreen bioaqua'],
        ['kode_produk' => 'TC89', 'nama_produk' => 'Toner pond’s'],
        ['kode_produk' => 'TC90', 'nama_produk' => 'Toner reglow'],
        ['kode_produk' => 'TC91', 'nama_produk' => 'Facial wash reglow'],
        ['kode_produk' => 'TC92', 'nama_produk' => 'Tone up cream emina'],
        ['kode_produk' => 'TC93', 'nama_produk' => 'Day cream kleveru'],
        ['kode_produk' => 'TC94', 'nama_produk' => 'Night cream reglow'],
        ['kode_produk' => 'TC95', 'nama_produk' => 'Micellarwater reglow'],
        ['kode_produk' => 'TC96', 'nama_produk' => 'Moisturizer dorskin'],
        ['kode_produk' => 'TC97', 'nama_produk' => 'Facial wash dorskin'],
        ['kode_produk' => 'TC98', 'nama_produk' => 'Toner kleveru'],
        ['kode_produk' => 'TC99', 'nama_produk' => 'Day cream reglow'],
        ['kode_produk' => 'TC100', 'nama_produk' => 'Facial wash avoskin'],
        ['kode_produk' => 'TC101', 'nama_produk' => 'Serum kleveru'],
        ['kode_produk' => 'TC102', 'nama_produk' => 'Night cream avoskin'],
        ['kode_produk' => 'TC103', 'nama_produk' => 'Toner implora'],
        ['kode_produk' => 'TC104', 'nama_produk' => 'Facial wash somethinc'],
        ['kode_produk' => 'TC105', 'nama_produk' => 'Micellarwater somethinc'],
        ['kode_produk' => 'TC106', 'nama_produk' => 'Night cream kleveru'],
        ['kode_produk' => 'TC107', 'nama_produk' => 'Toner avoskin'],
        ['kode_produk' => 'TC108', 'nama_produk' => 'Moisturizer implora'],
        ['kode_produk' => 'TC109', 'nama_produk' => 'Day cream avoskin'],
        ['kode_produk' => 'TC110', 'nama_produk' => 'Moisturizer citra'],
        ['kode_produk' => 'TC111', 'nama_produk' => 'Moisturizer avoskin'],
        ['kode_produk' => 'TC112', 'nama_produk' => 'Facial wash citra'],
        ['kode_produk' => 'TC113', 'nama_produk' => 'Serum avoskin'],
        ['kode_produk' => 'TC114', 'nama_produk' => 'Micellarwater emina'],
        ['kode_produk' => 'TC115', 'nama_produk' => 'Micellarwater wardah'],
        ['kode_produk' => 'TC116', 'nama_produk' => 'Serum emina'],
    ]);
}

}
