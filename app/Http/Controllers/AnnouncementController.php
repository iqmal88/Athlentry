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
        $announcements = Announcement::latest()->get();
        return view('Announcement.Student.homepage', compact('announcements'));
    }

    /**
     * ADMIN PAGE - manage announcements
     */
    public function adminIndex()
    {
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
            'DateClose'   => 'nullable|date',
            'TimeClose'   => 'nullable|date_format:H:i',
            'Description' => 'nullable|string',
            'Image'       => 'nullable|image|max:2048',
        ]);

        // Normalize time to H:i:s
        if (!empty($validated['TimeClose'])) {
            $validated['TimeClose'] = Carbon::createFromFormat('H:i', $validated['TimeClose'])
                                             ->format('H:i:s');
        }

        // Handle image upload
        if ($request->hasFile('Image')) {
            $file = $request->file('Image');
            $filename = time() . '_' . Str::slug(
                pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)
            ) . '.' . $file->getClientOriginalExtension();

            $path = $file->storeAs('uploads', $filename, 'public');
            $validated['Image'] = $path;
        }

        // Creator
        $validated['CreatedBy'] = auth()->user()->UserID ?? auth()->id();

        Announcement::create($validated);

        return redirect()->route('admin.announcements.index')
                         ->with('success', 'Announcement blasted to students.');
    }

    /**
     * Show announcement page for admin
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
            'DateClose'   => 'nullable|date',
            'TimeClose'   => 'nullable|date_format:H:i',
            'Description' => 'nullable|string',
            'Image'       => 'nullable|image|max:2048',
        ]);

        if (!empty($validated['TimeClose'])) {
            $validated['TimeClose'] = Carbon::createFromFormat('H:i', $validated['TimeClose'])
                                             ->format('H:i:s');
        } else {
            $validated['TimeClose'] = null;
        }

        // Handle new image upload
        if ($request->hasFile('Image')) {
            if ($announcement->Image && Storage::disk('public')->exists($announcement->Image)) {
                Storage::disk('public')->delete($announcement->Image);
            }

            $file = $request->file('Image');
            $filename = time() . '_' . Str::slug(
                pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)
            ) . '.' . $file->getClientOriginalExtension();

            $path = $file->storeAs('uploads', $filename, 'public');
            $validated['Image'] = $path;
        }

        // Do not update CreatedBy
        $announcement->update($validated);

        return redirect()->route('admin.announcements.show', $announcement->AnnouncementID)
                         ->with('success', 'Announcement updated.');
    }

    /**
     * Destroy announcement (soft delete + remove image)
     */
    public function destroy(Announcement $announcement)
    {
        if ($announcement->Image && Storage::disk('public')->exists($announcement->Image)) {
            Storage::disk('public')->delete($announcement->Image);
        }

        $announcement->delete();

        return redirect()->route('admin.announcements.index')
                         ->with('success', 'Announcement deleted.');
    }
}
