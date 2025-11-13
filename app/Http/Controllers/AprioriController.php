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
        
        $rules = $project->rules()
            ->orderBy('lift', 'desc')
            ->paginate(20);
        
        return view('apriori.results', compact('project', 'rules'));
    }
}
