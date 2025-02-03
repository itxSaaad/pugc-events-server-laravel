<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rules\Password;
use Exception;

class AuthController
{
    public function register(Request $request)
    {
        try {
            $request->validate([
                'name' => ['required', 'string', 'max:255', 'regex:/^[\pL\s\-]+$/u'], // Only letters, spaces and hyphens
                'email' => ['required', 'string', 'email:rfc,dns', 'max:255', 'unique:users'],
                'password' => [
                    'required',
                    'string',
                    Password::min(8)
                        ->mixedCase()
                        ->numbers()
                        ->symbols()
                        ->uncompromised(),
                    'confirmed'
                ],
            ], [
                'name.regex' => 'Name can only contain letters, spaces and hyphens',
                'email.email' => 'Please provide a valid email address',
                'password.uncompromised' => 'This password has been leaked in a data breach. Please choose another.'
            ]);

            if (strlen($request->name) < 2) {
                throw ValidationException::withMessages(['name' => 'Name must be at least 2 characters long']);
            }

            $user = User::create([
                'id' => (string) Str::uuid(),
                'name' => trim($request->name),
                'email' => strtolower($request->email),
                'password' => Hash::make($request->password),
                'role' => 'student',
            ]);

            $token = $user->createToken('pugc-events')->plainTextToken;

            return response()->json([
                'status' => 'success',
                'message' => 'Registration successful',
                'data' => [
                    'user' => $user->makeHidden(['password']),
                    'token' => $token,
                ]
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (Exception $e) {
            report($e); // Log the error
            return response()->json([
                'status' => 'error',
                'message' => 'Registration failed',
                'error' => config('app.debug') ? $e->getMessage() : 'An unexpected error occurred'
            ], 500);
        }
    }

    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => ['required', 'string', 'email:rfc,dns'],
                'password' => ['required', 'string', 'min:8'],
            ]);

            $user = User::where('email', strtolower($request->email))->first();

            if (!$user) {
                throw ValidationException::withMessages([
                    'email' => ['Invalid email address/password']
                ]);
            }

            if (!Hash::check($request->password, $user->password)) {
                throw ValidationException::withMessages([
                    'password' => ['The provided password is incorrect.']
                ]);
            }

            $user->tokens()->delete();

            $token = $user->createToken('pugc-events')->plainTextToken;

            return response()->json([
                'status' => 'success',
                'message' => 'Login successful',
                'data' => [
                    'user' => $user->makeHidden(['password']),
                    'token' => $token,
                ]
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (Exception $e) {
            report($e);
            return response()->json([
                'status' => 'error',
                'message' => 'Login failed',
                'error' => config('app.debug') ? $e->getMessage() : 'An unexpected error occurred'
            ], 500);
        }
    }

    public function profile(Request $request)
    {
        try {
            $user = $request->user();

            if (!$user) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unauthorized'
                ], 401);
            }

            return response()->json([
                'status' => 'success',
                'data' => [
                    'user' => $user->makeHidden(['password'])
                ]
            ], 200);
        } catch (Exception $e) {
            report($e);
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch profile',
                'error' => config('app.debug') ? $e->getMessage() : 'An unexpected error occurred'
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        try {
            $user = $request->user();

            if (!$user) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unauthorized'
                ], 401);
            }

            $user->currentAccessToken()->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Logged out successfully'
            ], 200);
        } catch (Exception $e) {
            report($e);
            return response()->json([
                'status' => 'error',
                'message' => 'Logout failed',
                'error' => config('app.debug') ? $e->getMessage() : 'An unexpected error occurred'
            ], 500);
        }
    }
}
