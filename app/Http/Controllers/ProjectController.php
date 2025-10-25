<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        try {
            $projects = Project::latest()->paginate(10);
            return view('projects.index', compact('projects'));
        } catch (\Exception $e) {
            // Return empty paginated collection with 0 items per page
            $projects = Project::where('id', '<', 0)->paginate(10);
            return view('projects.index', compact('projects'))->with('error', 'No projects found. Please create your first project.');
        }
    }

    public function create()
    {
        return view('projects.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'budget' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'contact_name' => 'nullable|string|max:255',
            'contact_mobile' => ['nullable', 'string', 'regex:/^[0-9]{10}$/'],
            'reference_name' => 'nullable|string|max:255',
        ]);

        try {
            Project::create($validated);
            return redirect()
                ->route('projects.index')
                ->with('success', 'Project created successfully!');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Error creating project: ' . $e->getMessage());
        }
    }

    public function show(Project $project)
    {
        try {
            // Eager load relationships with ordering
            $project->load([
                'labours' => function($query) {
                    $query->latest('date');
                },
                'materials' => function($query) {
                    $query->with('materialType')
                          ->latest('purchase_date');
                },
                'advances' => function($query) {
                    $query->latest('date');
                }
            ]);

            // Calculate totals
            $labourTotal = $project->totalLabourCost();
            $materialTotal = $project->totalMaterialCost();
            $advanceTotal = $project->totalAdvanceReceived();
            $totalExpenses = $project->totalExpenses();
            $remainingBudget = $project->remainingBudget();
            $budgetUtilization = $project->budget > 0 ? 
                min(100, round(($totalExpenses / $project->budget) * 100, 2)) : 0;

            return view('projects.view', compact(
                'project',
                'labourTotal',
                'materialTotal',
                'advanceTotal',
                'totalExpenses',
                'remainingBudget',
                'budgetUtilization'
            ));
        } catch (\Exception $e) {
            return redirect()->route('projects.index')
                ->with('error', 'Error loading project details: ' . $e->getMessage());
        }
    }

    public function edit(Project $project)
    {
        return view('projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'budget' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        $project->update($validated);
        return redirect()->route('projects.index')->with('success', 'Project updated successfully.');
    }

    public function destroy(Project $project)
    {
        $project->delete();
        return redirect()->route('projects.index')->with('success', 'Project deleted successfully.');
    }
}
