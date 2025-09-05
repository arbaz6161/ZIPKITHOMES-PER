<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function createUser(Request $request) {
        // Validate request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $fullName = $validatedData['name'];
        $nameParts = explode(' ', $fullName, 2);

        $firstName = $nameParts[0];
        $lastName = isset($nameParts[1]) ? $nameParts[1] : '';

        // Create user
        $user = User::create([
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $validatedData['email'],
            'user_role_id' => User::TENANT_VIEWER,
            'password' => bcrypt($validatedData['password']),
        ]);

        // Return response
        return response()->json(['message' => 'User created successfully', 'user' => $user], 201);
    }
}
