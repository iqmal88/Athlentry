<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\Event;
use App\Models\GameInfo;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    /**
     * =========================
     * REPORT DASHBOARD
     * =========================
     */
    public function index(Request $request)
    {
        /* =========================
         | FILTER INPUT
         ========================= */
        $eventId = $request->get('event');
        $gameId  = $request->get('game');

        $applications = Application::query();

        if ($eventId) {
            $applications->where('EventID', $eventId);
        }

        if ($gameId) {
            $applications->where('GameID', $gameId);
        }

        /* =========================
         | SUMMARY STATS
         ========================= */
        $totalApplications = (clone $applications)->count();

        $approvedApplications = (clone $applications)
            ->where('ApplicationStatus', 'approved')
            ->count();

        $rejectedApplications = (clone $applications)
            ->whereIn('ApplicationStatus', ['rejected', 'withdrawn'])
            ->count();

        $selectedAthletes = (clone $applications)
            ->where('SelectionStatus', 'selected')
            ->count();

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

        // Selection outcome (pie chart)
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
        $events = Event::orderBy('EventName')->get();
        $games  = GameInfo::orderBy('GameName')->get();

        return view('Report.ViewReport', compact(
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

    /**
     * =========================
     * EXPORT ALL APPLICANTS (CSV)
     * =========================
     */
    public function exportApplicantsCSV(Request $request)
    {
        $eventId = $request->get('event');
        $gameId  = $request->get('game');

        $applications = Application::with(['user', 'event', 'game']);

        if ($eventId) {
            $applications->where('EventID', $eventId);
        }

        if ($gameId) {
            $applications->where('GameID', $gameId);
        }

        $applications = $applications->get();

        $filename = 'all_applicants.csv';

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($applications) {
            $file = fopen('php://output', 'w');

            // CSV Header
            fputcsv($file, [
                'Student Name',
                'Matric No',
                'Event',
                'Game',
                'Application Status',
                'Selection Status',
                'Applied Date',
            ]);

            foreach ($applications as $app) {
                fputcsv($file, [
                    $app->user->Name ?? '-',
                    $app->user->MatricNo ?? '-',
                    $app->event->EventName ?? '-',
                    $app->game->GameName ?? '-',
                    ucfirst($app->ApplicationStatus ?? 'pending'),
                    ucfirst($app->SelectionStatus ?? '-'),
                    optional($app->DateApplied)->format('d-m-Y H:i'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * =========================
     * EXPORT SELECTED ATHLETES (CSV)
     * =========================
     */
    public function exportSelectedCSV(Request $request)
    {
        $eventId = $request->get('event');
        $gameId  = $request->get('game');

        $applications = Application::with(['user', 'event', 'game'])
            ->where('SelectionStatus', 'selected');

        if ($eventId) {
            $applications->where('EventID', $eventId);
        }

        if ($gameId) {
            $applications->where('GameID', $gameId);
        }

        $applications = $applications->get();

        $filename = 'selected_athletes.csv';

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($applications) {
            $file = fopen('php://output', 'w');

            fputcsv($file, [
                'Student Name',
                'Event',
                'Game',
            ]);

            foreach ($applications as $app) {
                fputcsv($file, [
                    $app->user->Name ?? '-',
                    $app->event->EventName ?? '-',
                    $app->game->GameName ?? '-',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportSelectedPDF(Request $request)
    {
        $eventId = $request->get('event');
        $gameId  = $request->get('game');

        $applications = Application::with(['user', 'event', 'game'])
            ->where('SelectionStatus', 'selected');

        if ($eventId) {
            $applications->where('EventID', $eventId);
        }

        if ($gameId) {
            $applications->where('GameID', $gameId);
        }

        $applications = $applications->get();

        $pdf = Pdf::loadView('Report.SelectedAthletes',compact('applications'))->setPaper('A4', 'portrait');

        return $pdf->download('final_selected_athletes.pdf');
    }
}
