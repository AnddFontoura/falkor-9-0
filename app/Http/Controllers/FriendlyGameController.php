<?php

namespace App\Http\Controllers;

use App\Enums\GenderEnum;
use App\Http\Requests\FriendlyGameCreateOrUpdateRequest;
use App\Http\Requests\FriendlyGameFilterRequest;
use App\Models\FriendlyGame;
use App\Models\Team;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class FriendlyGameController extends Controller
{
    public string $viewFolder = 'system.friendly-game.';
    public function index(FriendlyGameFilterRequest $request): View
    {
        $filter = $request->validated();

        $cities = $this->cityService->getOrderedByName();
        $states = $this->stateService->getOrderedByName();
        $teamGender = GenderEnum::GENDER_TEAM_ARRAY;
        $modalities = $this->modalityService->getOrderedByName();

        $friendlyGames = FriendlyGame::select('friendly_games.*');

        if (isset($filter['matchCityId'])) {
            $friendlyGames = $friendlyGames->where(
                'city_id',
                $filter['matchCityId']
            );
        }

        $friendlyGames = $friendlyGames->paginate();

        return view($this->viewFolder . 'index', compact(
            'friendlyGames',
            'cities',
            'states',
            'teamGender',
            'modalities'
        ));
    }

    public function form(int $friendlyGameId = null)
    {
        $friendlyGame = null;
        $user = Auth::user();

        $ownedTeams = Team::where('user_id', $user->id)
            ->orderBy('name', 'asc')
            ->get();

        if (!$ownedTeams) {
            return redirect()
                    ->back()
                    ->with(['error' => 'Para criar um amistoso você deve ter um time cadastrado no sistema.']);
        }

        $cities = $this->cityService->getOrderedByName();

        if ($friendlyGameId) {
            $friendlyGame = FriendlyGame::where('id', $friendlyGameId)
                ->first();
        }

        return view($this->viewFolder . 'form',
            compact(
                'cities',
                'friendlyGame',
                'ownedTeams',
            )
        );
    }

    public function store(FriendlyGameCreateOrUpdateRequest $request, int $friendlyGameId = null)
    {
        $data = $request->validated();

        if (!$friendlyGameId) {
            FriendlyGame::create([
                'team_id' => $data['ownedTeamId'],
                'city_id' => $data['cityId'],
                'description' => $data['matchDescription'] ?? '',
                'price' => str_replace(',', '.', $data['matchCost']),
                'match_date' => $data['matchDate'],
                'start_at' => $data['matchStart'],
                'duration' => $data['matchDuration'],
                'main_uniform_color' => $data['teamFirstUniform'],
                'secondary_uniform_color' => $data['teamSecondUniform'],
            ]);

            $message = "Amistoso criado com sucesso!";
        } else {
            FriendlyGame::where('id', $friendlyGameId)->update([
                'team_id' => $data['ownedTeamId'],
                'city_id' => $data['cityId'],
                'description' => $data['matchDescription'] ?? '',
                'price' => $data['matchCost'],
                'match_date' => str_replace(',', '.', $data['matchDate']),
                'start_at' => $data['matchStart'],
                'duration' => $data['matchDuration'],
                'main_uniform_color' => $data['teamFirstUniform'],
                'secondary_uniform_color' => $data['teamSecondUniform'],
            ]);

            $message = "Amistoso atualizado com sucesso";
        }
        return redirect()->route('system.friendly-game.index')->with("success", $message);
    }

    public function show(int $friendlyGameId): View
    {
        $user = Auth::user();
        $friendlyGame = FriendlyGame::where('id', $friendlyGameId)->first();

        $subSelect = "
            SELECT
                opponent_id
            FROM friendly_game_opponents
            WHERE friendly_game_id = $friendlyGameId
        ";

        $ownedTeams = Team::where('user_id', $user->id)
            ->whereRaw('id not in (' . $subSelect . ')')
            ->orderBy('name', 'asc')
            ->get();

        return view($this->viewFolder . 'show', compact(
            'friendlyGame',
            'ownedTeams',
        ));
    }
}
