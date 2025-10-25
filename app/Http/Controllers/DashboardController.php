<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Material;
use App\Models\Labour;
use App\Models\Advance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // $stats = [
        //     'total_projects' => Project::count(),
        //     'total_materials' => Material::sum('quantity'),
        //     'total_labour' => Labour::count(),
        //     'total_advances' => Advance::sum('amount'),
        //     'recent_projects' => Project::latest()->take(5)->get(),
        //     'recent_materials' => Material::with('project')
        //         ->latest()
        //         ->take(5)
        //         ->get(),
        // ];

        return view('dashboard');
    }
}
