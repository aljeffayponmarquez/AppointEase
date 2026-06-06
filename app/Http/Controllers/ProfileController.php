<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('profile.index', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|unique:users,email,' . $user->id,
            'address' => 'nullable|string|max:500',
            'gender'  => 'nullable|in:Male,Female,Other',
            'phone'   => 'nullable|string|max:20',
        ]);

        $data = $request->only('name', 'email', 'address', 'gender', 'phone');

        if ($request->filled('current_password')) {
            $request->validate([
                'current_password' => 'required',
                'password'         => ['required', 'confirmed', Password::min(8)],
            ]);

            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Current password is incorrect.']);
            }

            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('profile')
            ->with('toast_success', 'Profile updated successfully!');
    }

    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();

        if ($user->avatar && $user->avatar !== 'default.png') {
            $oldPath = public_path('uploads/avatars/' . $user->avatar);
            if (file_exists($oldPath)) unlink($oldPath);
        }

        $fileName = time() . '_' . $user->id . '.' . $request->avatar->extension();
        $request->avatar->move(public_path('uploads/avatars'), $fileName);
        $user->update(['avatar' => $fileName]);

        return redirect()->route('profile')
            ->with('toast_success', 'Profile picture updated successfully!');
    }
}
