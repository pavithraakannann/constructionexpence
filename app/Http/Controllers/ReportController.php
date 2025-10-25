<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Material;
use App\Models\Labour;
use App\Models\Advance;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function projectSummary()
    {
        $projects = Project::with(['materials', 'labours', 'advances'])->get();
        
        $projectSummaries = $projects->map(function($project) {
            $totalMaterialCost = $project->materials->sum(function($material) {
                return $material->quantity * $material->rate;
            });
            
            $totalLabourCost = $project->labours->sum(function($labour) {
                return $labour->quantity * $labour->rate;
            });
            
            $totalAdvance = $project->advances->sum('amount');
            $totalExpense = $totalMaterialCost + $totalLabourCost;
            $balance = $project->budget - $totalExpense;
            
            return [
                'project' => $project,
                'total_material_cost' => $totalMaterialCost,
                'total_labour_cost' => $totalLabourCost,
                'total_expense' => $totalExpense,
                'total_advance' => $totalAdvance,
                'balance' => $balance
            ];
        });
        
        return view('reports.summary', compact('projectSummaries'));
    }
    
    public function materialWise()
    {
        $materials = Material::with('project')
            ->selectRaw('name, unit, SUM(quantity) as total_quantity, AVG(rate) as avg_rate, SUM(quantity * rate) as total_cost')
            ->groupBy('name', 'unit')
            ->get();
            
        return view('reports.material-wise', compact('materials'));
    }
    
    public function daily()
    {
        $date = request('date', now()->format('Y-m-d'));
        
        $materials = Material::whereDate('date', $date)
            ->with('project')
            ->get();
            
        $labours = Labour::whereDate('date', $date)
            ->with('project')
            ->get();
            
        $advances = Advance::whereDate('date', $date)
            ->with('project')
            ->get();
            
        return view('reports.daily', compact('materials', 'labours', 'advances', 'date'));
    }
    
    public function advanceVsExpense()
    {
        $projects = Project::with(['advances', 'materials', 'labours'])->get();
        
        $data = $projects->map(function($project) {
            $totalMaterialCost = $project->materials->sum(function($material) {
                return $material->quantity * $material->rate;
            });
            
            $totalLabourCost = $project->labours->sum(function($labour) {
                return $labour->quantity * $labour->rate;
            });
            
            $totalExpense = $totalMaterialCost + $totalLabourCost;
            $totalAdvance = $project->advances->sum('amount');
            $difference = $totalAdvance - $totalExpense;
            
            return [
                'project' => $project->name,
                'total_advance' => $totalAdvance,
                'total_expense' => $totalExpense,
                'difference' => $difference
            ];
        });
        
        return view('reports.advance-vs-expense', compact('data'));
    }
    
    public function attachments()
    {
        // This would typically query a model that handles file attachments
        // For now, we'll return a simple view
        return view('reports.attachments');
    }
}
