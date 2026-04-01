<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Application;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApplicationController extends Controller
{
    public function store(Request $request, Job $job)
    {
        if (Auth::user()->role !== 'seeker') {
            return back()->with('error', 'Only seekers can apply for jobs.');
        }

        $request->validate([
            'cover_letter' => 'required|string',
        ]);

        $existing = Application::where('user_id', Auth::id())
                              ->where('job_id', $job->id)
                              ->first();

        if ($existing) {
            return back()->with('error', 'You have already applied for this job.');
        }

        Application::create([
            'job_id' => $job->id,
            'user_id' => Auth::id(),
            'cover_letter' => $request->cover_letter,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Application submitted successfully.');
    }

    public function viewApplicants(Job $job)
    {
        if ($job->employer_id !== Auth::id()) {
            abort(403);
        }

        $applications = $job->applications()->with('user.profile')->latest()->get();
        return view('employer.jobs.applicants', compact('job', 'applications'));
    }

    public function updateStatus(Request $request, Application $application)
    {
        $application->load('job');
        if ($application->job->employer_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:pending,reviewed,accepted,rejected',
        ]);

        $application->update(['status' => $request->status]);

        return back()->with('success', 'Application status updated.');
    }

    public function index()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $applications = Application::with(['job.employer', 'user'])->latest()->paginate(20);
        return view('admin.applications', compact('applications'));
    }
}
