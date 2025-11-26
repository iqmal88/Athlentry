<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class AnnouncementController extends Controller
{
    /**
     * STUDENT PAGE - read only
     */
    public function studentIndex()
    {
        // Students see all announcements (you may filter on published flag if you add one)
        $announcements = Announcement::latest()->get();
        return view('Announcement.Student.homepage', compact('announcements'));
    }

    /**
     * ADMIN PAGE - manage announcements
     */
    public function adminIndex()
    {
        // Admin sees all announcements, optionally paginate
        $announcements = Announcement::latest()->get();
        return view('Announcement.Admin.ListAnnounce', compact('announcements'));
    }

    /**
     * Show Add form
     */
    public function create()
    {
        return view('Announcement.Admin.AddAnnounce');
    }

    /**
     * Store announcement (Blast)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'Title'       => 'required|string|max:255',
            'Location'    => 'nullable|string|max:255',
            'Date'        => 'nullable|date',
            'TimeFrom'    => 'nullable|date_format:H:i',
            'TimeUntil'   => 'nullable|date_format:H:i|after_or_equal:TimeFrom',
            'Description' => 'nullable|string',
            'Image'       => 'nullable|image|max:2048', // 2MB
        ]);

        // normalize times to H:i:s if present (DB TIME type often stores seconds)
        if (!empty($validated['TimeFrom'])) {
            $validated['TimeFrom'] = Carbon::createFromFormat('H:i', $validated['TimeFrom'])->format('H:i:s');
        }
        if (!empty($validated['TimeUntil'])) {
            $validated['TimeUntil'] = Carbon::createFromFormat('H:i', $validated['TimeUntil'])->format('H:i:s');
        }

        // Handle image upload
        if ($request->hasFile('Image')) {
            $file = $request->file('Image');
            $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('uploads', $filename, 'public'); // stored at storage/app/public/uploads/...
            $validated['Image'] = $path;
        }

        // CreatedBy: prefer UserID if your users table uses that column
        $validated['CreatedBy'] = auth()->user()->UserID ?? auth()->id();

        Announcement::create($validated);

        return redirect()->route('admin.announcements.index')
                         ->with('success', 'Announcement blasted to students.');
    }

        /**
        * Show announcement page for admin (edit/delete available)
        */
        public function showForAdmin(Announcement $announcement)
    {
        return view('Announcement.Admin.ShowAnnounce', compact('announcement'));
    }

        /**
        * Show announcement page for student (read-only)
        */
        public function showForStudent(Announcement $announcement)
    {
        return view('Announcement.Student.ViewAnnouncement', compact('announcement'));
    }


    /**
     * Show edit form
     */
    public function edit(Announcement $announcement)
    {
        // view: Announcement.Admin.EditAnnounce (you can reuse AddAnnounce with old values)
        return view('Announcement.Admin.EditAnnounce', compact('announcement'));
    }

    /**
     * Update announcement
     */
    public function update(Request $request, Announcement $announcement)
    {
        $validated = $request->validate([
            'Title'       => 'required|string|max:255',
            'Location'    => 'nullable|string|max:255',
            'Date'        => 'nullable|date',
            'TimeFrom'    => 'nullable|date_format:H:i',
            'TimeUntil'   => 'nullable|date_format:H:i|after_or_equal:TimeFrom',
            'Description' => 'nullable|string',
            'Image'       => 'nullable|image|max:2048',
        ]);

        // normalize times to H:i:s if present
        if (!empty($validated['TimeFrom'])) {
            $validated['TimeFrom'] = Carbon::createFromFormat('H:i', $validated['TimeFrom'])->format('H:i:s');
        } else {
            // if empty, ensure null so DB clears field if needed
            $validated['TimeFrom'] = null;
        }

        if (!empty($validated['TimeUntil'])) {
            $validated['TimeUntil'] = Carbon::createFromFormat('H:i', $validated['TimeUntil'])->format('H:i:s');
        } else {
            $validated['TimeUntil'] = null;
        }

        // Handle new image upload (delete old file if exists)
        if ($request->hasFile('Image')) {
            // delete old image if present
            if ($announcement->Image && Storage::disk('public')->exists($announcement->Image)) {
                Storage::disk('public')->delete($announcement->Image);
            }

            $file = $request->file('Image');
            $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('uploads', $filename, 'public');
            $validated['Image'] = $path;
        }

        // Do not change CreatedBy on update
        $announcement->update($validated);

        return redirect()->route('admin.announcements.show', $announcement->AnnouncementID)
                         ->with('success', 'Announcement updated.');
    }

    /**
     * Destroy announcement (and delete image file)
     */
    public function destroy(Announcement $announcement)
    {
        // Delete uploaded image file if exists
        if ($announcement->Image && Storage::disk('public')->exists($announcement->Image)) {
            Storage::disk('public')->delete($announcement->Image);
        }

        // Soft delete (or hard delete if you prefer)
        $announcement->delete();

        return redirect()->route('admin.announcements.index')
                         ->with('success', 'Announcement deleted.');
    }
}
