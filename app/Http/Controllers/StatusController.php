<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\Status;

class StatusController extends Controller
{
    /**
     * Display list of applicants for selection (Admin view)
     */
    public function index()
    {
        $applications = Application::with([
            'user',   // student
            'event',  // event
            'game',   // sport
            'status'  // selection status
        ])->get();

        $statuses = Status::all();

        return view('AthleteStatus.Admin.StatusView', compact(
            'applications',
            'statuses'
        ));
    }

    /**
     * Update SELECTION STATUS for an application
     */
    public function update(Request $request, $ApplicationID)
    {
        $request->validate([
            'StatusID' => 'required|exists:statuses,StatusID'
        ]);

        $application = Application::findOrFail($ApplicationID);

        // Update SELECTION status (NOT application status)
        $application->StatusID = $request->StatusID;
        $application->save();

        return back()->with('success', 'Selection status updated successfully.');
    }
}
