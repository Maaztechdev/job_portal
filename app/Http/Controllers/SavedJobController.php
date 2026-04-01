<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\SavedJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SavedJobController extends Controller
{
    public function index()
    {
        $savedJobs = SavedJob::with('job.employer')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);
        return view('seeker.saved-jobs.index', compact('savedJobs'));
    }

    public function store(Job $job)
    {
        if (Auth::user()->role !== 'seeker') {
            return back()->with('error', 'Only job seekers can save jobs.');
        }

        $existingSavedJob = SavedJob::where('user_id', Auth::id())
                                    ->where('job_id', $job->id)
                                    ->first();

        if ($existingSavedJob) {
            return back()->with('info', 'This job is already saved.');
        }

        SavedJob::create([
            'user_id' => Auth::id(),
            'job_id' => $job->id,
        ]);

        return back()->with('success', 'Job saved successfully!');
    }

    public function destroy(SavedJob $savedJob)
    {
        if ($savedJob->user_id !== Auth::id()) {
            abort(403);
        }

        $savedJob->delete();

        return back()->with('success', 'Job unsaved successfully.');
    }
}
