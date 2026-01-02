<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\GameInfo;
use App\Models\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class ApplicationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Helper - Get Current Admin/User ID
    |--------------------------------------------------------------------------
    */
    protected function getUserId()
    {
        if (Auth::check()) return Auth::id();
        return Session::get('user')->UserID ?? null;
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN : EVENT MANAGEMENT
    |--------------------------------------------------------------------------
    */

    /**
     * List all events with games + application count
     */
    public function listEvents()
    {
        $events = Event::with(['games' => function ($q) {
            $q->withCount('applications');
        }])->orderBy('StartDate', 'desc')->get();

        return view('application.admin.ListEvent', compact('events'));
    }

    /**
     * Show create event form
     */
    public function createEvent()
    {
        $availableGames = GameInfo::whereNull('EventID')->orderBy('GameName')->get();
        return view('application.admin.AddEvent', compact('availableGames'));
    }

    /**
     * Store event + minimal games
     */
    public function storeEvent(Request $request)
    {
        $validated = $request->validate([
            'EventName' => 'required|string|max:255',
            'Location' => 'nullable|string|max:255',
            'StartDate' => 'nullable|date',
            'EndDate' => 'nullable|date|after_or_equal:StartDate',
            'Description' => 'nullable|string',
            'Status' => 'nullable|in:Open,Closed,Cancelled',

            'games' => 'nullable|array',
            'games.*.GameName' => 'required_with:games|string|max:255',
            'games.*.Category' => 'nullable|string|max:100',
            'games.*.Capacity' => 'nullable|integer|min:1',
        ]);

        DB::beginTransaction();
        try {
            $event = Event::create([
                'EventName'   => $validated['EventName'],
                'Location'    => $validated['Location'] ?? null,
                'StartDate'   => $validated['StartDate'] ?? null,
                'EndDate'     => $validated['EndDate'] ?? null,
                'Description' => $validated['Description'] ?? null,
                'CreatedBy'   => $this->getUserId(),
                'Status'      => $validated['Status'] ?? 'Open',
            ]);

            if (!empty($validated['games'])) {
                foreach ($validated['games'] as $g) {
                    GameInfo::create([
                        'EventID'  => $event->EventID,
                        'GameName' => $g['GameName'],
                        'Category' => $g['Category'] ?? null,
                        'Capacity' => $g['Capacity'] ?? null,
                        'Status'   => 'Open',
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('admin.events.edit', $event->EventID)
                ->with('success', 'Event created successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * Edit event
     */
    public function editEvent($EventID)
    {
        $event = Event::with('games')->where('EventID', $EventID)->firstOrFail();
        return view('application.admin.EditEvent', compact('event'));
    }

    /**
     * Update event + games
     */
    public function updateEvent(Request $request, $EventID)
    {
        $validated = $request->validate([
            'EventName' => 'required|string|max:255',
            'Location' => 'nullable|string|max:255',
            'StartDate' => 'nullable|date',
            'EndDate' => 'nullable|date|after_or_equal:StartDate',
            'Description' => 'nullable|string',
            'Status' => 'nullable|in:Open,Closed,Cancelled',

            'games' => 'nullable|array',
            'games.*.GameID' => 'nullable|exists:game_info,GameID',
            'games.*.GameName' => 'required_with:games|string|max:255',
            'games.*.Category' => 'nullable|string|max:100',
            'games.*.Capacity' => 'nullable|integer|min:0',
        ]);

        DB::beginTransaction();
        try {
            $event = Event::findOrFail($EventID);
            $event->update($validated);

            if (!empty($validated['games'])) {
                foreach ($validated['games'] as $g) {
                    GameInfo::updateOrCreate(
                        ['GameID' => $g['GameID'] ?? null],
                        [
                            'EventID' => $event->EventID,
                            'GameName' => $g['GameName'],
                            'Category' => $g['Category'] ?? null,
                            'Capacity' => $g['Capacity'] ?? null,
                            'Status' => 'Open'
                        ]
                    );
                }
            }

            DB::commit();
            return redirect()->route('admin.events.list')->with('success', 'Event updated.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN : APPLICANTS
    |--------------------------------------------------------------------------
    */

    public function viewApplicantsByGame($GameID)
    {
        $game = GameInfo::with('event')->findOrFail($GameID);

        $applications = Application::with('user')
            ->where('GameID', $GameID)
            ->orderBy('DateApplied')
            ->get();

        return view('application.admin.ViewApplicants', compact('game', 'applications'));
    }

    public function selectApplicant(Request $request, $ApplicationID)
    {
        $application = Application::findOrFail($ApplicationID);
        $application->StatusID = $request->input('StatusID', 2);
        $application->save();

        return back()->with('success', 'Applicant selected.');
    }

    /*
    |--------------------------------------------------------------------------
    | STUDENT : ATHLETE APPLICATION
    |--------------------------------------------------------------------------
    */

    /**
     * Student – List all open events & games
     */
    public function studentApplicationIndex()
    {
        $studentId = Auth::id();

        $events = Event::with(['games' => function ($q) use ($studentId) {
            $q->where('Status', 'Open')
              ->withCount([
                  'applications as applied' => function ($q2) use ($studentId) {
                      $q2->where('UserID', $studentId);
                  },
                  'applications as total_applied'
              ]);
        }])->where('Status', 'Open')->get();

        return view('application.student.AthleteApplication', compact('events'));
    }

    /**
     * Student – Submit application (MODAL POST)
     */
    public function submitApplication(Request $request, $GameID)
    {
        $studentId = Auth::id();
        $game = GameInfo::withCount('applications')->findOrFail($GameID);

        // ❌ Game closed
        if ($game->Status !== 'Open') {
            return back()->with('error', 'This game is no longer open.');
        }

        // ❌ Duplicate apply
        $exists = Application::where('UserID', $studentId)
            ->where('GameID', $GameID)
            ->exists();

        if ($exists) {
            return back()->with('error', 'You have already applied.');
        }

        // ❌ Capacity full (OPTIONAL – INCLUDED)
        if ($game->Capacity !== null && $game->applications_count >= $game->Capacity) {
            return back()->with('error', 'This sport has reached maximum capacity.');
        }

        Application::create([
            'UserID'      => $studentId,
            'EventID'     => $game->EventID,
            'GameID'      => $game->GameID,
            'DateApplied' => now(),
            'StatusID'    => null,
        ]);

        return back()->with('success', 'Application submitted successfully.');
    }

    public function studentEventShow($EventID)
    {
        $studentId = Auth::id();

        $event = Event::with(['games' => function ($q) use ($studentId) {
            $q->where('Status', 'Open')
                ->withCount([
                    'applications as applied' => function ($q2) use ($studentId) {
                        $q2->where('UserID', $studentId);
                    }
                ]);
        }])->where('EventID', $EventID)->firstOrFail();

        return view('application.student.EventDetails', compact('event'));
    }

}
