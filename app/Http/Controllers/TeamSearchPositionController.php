<?php

namespace App\Http\Controllers;

use App\Http\Service\TeamService;
use App\Models\TeamSearchPosition;
use Illuminate\Http\Request;

class TeamSearchPositionController extends Controller
{
    public TeamService $teamService;

    public function __construct()
    {
        $this->teamService = new TeamService();
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function store(Request $request, int $teamId)
    {
        $this->validate($request, [
            'gamePositionId' => 'required|array',
            'allowApplication' => 'required|int',
        ]);

        $data = $request->only([
            'gamePositionId',
            'allowApplication'
        ]);

        $update = [
            'allow_application' => $data['allowApplication']
        ];

        $this->teamService->updateWhereId($teamId, $update);

        TeamSearchPosition::where('team_id', $teamId)->delete();

        foreach ($data['gamePositionId'] as $gamePositionId) {
            TeamSearchPosition::withTrashed()->updateOrCreate([
                'team_id' => $teamId,
                'game_position_id' => $gamePositionId,
            ], [
                'deleted_at' => 'NULL'
            ]);
        }

        return redirect()->route('system.team-player.index', [$teamId]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
