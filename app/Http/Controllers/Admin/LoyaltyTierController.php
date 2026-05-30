<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LoyaltyTier;
use Illuminate\Http\Request;

class LoyaltyTierController extends Controller
{
    public function index()
    {
        $tiers = LoyaltyTier::orderBy('min_points', 'asc')->get();
        return view('admin.loyalty.tiers.index', compact('tiers'));
    }

    public function create()
    {
        return view('admin.loyalty.tiers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:loyalty_tiers',
            'min_points' => 'required|integer|min:0',
            'discount_percentage' => 'required|numeric|min:0|max:100',
            'color_hex' => 'required|string|max:7',
        ]);

        $perks = array_filter(array_map('trim', explode("\n", $request->perks_input)));

        LoyaltyTier::create([
            'name' => $request->name,
            'min_points' => $request->min_points,
            'discount_percentage' => $request->discount_percentage,
            'color_hex' => $request->color_hex,
            'perks' => $perks
        ]);

        return redirect()->route('admin.loyalty.tiers.index')
            ->with('success', 'Tier created successfully.');
    }

    public function edit(LoyaltyTier $tier)
    {
        return view('admin.loyalty.tiers.edit', compact('tier'));
    }

    public function update(Request $request, LoyaltyTier $tier)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'min_points' => 'required|integer|min:0',
            'discount_percentage' => 'required|numeric|min:0|max:100',
            'color_hex' => 'required|string|max:7',
            'perks' => 'nullable|array',
        ]);

        $tier->update($request->only('name', 'min_points', 'discount_percentage', 'color_hex', 'perks'));

        return redirect()->route('admin.loyalty.tiers.index')
            ->with('success', 'Tier updated.');
    }

    public function destroy(LoyaltyTier $tier)
    {
        $tier->delete();
        return redirect()->route('admin.loyalty.tiers.index')
            ->with('success', 'Tier removed.');
    }
}
