<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Venue;
use Illuminate\Http\Request;
use Inertia\Inertia;

class VenueController extends Controller
{
    public function index()
    {
        $venues = Venue::select('id','venue_name','venue_max_capacity','venue_address','venue_status')
            ->latest('id')->get();

        return Inertia::render('Venues/Index', ['venues' => $venues]);
    }

    public function create()
    {
        return Inertia::render('Venues/Create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'venue_name'         => ['required','string','max:255'],
            'venue_max_capacity' => ['required','integer','min:1'],
            'venue_address'      => ['required','string','max:255'],
            'venue_status'       => ['required','boolean'],
        ]);

        Venue::create($data);

        return redirect()->route('venues.index')->with('success','Venue creado correctamente.');
    }

    public function show(Venue $venue)
    {
        return Inertia::render('Venues/Show', [
            'venue' => $venue->only('id','venue_name','venue_max_capacity','venue_address','venue_status'),
        ]);
    }

    public function edit(Venue $venue)
    {
        return Inertia::render('Venues/Edit', [
            'venue' => $venue->only('id','venue_name','venue_max_capacity','venue_address','venue_status'),
        ]);
    }

    public function update(Request $request, Venue $venue)
    {
        $data = $request->validate([
            'venue_name'         => ['required','string','max:255'],
            'venue_max_capacity' => ['required','integer','min:1'],
            'venue_address'      => ['required','string','max:255'],
            'venue_status'       => ['required','boolean'],
        ]);

        $venue->update($data);

        return redirect()->route('venues.index')->with('success','Venue actualizado correctamente.');
    }

    public function destroy(Venue $venue)
    {
        $venue->delete();
        return redirect()->route('venues.index')->with('success','Venue eliminado correctamente.');
    }
}
