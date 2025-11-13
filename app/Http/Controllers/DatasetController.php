<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Dataset;
use App\Imports\TransactionsImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class DatasetController extends Controller
{
    use AuthorizesRequests;
    /**
     * Show the import form for a project
     */
    public function import(Project $project)
    {
        $this->authorize('view', $project);
        
        return view('datasets.import', compact('project'));
    }

    /**
     * Handle the file upload and import
     */
    public function store(Request $request, Project $project)
    {
        $this->authorize('update', $project);
        
        $request->validate([
            'file' => 'required|file|mimes:csv,xlsx,xls|max:10240', // Max 10MB
        ]);
        
        try {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $storagePath = $file->storeAs('datasets', $fileName, 'local');
            
            // Import the data
            $import = new TransactionsImport($project->id);
            Excel::import($import, $file);
            
            // Save dataset record
            $dataset = Dataset::create([
                'project_id' => $project->id,
                'file_name' => $file->getClientOriginalName(),
                'storage_path' => $storagePath,
                'row_count' => $import->getRowCount(),
                'imported_at' => now(),
            ]);
            
            return redirect()
                ->route('projects.show', $project)
                ->with('success', "Successfully imported {$import->getRowCount()} rows from {$file->getClientOriginalName()}");
                
        } catch (\Exception $e) {
            return back()
                ->withErrors(['file' => 'Error importing file: ' . $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Download sample CSV template
     */
    public function downloadTemplate()
    {
        $csv = "transaction_id,item_name\n";
        $csv .= "T001,Bread\n";
        $csv .= "T001,Milk\n";
        $csv .= "T001,Butter\n";
        $csv .= "T002,Bread\n";
        $csv .= "T002,Coffee\n";
        $csv .= "T003,Milk\n";
        $csv .= "T003,Butter\n";
        $csv .= "T003,Coffee\n";
        
        return response($csv)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="sales_data_template.csv"');
    }
}
