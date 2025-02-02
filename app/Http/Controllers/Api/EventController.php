<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\EventResource;
use App\Models\Event;
use Illuminate\Auth\Access\Gate;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return EventResource::collection(Event::with('user')->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $event  = Event::create([
            ... $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'start_time' => 'required|date',
                'end_time' => 'required|date|after:start_time'
            ]),
            'user_id' => $request->user()->id
        ]);

        return $event;
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        $event->load('user');
        return new EventResource($event);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        if (\Illuminate\Support\Facades\Gate::denies('update-event', $event)) {
            abort(403, 'You are not authorized to update this event.');
        }

        $this->authorize('update-event', $event);

        $event->update(
            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'start_time' => 'required|date',
                'end_time' => 'required|date|after:start_time'
            ])
        );

        return $event;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        $event->delete();

        return response()->json([
            'message' => 'Event deleted successfully'
        ]);

//        return response(status: 204);
    }
}
