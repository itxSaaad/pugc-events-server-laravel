<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;

class EventController extends BaseController
{
    public function index()
    {
        try {
            $events = Event::all();
            return $this->sendResponse(['events' => $events], 'Events fetched successfully');
        } catch (Exception $e) {
            report($e);
            return $this->sendError('Failed to fetch events', 500, config('app.debug') ? $e->getMessage() : 'An unexpected error occurred');
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'department' => 'required|string',
                'date' => 'required|date',
                'time' => 'required|date_format:H:i',
                'location' => 'required|string',
            ]);

            $event = Event::create([
                'id' => (string) Str::uuid(),
                'title' => $validated['title'],
                'description' => $validated['description'],
                'department' => $validated['department'],
                'date' => $validated['date'],
                'time' => $validated['time'],
                'location' => $validated['location'],
                'created_by' => Auth::id()
            ]);

            return $this->sendResponse(['event' => $event], 'Event created successfully', 201);
        } catch (ValidationException $e) {
            return $this->sendError('Validation failed', 422, $e->errors());
        } catch (Exception $e) {
            report($e);
            return $this->sendError('Failed to create event', 500, config('app.debug') ? $e->getMessage() : 'An unexpected error occurred');
        }
    }

    public function show(string $id)
    {
        try {
            $event = Event::with('creator')->findOrFail($id);
            return $this->sendResponse(['event' => $event], 'Event fetched successfully');
        } catch (Exception $e) {
            report($e);
            return $this->sendError('Event not found', 404, config('app.debug') ? $e->getMessage() : 'An unexpected error occurred');
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            $event = Event::findOrFail($id);

            $validated = $request->validate([
                'title' => 'sometimes|required|string|max:255',
                'description' => 'sometimes|required|string',
                'department' => 'sometimes|required|string',
                'date' => 'sometimes|required|date',
                'time' => 'sometimes|required|date_format:H:i',
                'location' => 'sometimes|required|string',
            ]);

            $event->update($validated);

            return $this->sendResponse(['event' => $event], 'Event updated successfully');
        } catch (ValidationException $e) {
            return $this->sendError('Validation failed', 422, $e->errors());
        } catch (Exception $e) {
            report($e);
            return $this->sendError('Failed to update event', 500, config('app.debug') ? $e->getMessage() : 'An unexpected error occurred');
        }
    }

    public function destroy(string $id)
    {
        try {
            $event = Event::findOrFail($id);
            $event->delete();

            return $this->sendResponse([], 'Event deleted successfully');
        } catch (Exception $e) {
            report($e);
            return $this->sendError('Failed to delete event', 500, config('app.debug') ? $e->getMessage() : 'An unexpected error occurred');
        }
    }
}
