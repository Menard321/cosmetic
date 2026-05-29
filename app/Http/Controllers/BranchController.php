<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Branch;

class BranchController extends Controller
{
    public function index()
    {
        $branches = Branch::where('is_active', true)->get();
        return view('branches.index', compact('branches'));
    }

    public function show(Branch $branch)
    {
        // For now, redirect to switch to make it active, then show branch-specific products
        session(['active_branch_id' => $branch->id]);
        session(['active_branch_name' => $branch->name]);
        session(['active_branch_slug' => $branch->slug]);

        return view('branches.show', compact('branch'));
    }

    public function switch(Branch $branch)
    {
        session(['active_branch_id' => $branch->id]);
        session(['active_branch_name' => $branch->name]);
        session(['active_branch_slug' => $branch->slug]);

        return back()->with('success', "Switched to {$branch->name}");
    }
}
