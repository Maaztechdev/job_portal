<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Application;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function admin()
    {
        $stats = [
            'total_jobs' => Job::count(),
            'total_users' => User::count(),
            'total_applications' => Application::count(),
            'employers' => User::where('role', 'employer')->count(),
            'seekers' => User::where('role', 'seeker')->count(),
        ];
        return view('admin.dashboard', compact('stats'));
    }

    public function employer()
    {
        $user = Auth::user();
        $jobs = Job::where('employer_id', $user->id)->withCount('applications')->latest()->get();
        $total_applications = Application::whereIn('job_id', $jobs->pluck('id'))->count();

        return view('employer.dashboard', compact('jobs', 'total_applications'));
    }

    public function seeker()
    {
        $user = Auth::user();
        $applications = Application::where('user_id', $user->id)->with('job.employer')->latest()->get();
        return view('seeker.dashboard', compact('applications'));
    }
}
