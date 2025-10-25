<?php

namespace App\Http\Controllers;

use App\Models\Labour;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LabourController extends Controller
{
    public function index()
    {
        $labours = Labour::with('project')->latest()->paginate(10);
        return view('labours.index', compact('labours'));
    }

    public function create()
    {
        $projects = Project::all();
        $labour = new Labour();
        $labourCategories = $labour->getLabourCategoryOptions();
        $paymentModes = $labour->getPaymentModeOptions();
        
        return view('labours.create', compact('projects', 'labourCategories', 'paymentModes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'project_id' => 'required|exists:projects,id',
            'labour_category' => 'required|string',
            'labour_name' => 'nullable|string|max:255',
            'num_workers' => 'required|integer|min:1',
            'wage_per_worker' => 'required|numeric|min:0',
            'payment_mode' => 'required|string',
            'remarks' => 'nullable|string',
            'attachment' => 'nullable|file|max:2048',
        ]);

        if ($request->hasFile('attachment')) {
            $path = $request->file('attachment')->store('labour_attachments', 'public');
            $validated['attachment'] = $path;
        }

        Labour::create($validated);
        return redirect()->route('labours.index')
            ->with('success', 'Labour record created successfully.');
    }

    public function show(Labour $labour)
    {
        return view('labours.show', compact('labour'));
    }

    public function edit(Labour $labour)
    {
        $projects = Project::all();
        $labourCategories = $labour->getLabourCategoryOptions();
        $paymentModes = $labour->getPaymentModeOptions();
        
        return view('labours.edit', compact('labour', 'projects', 'labourCategories', 'paymentModes'));
    }

    public function update(Request $request, Labour $labour)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'project_id' => 'required|exists:projects,id',
            'labour_category' => 'required|string',
            'labour_name' => 'nullable|string|max:255',
            'num_workers' => 'required|integer|min:1',
            'wage_per_worker' => 'required|numeric|min:0',
            'payment_mode' => 'required|string',
            'remarks' => 'nullable|string',
            'attachment' => 'nullable|file|max:2048',
        ]);

        if ($request->hasFile('attachment')) {
            // Delete old attachment if exists
            if ($labour->attachment) {
                Storage::disk('public')->delete($labour->attachment);
            }
            $path = $request->file('attachment')->store('labour_attachments', 'public');
            $validated['attachment'] = $path;
        }

        $labour->update($validated);
        return redirect()->route('labours.index')
            ->with('success', 'Labour record updated successfully.');
    }

    public function destroy(Labour $labour)
    {
        if ($labour->attachment) {
            Storage::disk('public')->delete($labour->attachment);
        }
        $labour->delete();
        return redirect()->route('labours.index')
            ->with('success', 'Labour record deleted successfully.');
    }
}