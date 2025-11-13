<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Jobs\RunAprioriJob;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class AprioriController extends Controller
{
    use AuthorizesRequests;
    /**
     * Run Apriori analysis for a project
     */
    public function analyze(Project $project)
    {
        $this->authorize('update', $project);
        
        // Check if project has transactions
        if ($project->transactions()->count() === 0) {
            return back()->withErrors(['error' => 'Please import data before running analysis.']);
        }
        
        // Check if already processing
        if ($project->status === 'processing') {
            return back()->withErrors(['error' => 'Analysis is already in progress.']);
        }
        
        // Dispatch job to queue
        RunAprioriJob::dispatch($project->id);
        
        return redirect()
            ->route('projects.show', $project)
            ->with('success', 'Apriori analysis started! This may take a few moments.');
    }

    /**
     * View analysis results
     */
    public function results(Project $project)
    {
        $this->authorize('view', $project);
        
        // Apply filters
        $query = $project->rules();
        
        // Sorting
        $sort = request('sort', 'lift_desc');
        switch ($sort) {
            case 'lift_asc':
                $query->orderBy('lift', 'asc');
                break;
            case 'confidence_desc':
                $query->orderBy('confidence', 'desc');
                break;
            case 'confidence_asc':
                $query->orderBy('confidence', 'asc');
                break;
            case 'support_desc':
                $query->orderBy('support', 'desc');
                break;
            case 'support_asc':
                $query->orderBy('support', 'asc');
                break;
            default: // lift_desc
                $query->orderBy('lift', 'desc');
        }
        
        // Min lift filter
        if (request('min_lift')) {
            $query->where('lift', '>=', request('min_lift'));
        }
        
        // Search filter
        if (request('search')) {
            $search = request('search');
            $query->where(function($q) use ($search) {
                $q->whereRaw("json_search(antecedent, 'one', ?) IS NOT NULL", ["%{$search}%"])
                  ->orWhereRaw("json_search(consequent, 'one', ?) IS NOT NULL", ["%{$search}%"]);
            });
        }
        
        $rules = $query->paginate(20)->withQueryString();
        
        // Prepare chart data
        $topRulesBySupport = $project->rules()
            ->orderBy('support', 'desc')
            ->limit(10)
            ->get()
            ->map(function($rule) {
                return [
                    'label' => implode(', ', $rule->antecedent) . ' → ' . implode(', ', $rule->consequent),
                    'support' => round($rule->support * 100, 2),
                    'confidence' => round($rule->confidence * 100, 2),
                    'lift' => round($rule->lift, 2)
                ];
            });
        
        // Scatter plot data (Confidence vs Lift)
        $scatterData = $project->rules()
            ->limit(100)
            ->get()
            ->map(function($rule) {
                return [
                    'x' => round($rule->confidence * 100, 2),
                    'y' => round($rule->lift, 2),
                    'label' => implode(', ', array_slice($rule->antecedent, 0, 2)) . ' → ' . implode(', ', array_slice($rule->consequent, 0, 2))
                ];
            });
        
        // Item frequency data for pie chart
        $itemFrequency = [];
        foreach ($project->rules as $rule) {
            foreach (array_merge($rule->antecedent, $rule->consequent) as $item) {
                if (!isset($itemFrequency[$item])) {
                    $itemFrequency[$item] = 0;
                }
                $itemFrequency[$item]++;
            }
        }
        arsort($itemFrequency);
        $topItems = array_slice($itemFrequency, 0, 10, true);
        
        $pieChartData = [
            'labels' => array_keys($topItems),
            'values' => array_values($topItems)
        ];
        
        return view('apriori.results', compact('project', 'rules', 'topRulesBySupport', 'scatterData', 'pieChartData'));
    }
}
