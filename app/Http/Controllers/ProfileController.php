<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        $profile = Auth::user()->profile ?? new Profile();
        return view('seeker.profile.edit', compact('profile'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $profile = $user->profile ?? new Profile(['user_id' => $user->id]);

        $request->validate([
            'bio' => 'nullable|string',
            'skills' => 'nullable|string',
            'experience' => 'nullable|string',
            'resume' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $data = $request->only(['bio', 'skills', 'experience']);

        if ($request->hasFile('resume')) {
            if ($profile->resume) {
                Storage::disk('public')->delete($profile->resume);
            }
            $path = $request->file('resume')->store('resumes', 'public');
            $data['resume'] = $path;
        }

        $profile->fill($data);
        $profile->save();

        return back()->with('success', 'Profile updated successfully.');
    }
}
