<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        //$photo_url = $user->photo ? asset('storage/' . $user->photo) : asset('storage/images/users/default.png');
        return view('backend.pages.profile', compact('user'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:800'],
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $path = $user->photo;

        if ($request->hasFile('photo')) {
            // Delete old photo if it exists
            if ($path && Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }

            $file = $request->file('photo');
            $filename = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '-' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('images/users', $filename, 'public');
        }

        $user->update([
            'name' => $request->name,
            'photo' => $path,
        ]);

        return redirect()->route('dashboard.profile.edit')->with('success', 'Profile updated successfully.');
    }
}
