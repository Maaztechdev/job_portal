<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
{
    public function create()
    {
        return view('employer.company.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('company_logos', 'public');
        }

        Company::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'logo' => $logoPath,
        ]);

        return redirect()->route('employer.dashboard')->with('success', 'Company profile created successfully.');
    }

    public function edit(Company $company)
    {
        if ($company->user_id !== Auth::id()) {
            abort(403);
        }
        return view('employer.company.edit', compact('company'));
    }

    public function update(Request $request, Company $company)
    {
        if ($company->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $logoPath = $company->logo;
        if ($request->hasFile('logo')) {
            if ($logoPath) {
                Storage::disk('public')->delete($logoPath);
            }
            $logoPath = $request->file('logo')->store('company_logos', 'public');
        }

        $company->update([
            'name' => $request->name,
            'logo' => $logoPath,
        ]);

        return redirect()->route('employer.dashboard')->with('success', 'Company profile updated successfully.');
    }
}
