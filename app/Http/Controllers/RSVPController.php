<?php

namespace App\Http\Controllers;

use App\Models\RSVP;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\BaseController;
use Exception;

class RSVPController extends BaseController
{
    public function index(Request $request)
    {
        try {
            $rsvps = RSVP::query()
                ->where('user_id', $request->user()->id)
                ->where('status', true)
                ->with('event')
                ->get();

            return $this->sendResponse([
                'count' => $rsvps->count(),
                'rsvps' => $rsvps
            ], 'RSVPs retrieved successfully');
        } catch (Exception $e) {
            report($e);
            return $this->sendError(
                'Failed to retrieve RSVPs',
                500,
                config('app.debug') ? $e->getMessage() : null
            );
        }
    }

    public function getEventRSVPs($eventId)
    {
        try {
            $rsvps = RSVP::query()
                ->where('event_id', $eventId)
                ->where('status', true)
                ->with('user')
                ->get();

            return $this->sendResponse([
                'count' => $rsvps->count(),
                'rsvps' => $rsvps,
            ], 'Event RSVPs retrieved successfully');
        } catch (Exception $e) {
            report($e);
            return $this->sendError(
                'Failed to retrieve event RSVPs',
                500,
                config('app.debug') ? $e->getMessage() : null
            );
        }
    }

    public function store(Request $request, $eventId)
    {
        try {
            $userId = $request->user()->id;

            $existingRSVP = RSVP::query()
                ->where('event_id', $eventId)
                ->where('user_id', $userId)
                ->first();

            if ($existingRSVP) {
                return $this->sendError('RSVP already exists for this event', 409);
            }

            $rsvp = RSVP::create([
                'id' => Str::uuid()->toString(),
                'user_id' => $userId,
                'event_id' => $eventId,
                'status' => true,
            ]);

            return $this->sendResponse(
                ['rsvp' => $rsvp],
                'RSVP created successfully',
                201
            );
        } catch (ValidationException $e) {
            return $this->sendError('Validation failed', 422, $e->errors());
        } catch (Exception $e) {
            report($e);
            return $this->sendError(
                'Failed to create RSVP',
                500,
                config('app.debug') ? $e->getMessage() : null
            );
        }
    }

    public function destroy(Request $request, $eventId)
    {
        try {
            $rsvp = RSVP::query()
                ->where('event_id', $eventId)
                ->where('user_id', $request->user()->id)
                ->first();

            if (!$rsvp) {
                return $this->sendError('RSVP not found', 404);
            }

            $rsvp->delete();

            return $this->sendResponse(
                [],
                'RSVP deleted successfully',
                200
            );
        } catch (Exception $e) {
            report($e);
            return $this->sendError(
                'Failed to delete RSVP',
                500,
                config('app.debug') ? $e->getMessage() : null
            );
        }
    }
}
