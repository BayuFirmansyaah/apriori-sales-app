<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ReportController extends Controller
{
    use AuthorizesRequests;
    
    /**
     * Download PDF report for a project
     */
    public function downloadPdf(Project $project)
    {
        $this->authorize('view', $project);
        
        // Get all rules sorted by lift
        $rules = $project->rules()
            ->orderBy('lift', 'desc')
            ->get();
        
        // Calculate statistics
        $stats = [
            'total_rules' => $rules->count(),
            'total_transactions' => $project->transactions->count(),
            'total_datasets' => $project->datasets->count(),
            'avg_support' => $rules->avg('support'),
            'avg_confidence' => $rules->avg('confidence'),
            'avg_lift' => $rules->avg('lift'),
            'max_lift' => $rules->max('lift'),
            'min_lift' => $rules->min('lift'),
            'strong_rules' => $rules->where('lift', '>', 1)->where('confidence', '>', 0.7)->count(),
        ];
        
        // Top 10 rules by support for chart
        $topRulesBySupport = $rules->sortByDesc('support')->take(10)->map(function($rule) {
            return [
                'label' => implode(', ', array_slice($rule->antecedent, 0, 2)) . ' → ' . implode(', ', array_slice($rule->consequent, 0, 2)),
                'support' => round($rule->support * 100, 2),
                'confidence' => round($rule->confidence * 100, 2),
                'lift' => round($rule->lift, 2)
            ];
        });
        
        // Top 5 strongest rules (by lift)
        $topRules = $rules->take(5);
        
        // Item frequency for pie chart
        $itemFrequency = [];
        foreach ($rules as $rule) {
            foreach (array_merge($rule->antecedent, $rule->consequent) as $item) {
                if (!isset($itemFrequency[$item])) {
                    $itemFrequency[$item] = 0;
                }
                $itemFrequency[$item]++;
            }
        }
        arsort($itemFrequency);
        $topItems = array_slice($itemFrequency, 0, 10, true);
        
        // Confidence vs Lift data (sample 30 for visibility)
        $scatterData = $rules->take(30)->map(function($rule) {
            return [
                'confidence' => round($rule->confidence * 100, 2),
                'lift' => round($rule->lift, 2),
            ];
        });
        
        // Key insights
        $insights = $this->generateInsights($rules, $stats);
        
        // Generate PDF
        $pdf = Pdf::loadView('reports.pdf', compact(
            'project',
            'rules',
            'stats',
            'topRulesBySupport',
            'topRules',
            'topItems',
            'scatterData',
            'insights'
        ));
        
        $pdf->setPaper('a4', 'portrait');
        
        $fileName = str_replace(' ', '_', $project->name) . '_analysis_report_' . now()->format('Y-m-d') . '.pdf';
        
        return $pdf->download($fileName);
    }
    
    /**
     * Generate insights from rules data
     */
    private function generateInsights($rules, $stats)
    {
        $insights = [];
        
        // Insight 1: Overall quality
        if ($stats['avg_lift'] > 1.5) {
            $insights[] = [
                'type' => 'success',
                'title' => 'Strong Associations Detected',
                'description' => "Average lift of {$stats['avg_lift']}x indicates strong positive correlations between items. This is excellent for cross-selling strategies."
            ];
        } elseif ($stats['avg_lift'] > 1) {
            $insights[] = [
                'type' => 'info',
                'title' => 'Moderate Associations Found',
                'description' => "Average lift of {$stats['avg_lift']}x shows moderate positive correlations. Focus on rules with lift > 1.5 for best results."
            ];
        } else {
            $insights[] = [
                'type' => 'warning',
                'title' => 'Weak Associations',
                'description' => "Average lift of {$stats['avg_lift']}x suggests weak correlations. Consider adjusting min_support and min_confidence parameters."
            ];
        }
        
        // Insight 2: Data coverage
        $coverage_pct = ($stats['avg_support'] * 100);
        if ($coverage_pct > 10) {
            $insights[] = [
                'type' => 'success',
                'title' => 'Good Data Coverage',
                'description' => "Average support of {$coverage_pct}% indicates patterns occur frequently across transactions."
            ];
        } else {
            $insights[] = [
                'type' => 'info',
                'title' => 'Niche Patterns',
                'description' => "Average support of {$coverage_pct}% suggests specialized patterns. These may be valuable for targeted marketing."
            ];
        }
        
        // Insight 3: Reliability
        $confidence_pct = ($stats['avg_confidence'] * 100);
        if ($confidence_pct > 80) {
            $insights[] = [
                'type' => 'success',
                'title' => 'High Reliability Rules',
                'description' => "Average confidence of {$confidence_pct}% means rules are highly reliable for predictions."
            ];
        }
        
        // Insight 4: Actionable rules
        $actionable_pct = ($stats['strong_rules'] / max($stats['total_rules'], 1)) * 100;
        $insights[] = [
            'type' => 'info',
            'title' => 'Actionable Rules',
            'description' => "{$stats['strong_rules']} rules ({$actionable_pct}%) are strong enough (Lift > 1, Confidence > 70%) for immediate business action."
        ];
        
        return $insights;
    }
}
