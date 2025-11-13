<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Dataset;
use App\Models\Transaction;
use App\Imports\TransactionsImport;
use App\Services\DummyDataService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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

    /**
     * Generate dummy transaction data for testing
     */
    public function generateDummyData(Project $project, DummyDataService $dummyDataService)
    {
        $this->authorize('update', $project);

        try {
            DB::beginTransaction();

            Log::info('Starting dummy data generation for project: ' . $project->id);

            // Generate dummy transactions
            $transactions = $dummyDataService->generateTransactions(250);
            Log::info('Generated ' . count($transactions) . ' transactions');
            
            // Save transactions to database
            $transactionCount = 0;
            foreach ($transactions as $transaction) {
                // Save as one row per transaction with items as JSON array
                Transaction::create([
                    'project_id' => $project->id,
                    'transaction_id' => $transaction['transaction_id'],
                    'items' => json_encode($transaction['items']), // Save all items as JSON
                ]);
                $transactionCount++;
            }

            Log::info('Saved ' . $transactionCount . ' transactions to database');

            // Create dataset record
            $dataset = Dataset::create([
                'project_id' => $project->id,
                'file_name' => 'Dummy Data - Generated at ' . now()->format('Y-m-d H:i:s'),
                'storage_path' => 'generated/dummy_data', // Set path for generated data
                'row_count' => $transactionCount,
                'imported_at' => now(),
            ]);

            Log::info('Created dataset record: ' . $dataset->id);

            DB::commit();

            return redirect()
                ->route('projects.show', $project)
                ->with('success', "Successfully generated {$transactionCount} dummy transactions with realistic retail products!");

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error generating dummy data: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            
            return back()
                ->withErrors(['error' => 'Error generating dummy data: ' . $e->getMessage()]);
        }
    }
}
