<?php

namespace App\Imports;

use App\Models\Transaction;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TransactionsImport implements ToCollection, WithHeadingRow
{
    protected $projectId;
    protected $rowCount = 0;

    public function __construct($projectId)
    {
        $this->projectId = $projectId;
    }

    /**
     * @param Collection $rows
     */
    public function collection(Collection $rows)
    {
        // Group items by transaction_id
        $transactions = [];
        
        foreach ($rows as $row) {
            $transactionId = $row['transaction_id'] ?? null;
            $itemName = $row['item_name'] ?? null;
            
            if ($transactionId && $itemName) {
                if (!isset($transactions[$transactionId])) {
                    $transactions[$transactionId] = [];
                }
                $transactions[$transactionId][] = trim($itemName);
                $this->rowCount++;
            }
        }

        // Save grouped transactions
        foreach ($transactions as $transactionId => $items) {
            Transaction::create([
                'project_id' => $this->projectId,
                'transaction_id' => $transactionId,
                'items' => array_unique($items), // Remove duplicates
            ]);
        }
    }

    public function getRowCount(): int
    {
        return $this->rowCount;
    }
}
