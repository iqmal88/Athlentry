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
    | EVENT MANAGEMENT
    |--------------------------------------------------------------------------
    */

    /**
     * List all events (with games and applications_count for each game)
     */
    public function listEvents()
    {
        // Load events with their games; each game includes applications_count
        $events = Event::with(['games' => function($q){
            $q->withCount('applications');
        }])->orderBy('StartDate','desc')->get();

        return view('application.admin.ListEvent', compact('events'));
    }

    /**
     * Show create event form
     */
    public function createEvent()
    {
        // If you want to show available games to associate, keep this.
        $availableGames = GameInfo::whereNull('EventID')->orderBy('GameName')->get();

        return view('application.admin.AddEvent', compact('availableGames'));
    }

    /**
     * Store event + minimal games (GameName, Category, Capacity)
     */
    public function storeEvent(Request $request)
    {
        $rules = [
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
        ];

        $validated = $request->validate($rules);

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

            // Create minimal game_info entries linked to this event
            if (!empty($validated['games']) && is_array($validated['games'])) {
                foreach ($validated['games'] as $g) {
                    if (empty($g['GameName'])) continue;

                    GameInfo::create([
                        'EventID' => $event->EventID,
                        'GameName' => $g['GameName'],
                        'Category' => $g['Category'] ?? null,
                        'Capacity' => $g['Capacity'] ?? null,
                        'Status'   => 'Open',
                        // other fields left null for later editing in GameInfo module
                        'GameDate' => null,
                        'GameTime' => null,
                        'SelectionPlace' => null,
                        'CoachName' => null,
                        'CoachPhone' => null,
                        'Rules' => null,
                        'Description' => null,
                    ]);
                }
            }

            DB::commit();

            // Redirect to Edit Event page so admin can continue editing games/details
            return redirect()->route('admin.events.edit', $event->EventID)
                             ->with('success','Event and games created successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                             ->withInput()
                             ->with('error', 'Failed to create event: '.$e->getMessage());
        }
    }

    /**
     * Show Edit Event page (event fields + list of games + ability to add new simple games)
     */
    public function editEvent($EventID)
    {
        $event = Event::with('games')->where('EventID', $EventID)->firstOrFail();
        return view('application.admin.EditEvent', compact('event'));
    }

    /**
     * Update Event and sync/create simple game rows.
     *
     * Accepts games[] where each item may include:
     * - GameID (optional) => update existing game
     * - GameName, Category, Capacity => update/create fields
     */
    public function updateEvent(Request $request, $EventID)
    {
        $rules = [
            'EventName' => 'required|string|max:255',
            'Location'  => 'nullable|string|max:255',
            'StartDate' => 'nullable|date',
            'EndDate'   => 'nullable|date|after_or_equal:StartDate',
            'Description' => 'nullable|string',
            'Status'    => 'nullable|in:Open,Closed,Cancelled',

            'games' => 'nullable|array',
            'games.*.GameID' => 'nullable|integer|exists:game_info,GameID',
            'games.*.GameName' => 'required_with:games|string|max:255',
            'games.*.Category' => 'nullable|string|max:100',
            'games.*.Capacity' => 'nullable|integer|min:0',
        ];

        $validated = $request->validate($rules);

        DB::beginTransaction();
        try {
            // update event
            $event = Event::findOrFail($EventID);
            $event->update([
                'EventName' => $validated['EventName'],
                'Location'  => $validated['Location'] ?? null,
                'StartDate' => $validated['StartDate'] ?? null,
                'EndDate'   => $validated['EndDate'] ?? null,
                'Description' => $validated['Description'] ?? null,
                'Status'    => $validated['Status'] ?? $event->Status,
            ]);
            
            // handle games
            if (!empty($validated['games']) && is_array($validated['games'])) {
                foreach ($validated['games'] as $g) {
                    // if GameID present -> update existing game (ensure it belongs to this event or allow move)
                    if (!empty($g['GameID'])) {
                        $game = GameInfo::where('GameID', $g['GameID'])->first();
                        if ($game) {
                            // Only update fields we care about (minimal)
                            $game->update([
                                'GameName' => $g['GameName'],
                                'Category' => $g['Category'] ?? null,
                                'Capacity' => $g['Capacity'] ?? null,
                                // ensure EventID remains this event
                                'EventID'  => $event->EventID,
                            ]);
                        }
                    } else {
                        // create a new minimal game linked to the event
                        GameInfo::create([
                            'EventID' => $event->EventID,
                            'GameName' => $g['GameName'],
                            'Category' => $g['Category'] ?? null,
                            'Capacity' => $g['Capacity'] ?? null,
                            'Status' => 'Open',
                            // other fields left null
                        ]);
                    }
                }
            }

            DB::commit();
            return redirect()->route('admin.events.list')->with('success', 'Event updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Failed to update: ' . $e->getMessage());
        }
    }

    /*
    |--------------------------------------------------------------------------
    | APPLICANT (GAME) VIEWS & ACTIONS
    |--------------------------------------------------------------------------
    */

    /**
     * Show all applicants for a given GameID (page: ViewApplicants)
     */
    public function viewApplicantsByGame($GameID)
    {
        $game = GameInfo::with('event')->where('GameID', $GameID)->firstOrFail();

        $applications = Application::with('user')
            ->where('GameID', $GameID)
            ->orderBy('DateApplied', 'asc')
            ->get();

        $capacity = $game->Capacity ?? null;

        return view('application.admin.ViewApplicants', compact('game','applications','capacity'));
    }

    /**
     * Admin selects an applicant (sets StatusID or other flag)
     */
    public function selectApplicant(Request $request, $ApplicationID)
    {
        $application = Application::with('game')->findOrFail($ApplicationID);

        // Replace with your real "selected" StatusID if you have statuses table
        $selectedStatusId = $request->input('StatusID', 2);

        $application->StatusID = $selectedStatusId;
        $application->save();

        return redirect()->back()->with('success', 'Applicant selected successfully.');
    }

    /*
    |--------------------------------------------------------------------------
    | APPLICATION MANAGEMENT
    |--------------------------------------------------------------------------
    */

    /**
     * List all applications (optionally filtered)
     */
    public function listApplications(Request $request)
    {
        $query = Application::with(['user','game','event']);

        if ($request->EventID) {
            $query->where('EventID', $request->EventID);
        }

        if ($request->GameID) {
            $query->where('GameID', $request->GameID);
        }

        $applications = $query->orderBy('DateApplied','desc')->paginate(20);

        return view('application.admin.ListApplication', compact('applications'));
    }

    /**
     * Show a single application detail
     */
    public function showApplication($ApplicationID)
    {
        $application = Application::with(['user','game','event'])
            ->findOrFail($ApplicationID);

        return view('application.admin.ShowApplication', compact('application'));
    }

    /**
     * Update application status
     */
    public function updateStatus(Request $request, $ApplicationID)
    {
        $request->validate([
            'StatusID' => 'required|integer'
        ]);

        $application = Application::findOrFail($ApplicationID);
        $application->StatusID = $request->StatusID;
        $application->save();

        return back()->with('success','Application status updated.');
    }
}
