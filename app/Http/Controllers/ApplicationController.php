<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\GameInfo;
use App\Models\Event;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ApplicationController extends Controller
{
    /**
     * STUDENT PAGE - placeholder (we won't implement student UI now)
     */
    public function studentIndex()
    {
        // Later: list student's own applications
        $applications = [];
        return view('Application.Student.homepage', compact('applications'));
    }

    /**
     * ADMIN PAGE - list all applications (optionally filter)
     */
    public function adminIndex(Request $request)
    {
        $query = Application::with(['user','game.event','status'])->orderByDesc('DateApplied');

        if ($request->filled('GameID')) {
            $query->where('GameID', $request->GameID);
        }
        $applications = $query->get();

        return view('Application.Admin.ListApplications', compact('applications'));
    }

    /**
     * ADMIN PAGE - show applicants for specific game
     */
    public function showForAdmin(GameInfo $game)
    {
        $game->load(['applications.user','applications.status','event']);
        return view('Application.Admin.ForGame', compact('game'));
    }

    /**
     * ADMIN: show single application (applicant detail)
     */
    public function showForAdminSingle(Application $application)
    {
        $application->load(['user','game.event','status']);
        return view('Application.Admin.ShowApplication', compact('application'));
    }

    /**
     * ADMIN: Update status (approve/reject/waitlist)
     */
    public function update(Request $request, Application $application)
    {
        $validated = $request->validate([
            'StatusID' => 'required|integer|exists:statuses,StatusID',
        ]);

        $newStatus = Status::find($validated['StatusID']);

        // If accepting, ensure capacity not exceeded
        if ($newStatus && strtolower($newStatus->Name) === 'accepted') {
            $acceptedCount = Application::where('GameID', $application->GameID)
                ->whereHas('status', function($q){
                    $q->where('Name','Accepted');
                })->count();

            $capacity = optional($application->game)->Capacity;
            if ($capacity !== null && $acceptedCount >= $capacity) {
                return back()->with('error', 'Capacity full. Cannot accept more applicants.');
            }
        }

        $application->StatusID = $validated['StatusID'];
        $application->save();

        return back()->with('success', 'Application status updated.');
    }

    /**
     * ADMIN: Delete application
     */
    public function destroy(Application $application)
    {
        $application->delete();
        return back()->with('success', 'Application deleted.');
    }
}
