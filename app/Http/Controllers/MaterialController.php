<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Project;
use App\Models\MaterialType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MaterialController extends Controller
{
    public function index()
    {
        $materials = Material::with(['project', 'materialType'])->latest()->paginate(10);
        return view('materials.index', compact('materials'));
    }

    public function create()
    {
        $projects = Project::all(['id', 'name']);
        $materialTypes = MaterialType::all(['id', 'name', 'unit']);
        return view('materials.create', compact('projects', 'materialTypes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'material_type_id' => 'required|exists:material_types,id',
            'material_name' => 'required|string|max:255', // Changed from 'name' to 'material_name'
            'vendor_name' => 'required|string|max:255',
            'invoice_number' => 'nullable|string|max:100',
            'purchase_date' => 'required|date',
            'quantity' => 'required|numeric|min:0.01',
            'unit' => 'required|string|max:20',
            'unit_price' => 'required|numeric|min:0',
            'total_cost' => 'required|numeric|min:0',
            'payment_type' => 'required|in:Cash,Bank,UPI,Credit,Cheque,Other',
            'payment_notes' => 'nullable|string|max:500',
            'upload_bill' => 'nullable|file|max:10240|mimes:pdf,jpg,jpeg,png,xlsx,xls',
        ]);

        // Handle file upload if present
        $filePath = null;
        if ($request->hasFile('upload_bill')) {
            $file = $request->file('upload_bill');
            $fileName = Str::random(20) . '_' . time() . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('materials/bills', $fileName, 'public');
        }

        // Create material data array with correct field names
        $materialData = [
            'project_id' => $validated['project_id'],
            'material_type_id' => $validated['material_type_id'],
            'material_name' => $validated['material_name'], // Changed from 'name' to 'material_name'
            'vendor_name' => $validated['vendor_name'],
            'invoice_number' => $validated['invoice_number'],
            'purchase_date' => $validated['purchase_date'],
            'quantity' => $validated['quantity'],
            'unit' => $validated['unit'],
            'unit_price' => $validated['unit_price'],
            'total_cost' => $validated['total_cost'],
            'payment_type' => $validated['payment_type'],
            'payment_notes' => $validated['payment_notes'] ?? null,
        ];

        // Add file path if file was uploaded
        if (isset($filePath)) {
            $materialData['upload_bill'] = $filePath;
        }

        // Create material record
        $material = Material::create($materialData);

        return redirect()
            ->route('materials.index')
            ->with('success', 'Material added successfully!');
    }

    public function show(Material $material)
    {
        $material->load(['project', 'materialType']);
        return view('materials.show', compact('material'));
    }

    public function edit(Material $material)
    {
        $projects = Project::all(['id', 'name']);
        $materialTypes = MaterialType::all(['id', 'name', 'unit']);
        return view('materials.edit', compact('material', 'projects', 'materialTypes'));
    }

    public function update(Request $request, Material $material)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'material_type_id' => 'required|exists:material_types,id',
            'material_name' => 'required|string|max:255',
            'vendor_name' => 'required|string|max:255',
            'invoice_number' => 'nullable|string|max:100',
            'purchase_date' => 'required|date',
            'quantity' => 'required|numeric|min:0.01',
            'unit' => 'required|string|max:20',
            'unit_price' => 'required|numeric|min:0',
            'total_cost' => 'required|numeric|min:0',
            'payment_type' => 'required|in:Cash,Bank,UPI,Credit,Cheque,Other',
            'payment_notes' => 'nullable|string|max:500',
            'upload_bill' => 'nullable|file|max:10240|mimes:pdf,jpg,jpeg,png,xlsx,xls',
        ]);

        // Handle file upload if present
        if ($request->hasFile('upload_bill')) {
            // Delete old file if exists
            if ($material->upload_bill) {
                Storage::disk('public')->delete($material->upload_bill);
            }

            $file = $request->file('upload_bill');
            $fileName = Str::random(20) . '_' . time() . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('materials/bills', $fileName, 'public');
            $validated['upload_bill'] = $filePath;
        }

        $material->update([
            'project_id' => $validated['project_id'],
            'material_type_id' => $validated['material_type_id'],
            'name' => $validated['material_name'],
            'vendor_name' => $validated['vendor_name'],
            'invoice_number' => $validated['invoice_number'],
            'purchase_date' => $validated['purchase_date'],
            'quantity' => $validated['quantity'],
            'unit' => $validated['unit'],
            'unit_price' => $validated['unit_price'],
            'total_cost' => $validated['total_cost'],
            'payment_type' => $validated['payment_type'],
            'payment_notes' => $validated['payment_notes'] ?? null,
            'upload_bill' => $validated['upload_bill'] ?? $material->upload_bill,
        ]);

        return redirect()
            ->route('materials.index')
            ->with('success', 'Material updated successfully!');
    }

    public function destroy(Material $material)
    {
        // Delete associated file if exists
        if ($material->upload_bill) {
            Storage::disk('public')->delete($material->upload_bill);
        }

        $material->delete();

        return redirect()
            ->route('materials.index')
            ->with('success', 'Material deleted successfully!');
    }

    // public function downloadBill(Material $material)
    // {
    //     try {
    //         $filePath = $material->upload_bill;

    //         if (!$filePath) {
    //             return back()->with('error', 'No bill file associated with this record.');
    //         }

    //         // Normalize the path for Windows
    //         $filePath = str_replace('\\', '/', $filePath);

    //         // Check if file exists in storage
    //         if (!Storage::disk('public')->exists($filePath)) {
    //             // Try to find the file with a different path format
    //             $filePath = ltrim($filePath, '/\\');

    //             if (!Storage::disk('public')->exists($filePath)) {
    //                 return back()->with('error', 'Bill file not found at: ' . $filePath);
    //             }
    //         }

    //         // Get the original filename for download
    //         $originalName = basename($filePath);

    //         return Storage::disk('public')->download($filePath, $originalName, [
    //             'Content-Type' => Storage::disk('public')->mimeType($filePath),
    //             'Content-Disposition' => 'attachment; filename="' . $originalName . '"'
    //         ]);

    //     } catch (\Exception $e) {
    //         \Log::error('Error downloading file: ' . $e->getMessage());
    //         return back()->with('error', 'Error downloading file: ' . $e->getMessage());
    //     }
    // }
}
