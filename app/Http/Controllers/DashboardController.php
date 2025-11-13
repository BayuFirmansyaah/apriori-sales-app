<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        $stats = [
            'total_projects' => $user->projects()->count(),
            'completed_projects' => $user->projects()->where('status', 'completed')->count(),
            'processing_projects' => $user->projects()->where('status', 'processing')->count(),
            'total_rules' => $user->projects()
                ->withCount('rules')
                ->get()
                ->sum('rules_count'),
        ];
        
        $recentProjects = $user->projects()
            ->latest()
            ->take(5)
            ->withCount(['datasets', 'transactions', 'rules'])
            ->get();
        
        return view('dashboard', compact('stats', 'recentProjects'));
    }
}
