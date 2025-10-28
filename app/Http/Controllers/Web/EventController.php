<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Inertia\Inertia;               // <- importa Inertia
use Illuminate\Http\Request;       // <- importa Request
use App\Models\Event;
use App\Models\Venue;              // <- importa Venue

class EventController extends Controller
{
    public function index()
    {
        return Inertia::render('Events/Index', [
            'events'  => Event::with('venue')->latest()->get(),
            'venues'  => Venue::orderBy('venue_name')->get(['id', 'venue_name']),
            'message' => session('message'),
        ]);
    }

    public function create()
    {
        return Inertia::render('Events/Create', [
            'venues'        => Venue::orderBy('venue_name')->get(['id', 'venue_name']),
            'selectedVenue' => request('venue_id'),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'event_name'         => 'required|string|max:255',
            'event_date'         => 'required|date_format:Y-m-d\TH:i',
            'event_is_virtual'   => 'nullable|boolean',
            'event_speaker_name' => 'required|string|max:255',
            'fk_venue_event'     => 'nullable|exists:venues,id',
            'event_image'        => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);


        $validated['event_is_virtual'] = (bool) ($validated['event_is_virtual'] ?? false);

        if ($request->hasFile('event_image')) {
            $imagePath = $request->file('event_image')->store('events', 'public');
            $validated['event_image'] = $imagePath;
        }

        Event::create($validated);

        return redirect()->route('events.index')
            ->with('message', 'Event created successfully.');
    }

    public function show(Event $event)
    {
        return Inertia::render('Events/Show', [
            'event' => $event->load('venue'),
        ]);
    }

    public function edit(Event $event)
    {
        return Inertia::render('Events/Edit', [
            'event'  => $event,
            'venues' => Venue::orderBy('venue_name')->get(['id', 'venue_name']),
        ]);
    }

    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'event_name'         => 'required|string|max:255',
            'event_date'         => 'required|date_format:Y-m-d\TH:i',
            'event_is_virtual'   => 'nullable|boolean',
            'event_speaker_name' => 'required|string|max:255',
            'fk_venue_event'     => 'nullable|exists:venues,id',
            'event_image'        => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'remove_image'       => 'nullable|boolean',
        ]);

        $validated['event_is_virtual'] = (bool) ($validated['event_is_virtual'] ?? false);

        if ($request->has('remove_image') && $request->remove_image) {
            if ($event->event_image) {
                \Storage::disk('public')->delete($event->event_image);
                $validated['event_image'] = null;
            }
        } elseif ($request->hasFile('event_image')) {
            if ($event->event_image) {
                \Storage::disk('public')->delete($event->event_image);
            }
            $imagePath = $request->file('event_image')->store('events', 'public');
            $validated['event_image'] = $imagePath;
        }

        $event->update($validated);

        return redirect()->route('events.index')
            ->with('message', 'Event updated successfully.');
    }

    public function destroy(Event $event)
    {
        if ($event->event_image) {
            \Storage::disk('public')->delete($event->event_image);
        }
        $event->delete();

        return redirect()->route('events.index')
            ->with('message', 'Event deleted successfully.');
    }
}
