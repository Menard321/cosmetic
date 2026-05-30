<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LoyaltyCampaign;
use App\Models\Category;
use Illuminate\Http\Request;

class LoyaltyCampaignController extends Controller
{
    public function index()
    {
        $campaigns = LoyaltyCampaign::with('category')->orderBy('created_at', 'desc')->get();
        return view('admin.loyalty.campaigns.index', compact('campaigns'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.loyalty.campaigns.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'multiplier' => 'required|numeric|min:1|max:10',
            'starts_at' => 'required|date',
            'ends_at' => 'required|date|after:starts_at',
        ]);

        LoyaltyCampaign::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'multiplier' => $request->multiplier,
            'starts_at' => $request->starts_at,
            'ends_at' => $request->ends_at,
            'is_active' => true,
        ]);

        return redirect()->route('admin.loyalty.campaigns.index')
            ->with('success', 'Campaign launched successfully.');
    }

    public function edit(LoyaltyCampaign $campaign)
    {
        $categories = Category::all();
        return view('admin.loyalty.campaigns.edit', compact('campaign', 'categories'));
    }

    public function update(Request $request, LoyaltyCampaign $campaign)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'multiplier' => 'required|numeric|min:1|max:10',
            'starts_at' => 'required|date',
            'ends_at' => 'required|date|after:starts_at',
            'is_active' => 'boolean',
        ]);

        $campaign->update($request->only('name', 'category_id', 'multiplier', 'starts_at', 'ends_at', 'is_active'));

        return redirect()->route('admin.loyalty.campaigns.index')
            ->with('success', 'Campaign updated.');
    }

    public function destroy(LoyaltyCampaign $campaign)
    {
        $campaign->delete();
        return redirect()->route('admin.loyalty.campaigns.index')
            ->with('success', 'Campaign terminated.');
    }
}
