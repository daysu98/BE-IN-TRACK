<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    public function update(Request $request): JsonResponse
    {
        $user = Auth::user();

        $request->validate([
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'email' => ['sometimes', 'required', 'string', 'email', 'max:255', "unique:users,email, $user->id"],
            'bio' => ['sometimes', 'nullable', 'string'],
            'photo' => ['sometimes', 'nullable', 'mimes:png,jpg,webp', 'max:1024'],
        ]);

        $updateData = $request->only(['name', 'email', 'bio']);

        if ($request->file('photo')) {
            if ($user->photo && $user->photo !== '-') {
                Storage::disk('public')->delete("img/avt/$user->photo");
            }

            $fileName = Str::random(70) . '.' . $request->file('photo')->extension();

            $request->file('photo')->storeAs('img/avt', $fileName, 'public');

            $updateData['photo'] = $fileName;
        }

        $user->update($updateData);

        return response()->json([
            'status' => 'OK',
            'message' => 'Profile updated successfully!',
            'data' => $user,
        ]);
    }
}
