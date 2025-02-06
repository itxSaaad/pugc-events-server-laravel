<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;

class EventController extends BaseController
{
    private $validationRules = [
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'department' => 'required|string',
        'date' => 'required|date',
        'time' => 'required|date_format:H:i',
        'location' => 'required|string',
    ];

    public function index()
    {
        try {
            $events = Event::with('creator')->with('rsvps')->latest()->get();
            return $this->sendResponse(['events' => $events], 'Events retrieved successfully');
        } catch (Exception $e) {
            report($e);
            return $this->sendError('Failed to retrieve events', 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate($this->validationRules);

            $event = Event::create([
                'id' => Str::uuid()->toString(),
                ...$validated,
                'created_by' => $request->user()->id,
            ]);

            return $this->sendResponse(
                ['event' => $event->load('creator')],
                'Event created successfully',
                201
            );
        } catch (ValidationException $e) {
            return $this->sendError('Validation failed', 422, $e->errors());
        } catch (Exception $e) {
            report($e);
            return $this->sendError('Failed to create event', 500);
        }
    }

    public function show(string $id)
    {
        try {
            $event = Event::with('creator')->with('rsvps')->findOrFail($id);
            return $this->sendResponse(['event' => $event], 'Event retrieved successfully');
        } catch (ModelNotFoundException $e) {
            return $this->sendError('Event not found', 404);
        } catch (Exception $e) {
            report($e);
            return $this->sendError('Failed to retrieve event', 500);
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            $event = Event::findOrFail($id);
            $validated = $request->validate($this->validationRules);

            $event->update([
                ...$validated,
                'created_by' => $request->user()->id,
            ]);

            return $this->sendResponse(
                ['event' => $event->fresh('creator')],
                'Event updated successfully'
            );
        } catch (ModelNotFoundException $e) {
            return $this->sendError('Event not found', 404);
        } catch (ValidationException $e) {
            return $this->sendError('Validation failed', 422, $e->errors());
        } catch (Exception $e) {
            report($e);
            return $this->sendError('Failed to update event', 500);
        }
    }

    public function destroy(string $id)
    {
        try {
            $event = Event::findOrFail($id);
            $event->delete();

            return $this->sendResponse(null, 'Event deleted successfully');
        } catch (ModelNotFoundException $e) {
            return $this->sendError('Event not found', 404);
        } catch (Exception $e) {
            report($e);
            return $this->sendError('Failed to delete event', 500);
        }
    }
}
