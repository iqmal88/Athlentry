<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\GameInfo;

class GameInfoController extends Controller
{
    // Landing: list events with their games
    public function index()
    {
        $events = Event::with(['games' => function($q){
            $q->orderBy('GameName')
              ->with('event'); // important for final_status
        }])->orderBy('StartDate','desc')->get();

        return view('gameinfo.admin.ListGameInfo', compact('events'));
    }

    // Show a single game details
    public function show($GameID)
    {
        $game = GameInfo::with('event')->findOrFail($GameID);
        return view('gameinfo.admin.ShowGameInfo', compact('game'));
    }

    // Edit form
    public function edit($GameID)
    {
        $game = GameInfo::with('event')->findOrFail($GameID);
        return view('gameinfo.admin.EditGameInfo', compact('game'));
    }
    
    protected $casts = [
    'GameDate' => 'date',
    ];

    // Update game
    public function update(Request $request, $GameID)
    {
        $data = $request->validate([
            'GameName' => 'required|string|max:255',
            'Category' => 'nullable|string|max:100',
            'Capacity' => 'nullable|integer|min:0',
            'GameDate' => 'nullable|date',
            'SelectionPlace' => 'nullable|string|max:255',
            'CoachName' => 'nullable|string|max:255',
            'CoachPhone' => 'nullable|string|max:50',
            'Rules' => 'nullable|string',
            'Description' => 'nullable|string',
            'Status' => 'nullable|in:Open,Closed,Cancelled',
        ]);

        $game = GameInfo::findOrFail($GameID);
        $game->update($data);

        return redirect()->route('admin.gameinfo.show', $game->GameID)
                         ->with('success','Game information updated.');
    }

    // Destroy
    public function destroy($GameID)
    {
        $game = GameInfo::findOrFail($GameID);
        $game->delete();
        return redirect()->route('admin.gameinfo.index')->with('success','Game deleted.');
    }

    // =======================
    // STUDENT GAME INFO
    // =======================

    /**
    * Student – List events with open games
    */
    public function studentIndex()
    {
        $events = Event::with(['games' => function ($q) {
                $q->where('Status', 'Open')
                ->orderBy('GameName');
        }])
        ->where('Status', 'Open')
        ->orderBy('StartDate', 'desc')
        ->get();

        return view('gameinfo.student.AthleteListGameInfo', compact('events'));
    }

    /**
    * Student – View single game info (read-only)
    */
    public function studentShow($GameID)
    {
        $game = GameInfo::with('event')
                ->where('Status', 'Open')
                ->findOrFail($GameID);

        return view('gameinfo.student.AthleteShowGameInfo', compact('game'));
    }
}
