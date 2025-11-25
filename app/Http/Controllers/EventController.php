<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class EventController extends Controller
{
    /**
     * STUDENT PAGE - Read-only list of events
     */
    public function studentIndex()
    {
        // Show events to students/public (only open events if you want)
        $events = Event::orderByDesc('StartDate')->get();
        return view('Event.Student.homepage', compact('events'));
    }

    /**
     * ADMIN PAGE - Manage events
     */
    public function adminIndex()
    {
        // Admin sees all events with counts (you can paginate)
        $events = Event::withCount('games')->orderByDesc('StartDate')->get();
        return view('Event.Admin.ListEvents', compact('events'));
    }

    /**
     * Show Add form (admin)
     */
    public function create()
    {
        return view('Event.Admin.AddEvent');
    }

    /**
     * Store event (admin)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'EventName'   => 'required|string|max:255',
            'Location'    => 'nullable|string|max:255',
            'StartDate'   => 'nullable|date',
            'EndDate'     => 'nullable|date|after_or_equal:StartDate',
            'Description' => 'nullable|string',
            'Status'      => 'nullable|in:Open,Closed,Cancelled',
        ]);

        $validated['CreatedBy'] = Auth::user()->UserID ?? null;

        Event::create($validated);

        return redirect()->route('admin.events.index')->with('success', 'Event created.');
    }

    /**
     * Show event page for admin (edit/delete available)
     */
    public function showForAdmin(Event $event)
    {
        // admin view can include games relationship
        $event->load('games');
        return view('Event.Admin.ShowEvent', compact('event'));
    }

    /**
     * Show event page for student (read-only)
     */
    public function showForStudent(Event $event)
    {
        $event->load(['games' => function($q){
            $q->where('Status','Open')->orderBy('GameDate');
        }]);
        return view('Event.Student.ViewEvent', compact('event'));
    }

    /**
     * Show edit form (admin)
     */
    public function edit(Event $event)
    {
        return view('Event.Admin.EditEvent', compact('event'));
    }

    /**
     * Update event (admin)
     */
    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'EventName'   => 'required|string|max:255',
            'Location'    => 'nullable|string|max:255',
            'StartDate'   => 'nullable|date',
            'EndDate'     => 'nullable|date|after_or_equal:StartDate',
            'Description' => 'nullable|string',
            'Status'      => 'nullable|in:Open,Closed,Cancelled',
        ]);

        $event->update($validated);

        return redirect()->route('admin.events.show', $event->EventID)
                         ->with('success', 'Event updated.');
    }

    /**
     * Destroy (admin)
     */
    public function destroy(Event $event)
    {
        // prevent deletion if games exist to protect data
        if ($event->games()->exists()) {
            return back()->with('error', 'Cannot delete event while it has games. Remove games first.');
        }

        $event->delete();
        return redirect()->route('admin.events.index')->with('success', 'Event deleted.');
    }
}
