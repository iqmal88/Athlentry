<?php

namespace App\Http\Controllers;

use App\Models\GameInfo;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GameInfoController extends Controller
{
    /**
     * STUDENT PAGE - list games grouped by event (public)
     */
    public function studentIndex()
    {
        $events = Event::with(['games' => function($q){
            $q->where('Status', 'Open')->orderBy('GameDate');
        }])->orderByDesc('StartDate')->get();

        return view('Game.Student.homepage', compact('events'));
    }

    /**
     * STUDENT PAGE - show single game details (read-only)
     */
    public function showForStudent(GameInfo $game)
    {
        $game->load('event');
        return view('Game.Student.ViewGame', compact('game'));
    }

    /**
     * ADMIN PAGE - manage games (grouped by event)
     */
    public function adminIndex()
    {
        $events = Event::with(['games' => function($q){
            $q->orderBy('GameDate')->orderBy('GameName');
        }])->orderByDesc('StartDate')->get();

        return view('GameInfo.Admin.ListGames', compact('events'));
    }

    /**
     * Show Add Game form (admin)
     */
    public function create()
    {
        $events = Event::orderByDesc('StartDate')->get();
        return view('GameInfo.Admin.AddGame', compact('events'));
    }

    /**
     * Store game (admin)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'EventID'        => 'nullable|exists:events,EventID',
            'GameName'       => 'required|string|max:255',
            'Category'       => 'nullable|string|max:100',
            'GameDate'       => 'nullable|date',
            'GameTime'       => 'nullable',
            'SelectionPlace' => 'nullable|string|max:255',
            'CoachName'      => 'nullable|string|max:255',
            'CoachPhone'     => 'nullable|string|max:20',
            'Capacity'       => 'nullable|integer|min:1',
            'Rules'          => 'nullable|string',
            'Description'    => 'nullable|string',
            'Status'         => 'nullable|in:Open,Closed,Cancelled',
        ]);

        GameInfo::create($validated);

        return redirect()->route('admin.games.index')->with('success', 'Game added.');
    }

    /**
     * Show game for admin (detail + applicants link)
     */
    public function showForAdmin(GameInfo $game)
    {
        $game->load(['event','applications.user','applications.status']);
        return view('GameInfo.Admin.ShowGame', compact('game'));
    }

    /**
     * Show edit form (admin)
     */
    public function edit(GameInfo $game)
    {
        $events = Event::orderByDesc('StartDate')->get();
        return view('GameInfo.Admin.EditGame', compact('game','events'));
    }

    /**
     * Update game (admin)
     */
    public function update(Request $request, GameInfo $game)
    {
        $validated = $request->validate([
            'EventID'        => 'nullable|exists:events,EventID',
            'GameName'       => 'required|string|max:255',
            'Category'       => 'nullable|string|max:100',
            'GameDate'       => 'nullable|date',
            'GameTime'       => 'nullable',
            'SelectionPlace' => 'nullable|string|max:255',
            'CoachName'      => 'nullable|string|max:255',
            'CoachPhone'     => 'nullable|string|max:20',
            'Capacity'       => 'nullable|integer|min:1',
            'Rules'          => 'nullable|string',
            'Description'    => 'nullable|string',
            'Status'         => 'nullable|in:Open,Closed,Cancelled',
        ]);

        $game->update($validated);

        return redirect()->route('admin.games.show', $game->GameID)->with('success', 'Game updated.');
    }

    /**
     * Destroy game (admin)
     */
    public function destroy(GameInfo $game)
    {
        if ($game->applications()->exists()) {
            return back()->with('error', 'Cannot delete a game with existing applications.');
        }

        $game->delete();
        return redirect()->route('admin.games.index')->with('success', 'Game deleted.');
    }
}
