<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Application;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Show report dashboard (admin)
     */
    public function index()
    {
        /* =========================
         | SUMMARY STATS
         ========================= */

        $totalApplications = Application::count();
        $approvedApplications = Application::where('ApplicationStatus', 'approved')->count();
        $rejectedApplications = Application::where('ApplicationStatus', 'rejected')->count();
        $selectedAthletes = Application::where('SelectionStatus', 'selected')->count();

        /* =========================
         | APPLICATIONS BY EVENT
         ========================= */
        $applicationsByEvent = Event::withCount([
            'games as applications_count' => function ($q) {
                $q->join('applications', 'game_info.GameID', '=', 'applications.GameID');
            }
        ])->get();

        /* =========================
         | SELECTION OUTCOME
         ========================= */
        $selectionStats = Application::select(
            'SelectionStatus',
            DB::raw('COUNT(*) as total')
        )
        ->whereNotNull('SelectionStatus')
        ->groupBy('SelectionStatus')
        ->get();

        return view('reports.admin.Index', compact(
            'totalApplications',
            'approvedApplications',
            'rejectedApplications',
            'selectedAthletes',
            'applicationsByEvent',
            'selectionStats'
        ));
    }

    /**
     * Store generated report snapshot (optional)
     */
    public function store(Request $request)
    {
        Report::create([
            'Content' => $request->input('content'),
            'CreatedDate' => now(),
            'UserID' => Auth::id(),
            'ApplicationID' => $request->input('ApplicationID'),
        ]);

        return back()->with('success', 'Report generated successfully.');
    }
}
