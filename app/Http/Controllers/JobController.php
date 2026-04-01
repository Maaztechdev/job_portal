<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{
    public function index(Request $request)
    {
        $query = Job::with('employer')->latest();

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('location')) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $jobs = $query->paginate(10);
        return view('jobs.index', compact('jobs'));
    }

    public function show(Job $job)
    {
        $job->load('employer');
        return view('jobs.show', compact('job'));
    }

    public function create()
    {
        return view('employer.jobs.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'salary' => 'nullable|string|max:255',
            'type' => 'required|in:full-time,part-time,remote',
        ]);

        $validated['employer_id'] = Auth::id();

        Job::create($validated);

        return redirect()->route('employer.dashboard')->with('success', 'Job posted successfully.');
    }

    public function edit(Job $job)
    {
        if ($job->employer_id !== Auth::id()) {
            abort(403);
        }
        return view('employer.jobs.edit', compact('job'));
    }

    public function update(Request $request, Job $job)
    {
        if ($job->employer_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'salary' => 'nullable|string|max:255',
            'type' => 'required|in:full-time,part-time,remote',
        ]);

        $job->update($validated);

        return redirect()->route('employer.dashboard')->with('success', 'Job updated successfully.');
    }

    public function destroy(Job $job)
    {
        if ($job->employer_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403);
        }

        $job->delete();

        return back()->with('success', 'Job deleted successfully.');
    }
}
