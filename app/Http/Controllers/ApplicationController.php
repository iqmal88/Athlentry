<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\GameInfo;
use App\Models\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ApplicationController extends Controller
{
    /* =========================================================
     | HELPER
     ========================================================= */
    protected function getUserId()
    {
        return Auth::user()->UserID;
    }

    /* =========================================================
     | ADMIN : EVENT MANAGEMENT
     ========================================================= */

    public function listEvents()
    {
        $events = Event::with(['games' => function ($q) {
            $q->withCount('applications');
        }])->orderBy('StartDate', 'desc')->get();

        return view('application.admin.ListEvent', compact('events'));
    }

    public function createEvent()
    {
        return view('application.admin.AddEvent');
    }

    public function editEvent($EventID)
    {
        $event = Event::with('games')->findOrFail($EventID);
        return view('application.admin.EditEvent', compact('event'));
    }

    /* =======================
     | ✅ ADDED BACK
     | UPDATE EVENT
     ======================= */
    public function updateEvent(Request $request, $EventID)
    {
        $validated = $request->validate([
            'EventName' => 'required|string|max:255',
            'Location' => 'nullable|string|max:255',
            'StartDate' => 'nullable|date',
            'EndDate' => 'nullable|date|after_or_equal:StartDate',
            'Description' => 'nullable|string',
            'Status' => 'required|in:Open,Closed,Cancelled',
            'MaxGamesPerStudent' => 'nullable|integer|min:1',

            'games' => 'nullable|array',
            'games.*.GameID' => 'nullable|integer|exists:game_info,GameID',
            'games.*.GameName' => 'required|string|max:255',
            'games.*.Category' => 'required|string|max:100',
            'games.*.Capacity' => 'nullable|integer|min:1',
            'games.*.GameDate' => 'required|date',

            // ✅ ACCEPT HH:MM OR HH:MM:SS
            'games.*.TimeStart' => ['required',
            'regex:/^\d{2}:\d{2}(:\d{2})?$/'
            ],
            'games.*.TimeEnd' => ['required',
            'regex:/^\d{2}:\d{2}(:\d{2})?$/'
            ],
        ]);

        DB::beginTransaction();
        try {
            $event = Event::findOrFail($EventID);

            $event->update([
                'EventName' => $validated['EventName'],
                'Location' => $validated['Location'] ?? null,
                'StartDate' => $validated['StartDate'] ?? null,
                'EndDate' => $validated['EndDate'] ?? null,
                'Description' => $validated['Description'] ?? null,
                'Status' => $validated['Status'],
                'MaxGamesPerStudent' => $validated['MaxGamesPerStudent'] ?? null,
            ]);

            foreach ($validated['games'] ?? [] as $g) {

                // ✅ NORMALIZE TIME TO HH:MM:SS
                $timeStart = strlen($g['TimeStart']) === 5 ? $g['TimeStart'] . ':00' : $g['TimeStart'];
                $timeEnd   = strlen($g['TimeEnd']) === 5 ? $g['TimeEnd'] . ':00' : $g['TimeEnd'];

                if (!empty($g['GameID'])) {
                    GameInfo::where('GameID', $g['GameID'])->update([
                        'GameName' => $g['GameName'],
                        'Category' => $g['Category'],
                        'GameDate' => $g['GameDate'],
                        'TimeStart' => $timeStart,
                        'TimeEnd' => $timeEnd,
                        'Capacity' => $g['Capacity'] ?? null,
                    ]);
                } else {
                    GameInfo::create([
                        'EventID' => $event->EventID,
                        'GameName' => $g['GameName'],
                        'Category' => $g['Category'],
                        'GameDate' => $g['GameDate'],
                        'TimeStart' => $timeStart,
                        'TimeEnd' => $timeEnd,
                        'Capacity' => $g['Capacity'] ?? null,
                        'Status' => 'Open',
                    ]);
                    }
            }

            DB::commit();
                return redirect()->route('admin.events.list')
                    ->with('success', 'Event updated successfully.');

            } catch (\Exception $e) {
                DB::rollBack();
                return back()->withInput()->with('error', $e->getMessage());
            }
    }




    public function storeEvent(Request $request)
    {
        $validated = $request->validate([
            'EventName'   => 'required|string|max:255',
            'Location'    => 'nullable|string|max:255',
            'StartDate'   => 'nullable|date',
            'EndDate'     => 'nullable|date|after_or_equal:StartDate',
            'Description' => 'nullable|string',
            'Status'      => 'required|in:Open,Closed,Cancelled',
            'MaxGamesPerStudent' => 'nullable|integer|min:1',

            'games' => 'nullable|array',
            'games.*.GameName'  => 'required|string|max:255',
            'games.*.Category'  => 'required|string|max:100',
            'games.*.GameDate'  => 'required|date',
            'games.*.TimeStart' => 'required|date_format:H:i',
            'games.*.TimeEnd'   => 'required|date_format:H:i|after:games.*.TimeStart',
            'games.*.Capacity'  => 'nullable|integer|min:1',
        ]);

        DB::beginTransaction();
        try {
            $event = Event::create([
                'EventName' => $validated['EventName'],
                'Location'  => $validated['Location'] ?? null,
                'StartDate' => $validated['StartDate'] ?? null,
                'EndDate'   => $validated['EndDate'] ?? null,
                'Description' => $validated['Description'] ?? null,
                'Status'    => $validated['Status'],
                'MaxGamesPerStudent' => $validated['MaxGamesPerStudent'] ?? null,
                'CreatedBy' => $this->getUserId(),
            ]);

            foreach ($validated['games'] ?? [] as $g) {
                GameInfo::create([
                    'EventID'   => $event->EventID,
                    'GameName'  => $g['GameName'],
                    'Category'  => $g['Category'],
                    'GameDate'  => $g['GameDate'],
                    'TimeStart' => $g['TimeStart'],
                    'TimeEnd'   => $g['TimeEnd'],
                    'Capacity'  => $g['Capacity'] ?? null,
                    'Status'    => 'Open',
                ]);
            }

            DB::commit();
            return redirect()->route('admin.events.list')
                ->with('success', 'Event created successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    /* =========================================================
     | ADMIN : APPLICANTS
     ========================================================= */

    public function viewApplicantsByGame($GameID)
    {
        $game = GameInfo::with('event')->findOrFail($GameID);

        $applications = Application::with('user')
            ->where('GameID', $GameID)
            ->orderBy('DateApplied', 'asc')
            ->get();

        return view('application.admin.ViewApplicants', compact('game', 'applications'));
    }

    public function selectApplicant(Request $request, $ApplicationID)
    {
        $request->validate([
            'action' => 'required|in:approve,reject'
        ]);

        $application = Application::findOrFail($ApplicationID);

        if ($application->ApplicationStatus !== 'pending') {
            return back()->with('error', 'This application has already been processed.');
        }

        if ($request->action === 'approve') {
            $application->ApplicationStatus = 'approved';
            $application->SelectionStatus   = 'in_selection';
        } else {
            $application->ApplicationStatus = 'rejected';
            $application->SelectionStatus   = null;
        }

        $application->save();

        return back()->with('success', 'Application updated successfully.');
    }

    public function showApplication($ApplicationID)
    {
        $application = Application::with(['user', 'event', 'game'])->findOrFail($ApplicationID);
        return view('application.admin.ApplicationDetails', compact('application'));
    }

    /* =========================================================
     | STUDENT : APPLICATION FLOW
     ========================================================= */

    public function studentApplicationIndex()
    {
        $studentId = $this->getUserId();

        $events = Event::with(['games' => function ($q) use ($studentId) {
            $q->where('Status', 'Open')
              ->withCount(['applications as total_applied'])
              ->with(['applications' => function ($q2) use ($studentId) {
                  $q2->where('UserID', $studentId);
              }]);
        }])->where('Status', 'Open')->get();

        return view('application.student.AthleteApplication', compact('events'));
    }

    /* =======================
     | ✅ ADDED BACK
     | STUDENT EVENT DETAILS
     ======================= */
    public function studentEventShow($EventID)
    {
        $studentId = $this->getUserId();

        $event = Event::with(['games' => function ($q) use ($studentId) {
            $q->where('Status', 'Open')
              ->withCount(['applications as total_applied'])
              ->with(['applications' => function ($q2) use ($studentId) {
                  $q2->where('UserID', $studentId);
              }]);
        }])
        ->where('Status', 'Open')
        ->findOrFail($EventID);

        return view('application.student.EventDetails', compact('event'));
    }

    public function submitApplication(Request $request, $GameID)
    {
        $studentId = $this->getUserId();

        $game = GameInfo::with('event')->withCount('applications')->findOrFail($GameID);

        if ($game->Status !== 'Open') {
            return back()->with('error', 'This sport is no longer open.');
        }

        if (Application::where('UserID', $studentId)->where('GameID', $GameID)->exists()) {
            return back()->with('error', 'You have already applied.');
        }

        if ($game->event->MaxGamesPerStudent !== null) {
            $count = Application::where('UserID', $studentId)
                ->where('EventID', $game->EventID)
                ->whereIn('ApplicationStatus', ['pending', 'approved'])
                ->count();

            if ($count >= $game->event->MaxGamesPerStudent) {
                return back()->with('error', 'Maximum game limit reached for this event.');
            }
        }

        $existing = Application::where('UserID', $studentId)
            ->whereHas('game', function ($q) use ($game) {
                $q->where('GameDate', $game->GameDate)
                  ->where('TimeStart', '<', $game->TimeEnd)
                  ->where('TimeEnd', '>', $game->TimeStart);
            })->exists();

        if ($existing) {
            return back()->with('error', 'This sport clashes with another applied sport.');
        }

        if ($game->Capacity !== null && $game->applications_count >= $game->Capacity) {
            return back()->with('error', 'This sport has reached maximum capacity.');
        }

        Application::create([
            'UserID'            => $studentId,
            'EventID'           => $game->EventID,
            'GameID'            => $game->GameID,
            'ApplicationStatus' => 'pending',
            'SelectionStatus'   => 'in_selection',
            'DateApplied'       => now(),
        ]);

        return back()->with('success', 'Application submitted successfully.');
    }

    public function studentApplicationsStatus()
    {
        $studentId = $this->getUserId();

        $events = Event::with(['games.applications' => function ($q) use ($studentId) {
            $q->where('UserID', $studentId)
              ->orderBy('DateApplied', 'desc');
        }])->whereHas('games.applications', function ($q) use ($studentId) {
            $q->where('UserID', $studentId);
        })->get();

        return view('Status.Student.StatusUpdate', compact('events'));
    }
}
