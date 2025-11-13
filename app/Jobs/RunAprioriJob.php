<?php

namespace App\Jobs;

use App\Models\Project;
use App\Services\AprioriService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class RunAprioriJob implements ShouldQueue
{
    use Queueable;

    protected $projectId;

    /**
     * Create a new job instance.
     */
    public function __construct(int $projectId)
    {
        $this->projectId = $projectId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $project = Project::findOrFail($this->projectId);
            
            // Update status to processing
            $project->update(['status' => 'processing']);
            
            // Run Apriori algorithm
            $apriori = new AprioriService($project);
            $rulesCount = $apriori->runAnalysis();
            
            // Update status to completed
            $project->update(['status' => 'completed']);
            
            Log::info("Apriori analysis completed for project {$project->id}. Generated {$rulesCount} rules.");
            
        } catch (\Exception $e) {
            // Update status to failed
            if (isset($project)) {
                $project->update(['status' => 'failed']);
            }
            
            Log::error("Apriori analysis failed for project {$this->projectId}: " . $e->getMessage());
            
            throw $e;
        }
    }
}
