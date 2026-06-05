<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Str;
use Throwable;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();

        return view('profile.edit', [
            'user' => $user
        ]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $is_file_uploaded = false;
        $avatar_file_new_name = null;

        // Valdations
        $request->validate([
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'password' => 'required|current_password',
            'password_new' => 'nullable|string|min:8|max:255',
        ]);

        // Storing new avatar file
        if ($request->hasFile('avatar')) {
            $avatar_file_new = $request->file('avatar');
            $avatar_file_new_name = 'avatar_' . Str::uuid() . '.' . $avatar_file_new->extension();

            $uploaded_avatar_path = $avatar_file_new->storeAs(
                'images/avatars/',
                $avatar_file_new_name,
                'public'
            );

            // fail
            if (!$uploaded_avatar_path) {
                return back()->withErrors([
                    'avatar' => 'Error while storing the images'
                ]);
            }

            // success
            $is_file_uploaded = true;
        }

        // Update user data
        try {
            DB::beginTransaction();

            $user->name = $request->name;
            $user->email = $request->email;

            if ($request->filled('password_new')) {
                $user->password = Hash::make($request->password_new);
            }

            if ($is_file_uploaded) {
                $user->avatar_filename = $avatar_file_new_name;
            }

            $user->saveOrFail();

            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();

            if ($is_file_uploaded) {
                Storage::disk('public')->delete('images/avatars/' . $avatar_file_new_name);
            }

            throw $e;
        }

        return redirect('/');
    }
}
