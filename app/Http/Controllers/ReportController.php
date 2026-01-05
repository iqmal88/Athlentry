<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Event;
use App\Models\GameInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ApplicantsExport;
use App\Exports\SelectedAthletesExport;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        /* =========================
         | FILTERS
         ========================= */
        $eventId = $request->event;
        $gameId = $request->game;

        $applicationsQuery = Application::query();

        if ($eventId) {
            $applicationsQuery->where('EventID', $eventId);
        }

        if ($gameId) {
            $applicationsQuery->where('GameID', $gameId);
        }

        /* =========================
         | SUMMARY STATS
         ========================= */
        $totalApplications = $applicationsQuery->count();
        $approvedApplications = (clone $applicationsQuery)
            ->where('ApplicationStatus', 'approved')->count();

        $rejectedApplications = (clone $applicationsQuery)
            ->where('ApplicationStatus', 'rejected')->count();

        $selectedAthletes = (clone $applicationsQuery)
            ->where('SelectionStatus', 'selected')->count();

        /* =========================
         | CHART DATA
         ========================= */

        // Applications by Event
        $applicationsByEvent = Application::select(
                'EventID',
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('EventID')
            ->with('event')
            ->get();

        // Selection Outcome
        $selectionStats = Application::select(
                'SelectionStatus',
                DB::raw('COUNT(*) as total')
            )
            ->whereNotNull('SelectionStatus')
            ->groupBy('SelectionStatus')
            ->get();

        /* =========================
         | FILTER DATA
         ========================= */
        $events = Event::all();
        $games = GameInfo::all();

        return view('reports.admin.Index', compact(
            'totalApplications',
            'approvedApplications',
            'rejectedApplications',
            'selectedAthletes',
            'applicationsByEvent',
            'selectionStats',
            'events',
            'games'
        ));
    }

    /* =========================
     | EXPORT
     ========================= */

    public function exportApplicants()
    {
        return Excel::download(new ApplicantsExport, 'all_applicants.xlsx');
    }

    public function exportSelected()
    {
        return Excel::download(new SelectedAthletesExport, 'selected_athletes.xlsx');
    }
}
