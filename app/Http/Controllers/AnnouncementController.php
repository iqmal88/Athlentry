<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    // STUDENT PAGE - read only
    public function studentIndex()
    {
        $announcements = Announcement::latest()->get();
        return view('Announcement.Student.homepage', compact('announcements'));
    }

    // ADMIN PAGE - manage announcements
    public function adminIndex()
    {
        $announcements = Announcement::latest()->get();
        return view('Announcement.Admin.ListAnnounce', compact('announcements'));
    }

    // Show Add form
    public function create()
    {
        return view('Announcement.Admin.AddAnnounce');
    }

    // Store announcement - triggered by single "Blast" button
    public function store(Request $request)
    {
        $request->validate([
            'Title' => 'required|string|max:255',
            'Location' => 'nullable|string|max:255',
            'Date' => 'nullable|date',
            'Description' => 'nullable|string',
        ]);

        $announcement = Announcement::create([
            'Title'       => $request->Title,
            'Location'    => $request->Location,
            'Date'        => $request->Date,
            'Description' => $request->Description,
            'CreatedBy'   => auth()->user()->UserID ?? auth()->id(),
        ]);

        // OPTIONAL: if you later add notification logic, do it here
        // e.g. Notification::send($students, new AnnouncementBlast($announcement));

        return redirect()->route('admin.announcements.index')
                         ->with('success', 'Announcement blasted to students.');
    }
}
