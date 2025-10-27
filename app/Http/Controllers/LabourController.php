<?php

namespace App\Http\Controllers;

use App\Models\Labour;
use App\Models\Project;
use App\Models\LabourType;
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
        $labourTypes = LabourType::where('is_active', true)->orderBy('name')->get();
        $paymentModes = (new Labour())->getPaymentModeOptions();
        
        return view('labours.create', compact('projects', 'labourTypes', 'paymentModes'));
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
            'attachments.*' => 'nullable|file|max:2048',
        ]);

        // Get the labour type to get the standard rate
        $labourType = LabourType::findOrFail($validated['labour_category']);
        
        // Create the labour record
        $labour = Labour::create([
            'date' => $validated['date'],
            'project_id' => $validated['project_id'],
            'labour_type_id' => $labourType->id,
            'labour_name' => $validated['labour_name'] ?? null,
            'num_workers' => $validated['num_workers'],
            'wage_per_worker' => $validated['wage_per_worker'],
            'payment_mode' => $validated['payment_mode'],
            'remarks' => $validated['remarks'] ?? null,
        ]);

        // Handle file uploads
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                if ($file->isValid()) {
                    $path = $file->store('labour_attachments/' . date('Y/m/d'), 'public');
                    
                    $labour->attachments()->create([
                        'file_path' => $path,
                        'file_name' => $file->getClientOriginalName(),
                        'file_type' => $file->getClientMimeType(),
                        'file_size' => $file->getSize(),
                    ]);
                }
            }
        }

        return redirect()->route('labours.index')
            ->with('success', 'Labour record created successfully.');
    }

    public function show(Labour $labour)
    {
        $labour->load(['project', 'labourType', 'attachments']);
        return view('labours.view', compact('labour'));
    }

    public function edit(Labour $labour)
    {
        $projects = Project::all();
        $labourTypes = LabourType::where('is_active', true)->orderBy('name')->get();
        $paymentModes = (new Labour())->getPaymentModeOptions();
        
        return view('labours.edit', compact('labour', 'projects', 'labourTypes', 'paymentModes'));
    }

    public function update(Request $request, Labour $labour)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'project_id' => 'required|exists:projects,id',
            'labour_category' => 'required|exists:labour_types,id',
            'labour_name' => 'nullable|string|max:255',
            'num_workers' => 'required|integer|min:1',
            'wage_per_worker' => 'required|numeric|min:0',
            'payment_mode' => 'required|string',
            'remarks' => 'nullable|string',
            'attachments.*' => 'nullable|file|max:2048',
        ]);

        // Get the labour type
        $labourType = LabourType::findOrFail($validated['labour_category']);
        
        // Update the labour record with the labour type ID
        $labour->update([
            'date' => $validated['date'],
            'project_id' => $validated['project_id'],
            'labour_type_id' => $labourType->id,
            'labour_name' => $validated['labour_name'] ?? null,
            'num_workers' => $validated['num_workers'],
            'wage_per_worker' => $validated['wage_per_worker'],
            'payment_mode' => $validated['payment_mode'],
            'remarks' => $validated['remarks'] ?? null,
        ]);

        // Handle new file uploads
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                if ($file->isValid()) {
                    $path = $file->store('labour_attachments/' . date('Y/m/d'), 'public');
                    
                    $labour->attachments()->create([
                        'file_path' => $path,
                        'file_name' => $file->getClientOriginalName(),
                        'file_type' => $file->getClientMimeType(),
                        'file_size' => $file->getSize(),
                    ]);
                }
            }
        }
        return redirect()->route('labours.index')
            ->with('success', 'Labour record updated successfully.');
    }

    public function destroy(Labour $labour)
    {
        $labour->delete();
        return redirect()->route('labours.index')
            ->with('success', 'Labour record deleted successfully.');
    }

    /**
     * Remove the specified attachment from storage.
     */
    public function destroyAttachment($attachmentId)
    {
        try {
            $attachment = \App\Models\LabourAttachment::findOrFail($attachmentId);
            
            // Delete the file from storage
            if (\Storage::disk('public')->exists($attachment->file_path)) {
                \Storage::disk('public')->delete($attachment->file_path);
            }
            
            // Delete the attachment record
            $attachment->delete();
            
            return response()->json(['success' => true]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete attachment.'
            ], 500);
        }
    }
}