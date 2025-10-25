<?php

namespace App\Http\Controllers;

use App\Models\Advance;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdvanceController extends Controller
{
    public function index()
    {
        $advances = Advance::with('project')->latest()->paginate(10);
        return view('advances.index', compact('advances'));
    }

    public function create()
    {
        $projects = Project::all();
        return view('advances.create', compact('projects'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'project_id' => 'required|exists:projects,id',
            'amount_received' => 'required|numeric|min:0',
            'received_from' => 'nullable|string|max:255',
            'received_by' => 'nullable|string|max:255',
            'payment_mode' => 'required|in:Cash,Bank,Cheque,UPI,Other',
            'remarks' => 'nullable|string',
            'attachment' => 'nullable|file|max:2048|mimes:jpg,jpeg,png,pdf,doc,docx',
        ]);

        if ($request->hasFile('attachment')) {
            $path = $request->file('attachment')->store('advance_attachments', 'public');
            $validated['attachment'] = $path;
        }

        try {
            Advance::create($validated);
            return redirect()->route('advances.index')
                ->with('success', 'Advance record created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error creating advance record: ' . $e->getMessage());
        }
    }

    public function show(Advance $advance)
    {
        return view('advances.show', compact('advance'));
    }

    public function edit(Advance $advance)
    {
        $projects = Project::all();
        return view('advances.edit', compact('advance', 'projects'));
    }

    public function update(Request $request, Advance $advance)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'project_id' => 'required|exists:projects,id',
            'amount_received' => 'required|numeric|min:0',
            'received_from' => 'nullable|string|max:255',
            'received_by' => 'nullable|string|max:255',
            'payment_mode' => 'required|in:Cash,Bank,Cheque,UPI,Other',
            'remarks' => 'nullable|string',
            'attachment' => 'nullable|file|max:2048|mimes:jpg,jpeg,png,pdf,doc,docx',
        ]);

        if ($request->hasFile('attachment')) {
            // Delete old attachment if exists
            if ($advance->attachment) {
                Storage::disk('public')->delete($advance->attachment);
            }
            $path = $request->file('attachment')->store('advance_attachments', 'public');
            $validated['attachment'] = $path;
        }

        $advance->update($validated);

        return redirect()->route('advances.index')
            ->with('success', 'Advance record updated successfully.');
    }

    public function destroy(Advance $advance)
    {
        if ($advance->attachment) {
            Storage::disk('public')->delete($advance->attachment);
        }
        $advance->delete();

        return redirect()->route('advances.index')
            ->with('success', 'Advance record deleted successfully.');
    }
}