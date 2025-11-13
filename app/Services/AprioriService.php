<?php

namespace App\Services;

use App\Models\Project;
use App\Models\Rule;

class AprioriService
{
    protected $project;
    protected $transactions;
    protected $minSupport;
    protected $minConfidence;
    protected $totalTransactions;

    public function __construct(Project $project)
    {
        $this->project = $project;
        $this->minSupport = $project->min_support;
        $this->minConfidence = $project->min_confidence;
        $this->loadTransactions();
    }

    /**
     * Load transactions from database
     */
    protected function loadTransactions()
    {
        $this->transactions = $this->project->transactions()
            ->get()
            ->map(function ($transaction) {
                // Ensure items is decoded as array
                $items = $transaction->items;
                return is_string($items) ? json_decode($items, true) : $items;
            })
            ->toArray();
        
        $this->totalTransactions = count($this->transactions);
    }

    /**
     * Run the complete Apriori algorithm
     */
    public function runAnalysis()
    {
        // Clear existing rules
        $this->project->rules()->delete();

        // Step 1: Generate frequent itemsets
        $frequentItemsets = $this->generateFrequentItemsets();

        // Step 2: Generate association rules
        $rules = $this->generateRules($frequentItemsets);

        // Step 3: Save rules to database
        $this->saveRules($rules);

        return count($rules);
    }

    /**
     * Generate frequent itemsets using Apriori algorithm
     */
    protected function generateFrequentItemsets()
    {
        $frequentItemsets = [];
        
        // Get all unique items (1-itemsets)
        $items = $this->getAllItems();
        
        // Generate L1: frequent 1-itemsets
        $L1 = [];
        foreach ($items as $item) {
            $support = $this->calculateSupport([$item]);
            if ($support >= $this->minSupport) {
                $L1[] = [$item];
                $frequentItemsets[] = [
                    'itemset' => [$item],
                    'support' => $support
                ];
            }
        }

        // Generate Lk: frequent k-itemsets (k >= 2)
        $k = 2;
        $Lk_minus_1 = $L1;
        
        while (!empty($Lk_minus_1) && $k <= 10) { // Limit to 10-itemsets to prevent infinite loop
            $Ck = $this->generateCandidates($Lk_minus_1, $k);
            $Lk = [];
            
            foreach ($Ck as $candidate) {
                $support = $this->calculateSupport($candidate);
                if ($support >= $this->minSupport) {
                    $Lk[] = $candidate;
                    $frequentItemsets[] = [
                        'itemset' => $candidate,
                        'support' => $support
                    ];
                }
            }
            
            $Lk_minus_1 = $Lk;
            $k++;
        }

        return $frequentItemsets;
    }

    /**
     * Get all unique items from transactions
     */
    protected function getAllItems()
    {
        $allItems = [];
        foreach ($this->transactions as $transaction) {
            $allItems = array_merge($allItems, $transaction);
        }
        return array_unique($allItems);
    }

    /**
     * Calculate support for an itemset
     */
    protected function calculateSupport(array $itemset)
    {
        $count = 0;
        foreach ($this->transactions as $transaction) {
            if ($this->isSubset($itemset, $transaction)) {
                $count++;
            }
        }
        return $count / $this->totalTransactions;
    }

    /**
     * Check if itemset is subset of transaction
     */
    protected function isSubset(array $itemset, array $transaction)
    {
        foreach ($itemset as $item) {
            if (!in_array($item, $transaction)) {
                return false;
            }
        }
        return true;
    }

    /**
     * Generate candidate itemsets of size k
     */
    protected function generateCandidates(array $Lk_minus_1, int $k)
    {
        $candidates = [];
        $n = count($Lk_minus_1);

        for ($i = 0; $i < $n; $i++) {
            for ($j = $i + 1; $j < $n; $j++) {
                $candidate = array_unique(array_merge($Lk_minus_1[$i], $Lk_minus_1[$j]));
                sort($candidate);
                
                if (count($candidate) === $k) {
                    $candidateKey = implode(',', $candidate);
                    if (!isset($candidates[$candidateKey])) {
                        $candidates[$candidateKey] = $candidate;
                    }
                }
            }
        }

        return array_values($candidates);
    }

    /**
     * Generate association rules from frequent itemsets
     */
    protected function generateRules(array $frequentItemsets)
    {
        $rules = [];

        foreach ($frequentItemsets as $itemsetData) {
            $itemset = $itemsetData['itemset'];
            $itemsetSupport = $itemsetData['support'];

            // Only generate rules for itemsets with 2+ items
            if (count($itemset) < 2) {
                continue;
            }

            // Generate all non-empty subsets as antecedents
            $subsets = $this->generateSubsets($itemset);

            foreach ($subsets as $antecedent) {
                if (empty($antecedent) || count($antecedent) === count($itemset)) {
                    continue;
                }

                $consequent = array_values(array_diff($itemset, $antecedent));
                
                if (empty($consequent)) {
                    continue;
                }

                $antecedentSupport = $this->calculateSupport($antecedent);
                
                if ($antecedentSupport == 0) {
                    continue;
                }

                $confidence = $itemsetSupport / $antecedentSupport;

                if ($confidence >= $this->minConfidence) {
                    $consequentSupport = $this->calculateSupport($consequent);
                    $lift = ($consequentSupport > 0) 
                        ? $confidence / $consequentSupport 
                        : 0;

                    $rules[] = [
                        'antecedent' => array_values($antecedent),
                        'consequent' => $consequent,
                        'support' => $itemsetSupport,
                        'confidence' => $confidence,
                        'lift' => $lift
                    ];
                }
            }
        }

        return $rules;
    }

    /**
     * Generate all subsets of an array
     */
    protected function generateSubsets(array $set)
    {
        $subsets = [[]];
        
        foreach ($set as $element) {
            $currentSubsets = $subsets;
            foreach ($currentSubsets as $subset) {
                $subsets[] = array_merge($subset, [$element]);
            }
        }

        return $subsets;
    }

    /**
     * Save rules to database
     */
    protected function saveRules(array $rules)
    {
        foreach ($rules as $ruleData) {
            Rule::create([
                'project_id' => $this->project->id,
                'antecedent' => $ruleData['antecedent'],
                'consequent' => $ruleData['consequent'],
                'support' => $ruleData['support'],
                'confidence' => $ruleData['confidence'],
                'lift' => $ruleData['lift'],
            ]);
        }
    }
}
