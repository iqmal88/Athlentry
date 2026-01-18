<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\GameInfo;

class GameInfoController extends Controller
{
    // =======================
    // ADMIN GAME INFO
    // =======================

    public function index()
    {
        $events = Event::with(['games' => function($q){
            $q->orderBy('GameDate')
              ->orderBy('TimeStart');
        }])
        ->orderBy('StartDate','desc')
        ->get();

        return view('GameInfo.Admin.ListGameInfo', compact('events'));
    }

    public function show($GameID)
    {
        $game = GameInfo::with('event')->findOrFail($GameID);
        return view('GameInfo.Admin.ShowGameInfo', compact('game'));
    }

    public function edit($GameID)
    {
        $game = GameInfo::with('event')->findOrFail($GameID);
        return view('GameInfo.Admin.EditGameInfo', compact('game'));
    }

    public function update(Request $request, $GameID)
    {
        $data = $request->validate([
            'GameName'        => 'required|string|max:255',
            'Category'        => 'nullable|string|max:100',
            'Capacity'        => 'nullable|integer|min:0',

            'GameDate'        => 'required|date',
            'TimeStart'       => 'required|date_format:H:i',
            'TimeEnd'         => 'required|date_format:H:i|after:TimeStart',

            'GameVenue'       => 'nullable|string|max:255',
            'PICName'       => 'nullable|string|max:255',
            'PICPhone'      => 'nullable|string|max:50',
            'Rules'           => 'nullable|string',
            'Description'     => 'nullable|string',

            'Status'          => 'required|in:Open,Closed,Cancelled',
        ]);

        $game = GameInfo::findOrFail($GameID);
        $game->update($data);

        return redirect()
            ->route('admin.gameinfo.show', $game->GameID)
            ->with('success', 'Game information updated successfully.');
    }

    public function destroy($GameID)
    {
        GameInfo::findOrFail($GameID)->delete();

        return redirect()
            ->route('admin.gameinfo.index')
            ->with('success','Game deleted.');
    }

    // =======================
    // STUDENT GAME INFO
    // =======================

    public function studentIndex()
    {
        $events = Event::with(['games' => function ($q) {
            $q->where('Status', 'Open')
              ->orderBy('GameDate')
              ->orderBy('TimeStart');
        }])
        ->where('Status', 'Open')
        ->orderBy('StartDate', 'desc')
        ->get();

        return view('GameInfo.Student.AthleteListGameInfo', compact('events'));
    }

    public function studentShow($GameID)
    {
        $game = GameInfo::with('event')
            ->where('Status', 'Open')
            ->findOrFail($GameID);

        return view('GameInfo.Student.AthleteShowGameInfo', compact('game'));
    }
}
