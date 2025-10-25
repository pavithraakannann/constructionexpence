<?php

namespace App\Http\Controllers;

use App\Models\MaterialType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class MaterialTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $materialTypes = MaterialType::latest()->get();
        
        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => $materialTypes
            ]);
        }
        
        return view('materialtypes.index', compact('materialTypes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:material_types,name',
            'description' => 'nullable|string',
            'unit' => 'required|string|max:50',
            'is_active' => 'boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $materialType = MaterialType::create([
                'name' => $request->name,
                'description' => $request->description,
                'unit' => $request->unit,
                'is_active' => $request->has('is_active') ? $request->is_active : true
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Material type created successfully',
                'data' => $materialType
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create material type',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            $materialType = MaterialType::findOrFail($id);
            return response()->json([
                'success' => true,
                'data' => $materialType
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Material type not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $materialType = MaterialType::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('material_types', 'name')->ignore($materialType->id)
            ],
            'description' => 'nullable|string',
            'unit' => 'required|string|max:50',
            'is_active' => 'boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $materialType->update([
                'name' => $request->name,
                'description' => $request->description,
                'unit' => $request->unit,
                'is_active' => $request->has('is_active') ? $request->is_active : $materialType->is_active
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Material type updated successfully',
                'data' => $materialType
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update material type',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            $materialType = MaterialType::findOrFail($id);
            
            // Check if material type is being used by any materials
            if ($materialType->materials()->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete material type because it is being used by one or more materials.'
                ], 422);
            }

            $materialType->delete();

            return response()->json([
                'success' => true,
                'message' => 'Material type deleted successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete material type',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
