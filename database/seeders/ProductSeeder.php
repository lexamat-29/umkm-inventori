<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = [
            [
                'name' => 'Beras Raja Lele 5kg',
                'sku' => 'BRS-RL-05',
                'description' => 'Beras Raja Lele kemasan 5 kilogram premium.',
                'harga_beli' => 60000,
                'harga_jual' => 65000,
                'stock_quantity' => 20,
                'is_active' => true,
            ],
            [
                'name' => 'Minyak Goreng Bimoli 1L',
                'sku' => 'MNY-BM-01',
                'description' => 'Minyak goreng Bimoli kemasan pouch 1 liter.',
                'harga_beli' => 18000,
                'harga_jual' => 20000,
                'stock_quantity' => 50,
                'is_active' => true,
            ],
            [
                'name' => 'Gula Pasir Gulaku 1kg',
                'sku' => 'GLA-GK-01',
                'description' => 'Gula pasir putih Gulaku kemasan 1 kg.',
                'harga_beli' => 14000,
                'harga_jual' => 16000,
                'stock_quantity' => 40,
                'is_active' => true,
            ],
            [
                'name' => 'Indomie Goreng Original',
                'sku' => 'IND-GR-01',
                'description' => 'Mie instan Indomie Goreng rasa original.',
                'harga_beli' => 2800,
                'harga_jual' => 3500,
                'stock_quantity' => 100,
                'is_active' => true,
            ],
            [
                'name' => 'Indomie Ayam Bawang',
                'sku' => 'IND-AB-01',
                'description' => 'Mie instan Indomie rasa Ayam Bawang.',
                'harga_beli' => 2700,
                'harga_jual' => 3200,
                'stock_quantity' => 100,
                'is_active' => true,
            ],
            [
                'name' => 'Telur Ayam Negeri (per kg)',
                'sku' => 'TLR-AY-01',
                'description' => 'Telur ayam negeri segar, harga per kilogram.',
                'harga_beli' => 26000,
                'harga_jual' => 28000,
                'stock_quantity' => 15,
                'is_active' => true,
            ],
            [
                'name' => 'Kopi Kapal Api Special 165g',
                'sku' => 'KPI-KA-01',
                'description' => 'Kopi bubuk Kapal Api Special kemasan 165 gram.',
                'harga_beli' => 13000,
                'harga_jual' => 15000,
                'stock_quantity' => 30,
                'is_active' => true,
            ],
            [
                'name' => 'Teh Sariwangi Isi 25',
                'sku' => 'TEH-SW-25',
                'description' => 'Teh celup Sariwangi isi 25 kantong.',
                'harga_beli' => 6500,
                'harga_jual' => 8000,
                'stock_quantity' => 40,
                'is_active' => true,
            ],
            [
                'name' => 'Sabun Mandi Lifebuoy Merah',
                'sku' => 'SBN-LB-RH',
                'description' => 'Sabun mandi batang Lifebuoy varian Total 10.',
                'harga_beli' => 3500,
                'harga_jual' => 5000,
                'stock_quantity' => 60,
                'is_active' => true,
            ],
            [
                'name' => 'Shampoo Sunsilk Hitam Sachet',
                'sku' => 'SHP-SS-BK',
                'description' => 'Shampoo Sunsilk Black Shine kemasan sachet (renceng).',
                'harga_beli' => 500, // per sachet modal roughly
                'harga_jual' => 1000,
                'stock_quantity' => 240, // 20 renceng approx
                'is_active' => true,
            ],
            [
                'name' => 'Deterjen Rinso Anti Noda 800g',
                'sku' => 'DET-RN-800',
                'description' => 'Deterjen Rinso Anti Noda kemasan 800 gram.',
                'harga_beli' => 22000,
                'harga_jual' => 25000,
                'stock_quantity' => 20,
                'is_active' => true,
            ],
            [
                'name' => 'Air Mineral Aqua 600ml',
                'sku' => 'AIR-AQ-600',
                'description' => 'Air mineral Aqua kemasan botol 600ml.',
                'harga_beli' => 3000,
                'harga_jual' => 4000,
                'stock_quantity' => 48, // 2 karton
                'is_active' => true,
            ],
            [
                'name' => 'Tepung Terigu Segitiga Biru 1kg',
                'sku' => 'TPG-SB-01',
                'description' => 'Tepung terigu serbaguna Segitiga Biru kemasan 1 kg.',
                'harga_beli' => 12000,
                'harga_jual' => 14000,
                'stock_quantity' => 25,
                'is_active' => true,
            ],
            [
                'name' => 'Kecap Manis Bango 550ml',
                'sku' => 'KCP-BG-550',
                'description' => 'Kecap manis Bango kemasan pouch 550ml.',
                'harga_beli' => 21000,
                'harga_jual' => 24000,
                'stock_quantity' => 20,
                'is_active' => true,
            ],
            [
                'name' => 'Saus Sambal ABC 335ml',
                'sku' => 'SOS-ABC-335',
                'description' => 'Saus sambal asli ABC kemasan botol 335ml.',
                'harga_beli' => 14000,
                'harga_jual' => 17000,
                'stock_quantity' => 15,
                'is_active' => true,
            ],
            [
                'name' => 'Garam Meja Refina 500g',
                'sku' => 'GRM-RF-500',
                'description' => 'Garam meja beryodium Refina kemasan 500 gram.',
                'harga_beli' => 8000,
                'harga_jual' => 10000,
                'stock_quantity' => 30,
                'is_active' => true,
            ],
            [
                'name' => 'Pasta Gigi Pepsodent 190g',
                'sku' => 'PG-PD-190',
                'description' => 'Pasta gigi Pepsodent Pencegah Gigi Berlubang 190 gram.',
                'harga_beli' => 14000,
                'harga_jual' => 17000,
                'stock_quantity' => 25,
                'is_active' => true,
            ],
            [
                'name' => 'Rokok Sampoerna Mild 16',
                'sku' => 'RKK-SM-16',
                'description' => 'Rokok Sampoerna A Mild isi 16 batang.',
                'harga_beli' => 28000,
                'harga_jual' => 30000,
                'stock_quantity' => 50,
                'is_active' => true,
            ],
            [
                'name' => 'Rokok Gudang Garam Filter 12',
                'sku' => 'RKK-GG-12',
                'description' => 'Rokok Gudang Garam International Filter isi 12 batang.',
                'harga_beli' => 23000,
                'harga_jual' => 25000,
                'stock_quantity' => 50,
                'is_active' => true,
            ],
            [
                'name' => 'Susu Kental Manis Frisian Flag Gold 370g',
                'sku' => 'SKM-FF-370',
                'description' => 'Susu kental manis Frisian Flag Gold kaleng 370 gram.',
                'harga_beli' => 16000,
                'harga_jual' => 19000,
                'stock_quantity' => 24,
                'is_active' => true,
            ],
        ];

        foreach ($products as $product) {
            Product::updateOrCreate(
                ['sku' => $product['sku']],
                array_merge($product, ['minimum_stock_threshold' => 10])
            );
        }
    }
}
