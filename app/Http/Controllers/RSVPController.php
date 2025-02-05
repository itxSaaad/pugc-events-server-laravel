<?php

namespace App\Http\Controllers;

use App\Models\RSVP;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Exception;

class RSVPController extends BaseController
{
    public function index()
    {
        try {
            $userId = Auth::id();
            $rsvps = RSVP::where('user_id', $userId)->with('event')->get();

            return $this->sendResponse([
                'count' => $rsvps->count(),
                'rsvps' => $rsvps
            ], 'RSVPs fetched successfully');
        } catch (Exception $e) {
            report($e);
            return $this->sendError(
                'Failed to fetch RSVPed events',
                500,
                config('app.debug') ? $e->getMessage() : 'An unexpected error occurred'
            );
        }
    }

    public function getEventRSVPs(string $eventId)
    {
        try {
            $rsvps = RSVP::with('user')
                ->where('event_id', $eventId)
                ->where('status', true)
                ->get();

            return $this->sendResponse([
                'count' => $rsvps->count(),
                'rsvps' => $rsvps,
            ], 'Event RSVPs fetched successfully');
        } catch (Exception $e) {
            report($e);
            return $this->sendError(
                'Failed to fetch event RSVPs',
                500,
                config('app.debug') ? $e->getMessage() : 'An unexpected error occurred'
            );
        }
    }

    public function store(Request $request, $eventId)
    {
        try {
            $userId = Auth::id();
            $event = Event::findOrFail($eventId);

            $existingRSVP = RSVP::where('event_id', $eventId)
                ->where('user_id', $userId)
                ->first();

            if ($existingRSVP) {
                return $this->sendError('You have already RSVPed for this event', 400);
            }

            $rsvp = RSVP::create([
                'id' => (string) Str::uuid(),
                'event_id' => $eventId,
                'user_id' => $userId,
                'status' => true
            ]);

            return $this->sendResponse(['rsvp' => $rsvp], 'Successfully RSVPed for the event', 201);
        } catch (ValidationException $e) {
            return $this->sendError('Validation failed', 422, $e->errors());
        } catch (Exception $e) {
            report($e);
            return $this->sendError(
                'Failed to RSVP',
                500,
                config('app.debug') ? $e->getMessage() : 'An unexpected error occurred'
            );
        }
    }

    public function destroy($eventId)
    {
        try {
            $userId = Auth::id();
            $rsvp = RSVP::where('event_id', $eventId)
                ->where('user_id', $userId)
                ->first();

            if (!$rsvp) {
                return $this->sendError('RSVP not found', 404);
            }

            $rsvp->delete();

            return $this->sendResponse([], 'RSVP canceled successfully');
        } catch (Exception $e) {
            report($e);
            return $this->sendError(
                'Failed to cancel RSVP',
                500,
                config('app.debug') ? $e->getMessage() : 'An unexpected error occurred'
            );
        }
    }
}
