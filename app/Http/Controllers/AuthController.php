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
            $validatedData = $request->validate([
                'name' => ['required', 'string', 'min:2', 'max:255', 'regex:/^[\pL\s\-]+$/u'],
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
                'name.min' => 'Name must be at least 2 characters long',
                'email.email' => 'Please provide a valid email address',
                'password.uncompromised' => 'This password has been leaked in a data breach. Please choose another.'
            ]);

            $user = User::create([
                'id' => Str::uuid()->toString(),
                'name' => trim($validatedData['name']),
                'email' => strtolower($validatedData['email']),
                'password' => Hash::make($validatedData['password']),
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
            report($e);
            return $this->sendError('Registration failed', 500, $this->getErrorMessage($e));
        }
    }

    public function login(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'email' => ['required', 'string', 'email:rfc,dns'],
                'password' => ['required', 'string', 'min:8'],
            ]);

            $user = User::where('email', strtolower($validatedData['email']))->first();

            if (!$user || !Hash::check($validatedData['password'], $user->password)) {
                throw ValidationException::withMessages([
                    'email' => ['Invalid credentials']
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
            return $this->sendError('Login failed', 500, $this->getErrorMessage($e));
        }
    }

    public function profile(Request $request)
    {
        try {
            $userId = $request->user()->id;

            $existingUser = User::find($userId)->with('rsvps')->first();

            if (!$existingUser) {
                return $this->sendError('User not found', 404);
            }
            return $this->sendResponse([
                'user' => $existingUser->makeHidden(['password'])
            ], 'Profile retrieved successfully');
        } catch (Exception $e) {
            report($e);
            return $this->sendError('Failed to retrieve profile', 500, $this->getErrorMessage($e));
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

            return $this->sendResponse(null, 'Logged out successfully');
        } catch (Exception $e) {
            report($e);
            return $this->sendError('Logout failed', 500, $this->getErrorMessage($e));
        }
    }

    private function getErrorMessage(Exception $e)
    {
        return config('app.debug') ? $e->getMessage() : 'An unexpected error occurred';
    }
}
