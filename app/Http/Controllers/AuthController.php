<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rules\Password;
use Exception;

class AuthController extends BaseController
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

            return $this->sendResponse([
                'user' => $user->makeHidden(['password']),
                'token' => $token,
            ], 'Registration successful', 201);
        } catch (ValidationException $e) {
            return $this->sendError('Validation failed', 422, $e->errors());
        } catch (Exception $e) {
            report($e); // Log the error
            return $this->sendError('Registration failed', 500, config('app.debug') ? $e->getMessage() : 'An unexpected error occurred');
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

            return $this->sendResponse([
                'user' => $user->makeHidden(['password']),
                'token' => $token,
            ], 'Login successful');
        } catch (ValidationException $e) {
            return $this->sendError('Validation failed', 422, $e->errors());
        } catch (Exception $e) {
            report($e);
            return $this->sendError('Login failed', 500, config('app.debug') ? $e->getMessage() : 'An unexpected error occurred');
        }
    }

    public function profile(Request $request)
    {
        try {
            $user = $request->user();

            if (!$user) {
                return $this->sendError('Unauthorized', 401);
            }

            return $this->sendResponse([
                'user' => $user->makeHidden(['password'])
            ], 'Profile fetched successfully');
        } catch (Exception $e) {
            report($e);
            return $this->sendError('Failed to fetch profile', 500, config('app.debug') ? $e->getMessage() : 'An unexpected error occurred');
        }
    }

    public function logout(Request $request)
    {
        try {
            $user = $request->user();

            if (!$user) {
                return $this->sendError('Unauthorized', 401);
            }

            $user->currentAccessToken()->delete();

            return $this->sendResponse([], 'Logged out successfully');
        } catch (Exception $e) {
            report($e);
            return $this->sendError('Logout failed', 500, config('app.debug') ? $e->getMessage() : 'An unexpected error occurred');
        }
    }
}
