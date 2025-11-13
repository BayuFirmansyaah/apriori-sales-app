<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class DummyDataService
{
    /**
     * Array of retail products categorized by type
     */
    private array $products = [
        'beverages' => [
            'Coca Cola', 'Pepsi', 'Sprite', 'Fanta', 'Aqua', 'Teh Botol Sosro',
            'Fruit Tea', 'Pocari Sweat', 'Mizone', 'Le Minerale'
        ],
        'snacks' => [
            'Chitato', 'Cheetos', 'Lays', 'Taro', 'Koko Krunch', 'Oreo',
            'Good Time', 'Biskuat', 'Roma Kelapa', 'Better'
        ],
        'dairy' => [
            'Susu Ultra', 'Susu Indomilk', 'Susu Frisian Flag', 'Yogurt Cimory',
            'Keju Kraft', 'Butter', 'Yakult', 'Susu Kental Manis'
        ],
        'instant_food' => [
            'Indomie Goreng', 'Indomie Soto', 'Mie Sedaap', 'Pop Mie', 
            'Instant Cereal', 'Roti Tawar', 'Roti Isi', 'Donat'
        ],
        'household' => [
            'Shampoo', 'Sabun Mandi', 'Pasta Gigi', 'Sikat Gigi', 'Deterjen',
            'Pelembut Pakaian', 'Tissue', 'Sabun Cuci Piring'
        ],
        'staples' => [
            'Beras 5kg', 'Gula Pasir', 'Minyak Goreng', 'Telur 1kg', 
            'Tepung Terigu', 'Garam', 'Kecap', 'Saus Sambal'
        ],
        'personal_care' => [
            'Bedak', 'Lotion', 'Deodorant', 'Sabun Wajah', 'Shampoo Bayi',
            'Pampers', 'Handuk Kecil', 'Cotton Buds'
        ]
    ];

    /**
     * Common product combinations that frequently bought together
     */
    private array $commonCombinations = [
        ['Indomie Goreng', 'Telur 1kg'],
        ['Susu Ultra', 'Koko Krunch'],
        ['Roti Tawar', 'Susu Kental Manis'],
        ['Shampoo', 'Sabun Mandi'],
        ['Coca Cola', 'Chitato'],
        ['Deterjen', 'Pelembut Pakaian'],
        ['Kopi', 'Gula Pasir'],
        ['Teh Botol Sosro', 'Indomie Goreng'],
        ['Minyak Goreng', 'Beras 5kg'],
        ['Pasta Gigi', 'Sikat Gigi'],
        ['Susu Frisian Flag', 'Oreo'],
        ['Pepsi', 'Lays'],
        ['Shampoo Bayi', 'Pampers'],
        ['Roti Isi', 'Aqua'],
        ['Sabun Cuci Piring', 'Tissue']
    ];

    /**
     * Generate realistic dummy transaction data
     * 
     * @param int $transactionCount Number of transactions to generate
     * @return array Array of transactions with transaction_id and items
     */
    public function generateTransactions(int $transactionCount = 250): array
    {
        $transactions = [];
        $allProducts = $this->getAllProducts();

        for ($i = 1; $i <= $transactionCount; $i++) {
            $itemCount = rand(1, 8); // 1 to 8 items per transaction
            $items = [];

            // 40% chance to use common combination
            if (rand(1, 100) <= 40 && count($this->commonCombinations) > 0) {
                $combination = $this->commonCombinations[array_rand($this->commonCombinations)];
                $items = array_merge($items, $combination);
                $itemCount = max(0, $itemCount - count($combination));
            }

            // Add random items
            for ($j = 0; $j < $itemCount; $j++) {
                $randomProduct = $allProducts[array_rand($allProducts)];
                
                // Avoid duplicates in same transaction
                if (!in_array($randomProduct, $items)) {
                    $items[] = $randomProduct;
                }
            }

            $transactions[] = [
                'transaction_id' => 'TRX' . str_pad($i, 6, '0', STR_PAD_LEFT),
                'items' => array_unique($items)
            ];
        }

        return $transactions;
    }

    /**
     * Get all products as flat array
     * 
     * @return array
     */
    private function getAllProducts(): array
    {
        $allProducts = [];
        foreach ($this->products as $category => $products) {
            $allProducts = array_merge($allProducts, $products);
        }
        return $allProducts;
    }

    /**
     * Get product statistics
     * 
     * @return array
     */
    public function getProductStats(): array
    {
        $totalProducts = 0;
        $stats = [];
        
        foreach ($this->products as $category => $products) {
            $count = count($products);
            $totalProducts += $count;
            $stats[$category] = $count;
        }

        return [
            'total_products' => $totalProducts,
            'categories' => $stats,
            'common_combinations' => count($this->commonCombinations)
        ];
    }
}
