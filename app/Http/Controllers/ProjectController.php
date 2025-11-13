<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ProjectController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = auth()->user()
            ->projects()
            ->withCount(['datasets', 'transactions', 'rules'])
            ->latest()
            ->paginate(10);
        
        return view('projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('projects.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'min_support' => 'required|numeric|min:0|max:1',
            'min_confidence' => 'required|numeric|min:0|max:1',
        ]);
        
        $project = auth()->user()->projects()->create($validated);
        
        return redirect()
            ->route('projects.show', $project)
            ->with('success', 'Project created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        $this->authorize('view', $project);
        
        $project->load([
            'datasets',
            'rules' => fn($q) => $q->orderBy('lift', 'desc')->take(10)
        ]);
        
        // Paginate transactions
        $transactions = $project->transactions()
            ->orderBy('transaction_id')
            ->paginate(20);
        
        return view('projects.show', compact('project', 'transactions'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        $this->authorize('update', $project);
        
        return view('projects.edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        $this->authorize('update', $project);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'min_support' => 'required|numeric|min:0|max:1',
            'min_confidence' => 'required|numeric|min:0|max:1',
        ]);
        
        $project->update($validated);
        
        return redirect()
            ->route('projects.show', $project)
            ->with('success', 'Project updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $this->authorize('delete', $project);
        
        $project->delete();
        
        return redirect()
            ->route('projects.index')
            ->with('success', 'Project deleted successfully!');
    }
}
