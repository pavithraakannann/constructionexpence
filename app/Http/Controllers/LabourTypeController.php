<?php

namespace App\Http\Controllers;

use App\Models\LabourType;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LabourTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $labourTypes = LabourType::latest()->paginate(10);
        return view('labourtypes.index', compact('labourTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('labourtypes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:labour_types,name',
            'description' => 'nullable|string',
            'standard_rate' => 'required|numeric|min:0',
            'unit' => 'required|in:hour,day,week,month',
            'is_active' => 'boolean'
        ]);

        $validated['is_active'] = $request->has('is_active');

        LabourType::create($validated);

        return redirect()->route('labourtypes.index')
                        ->with('success', 'Labour type created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(LabourType $labourtype)
    {
        return view('labourtypes.show', compact('labourtype'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LabourType $labourtype)
    {
        return view('labourtypes.edit', compact('labourtype'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LabourType $labourtype)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:labour_types,name,' . $labourtype->id,
            'description' => 'nullable|string',
            'standard_rate' => 'required|numeric|min:0',
            'unit' => 'required|in:hour,day,week,month',
            'is_active' => 'boolean'
        ]);

        $validated['is_active'] = $request->has('is_active');

        $labourtype->update($validated);

        return redirect()->route('labourtypes.index')
                        ->with('success', 'Labour type updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LabourType $labourtype)
    {
        // Check if this labour type is being used anywhere before deleting
        if (method_exists($labourtype, 'labours') && $labourtype->labours()->exists()) {
            return redirect()->route('labourtypes.index')
                            ->with('error', 'Cannot delete labour type as it is being used in labour records.');
        }

        $labourtype->delete();

        return redirect()->route('labourtypes.index')
                        ->with('success', 'Labour type deleted successfully');
    }
}
