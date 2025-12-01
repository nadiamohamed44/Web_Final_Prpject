<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        return view('profile.index', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'first_name' => 'required|min:2',
            'last_name'  => 'required|min:2',
            'phone'      => 'nullable',
            'address'    => 'nullable',
        ]);

        // Update core user data
        $user->update([
            'first_name' => $validated['first_name'],
            'last_name'  => $validated['last_name'],
        ]);

        // Save phone if provided
        if ($request->phone) {
            $user->phones()->updateOrCreate([], [
                'phone_number' => $request->phone
            ]);
        }

        // Save address if provided
        if ($request->address) {
            $user->addresses()->updateOrCreate([], [
                'address_line' => $request->address
            ]);
        }

        return back()->with('success', 'Profile updated successfully!');
    }
}
