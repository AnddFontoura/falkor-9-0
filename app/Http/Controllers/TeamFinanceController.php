<?php

namespace App\Http\Controllers;

use App\Enums\FinanceEnum;
use App\Models\MatchHasPlayer;
use App\Models\Team;
use App\Models\TeamFinance;
use App\Models\TeamPlayer;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\Factory;
use Illuminate\View\View;

class TeamFinanceController extends Controller
{
    public string $viewFolder = 'system/team-finance';
    public string $saveRedirect = 'system.team-finance.index';

    public function index(Request $request, int $teamId): Factory|View|Application
    {
        $team = Team::where('id', $teamId)->first();

        $debitAmount = TeamFinance::where('team_id', $teamId)
            ->where('type', FinanceEnum::DEBIT)
            ->sum('value');

        $creditAmount = TeamFinance::where('team_id', $teamId)
            ->where('type', FinanceEnum::CREDIT)
            ->sum('value');

        $total = $debitAmount - $creditAmount;

        $teamFinances = TeamFinance::where('team_id', $teamId)
            ->orderBy('created_at', 'desc')
            ->paginate();

        return view($this->viewFolder . '.index',
            compact(
                'teamFinances',
                'team',
                'debitAmount',
                'creditAmount',
                'total'
            )
        );
    }

    public function form(int $teamId, int $teamFinanceId = null): Factory|View|Application
    {
        $team = Team::where('id', $teamId)->first();
        $teamFinanceInformation = null;
        $financeTypes = FinanceEnum::SELECT_TYPE;
        $financeOrigins = FinanceEnum::SELECT_FORM_ORIGINS;
        $teamPlayers = TeamPlayer::where('team_id', $teamId)
            ->where('active', true)
            ->get();

        if ($teamFinanceId) {
            $teamFinanceInformation = TeamFinance::where('id', $teamFinanceId)
                ->where('team_id', $teamId)
                ->first();
        }

        return view($this->viewFolder . '.form',
            compact (
                'team',
                'teamFinanceInformation',
                'financeTypes',
                'financeOrigins',
                'teamPlayers',
            )
        );
    }

    public function store(Request $request, $teamId, $teamFinanceId = null): RedirectResponse
    {
        $this->validate($request, [
            'financeOrigin' => 'required|string',
            'financeType' => 'required|integer',
            'financePlayerId' => 'required|integer',
            'financeDescription' => 'required|string',
            'financeValue' => 'required|regex:/[0-9]{1,6},[0-9]{1,2}/',
        ]);

        $data = $request->only(
            'financeOrigin',
            'financeType',
            'financePlayerId',
            'financeDescription',
            'financeValue'
        );

        if ($teamFinanceId) {

            $teamFinance = TeamFinance::where('id', $teamFinanceId)
                ->where('team_id', $teamId)
                ->first();

            if (!$teamFinance) {
                return back()->withErrors('Algo errado nos dados desse registro');
            }

            TeamFinance::where('id', $teamFinanceId)->update([
               'team_id' => $teamId,
               'team_player_id' => $data['financePlayerId'] ?? null,
               'type' => $data['financeType'],
               'origin' => $data['financeOrigin'],
               'description' => $data['financeDescription'],
               'value' => str_replace(',', '.', $data['financeValue']),
            ]);

            $message = "Dado atualizado com sucesso";
        } else {
            TeamFinance::create([
                'team_id' => $teamId,
                'team_player_id' => $data['financePlayerId'] ?? null,
                'type' => $data['financeType'],
                'origin' => $data['financeOrigin'],
                'description' => $data['financeDescription'],
                'value' => str_replace(',', '.', $data['financeValue']),
            ]);
            $message = "Dado inserido com sucesso";
        }

        return redirect()
            ->route('system.team-finance.index', [$teamId])
            ->with('success', $message);
    }

    public function matches(int $teamId, int $matchId): Factory|View|Application
    {
        $teamMatchPlayers = MatchHasPlayer::select('match_has_players.*','team_finances.value as finance_value')
            ->join('team_players', 'team_players.id', '=', 'match_has_players.team_player_id')
            ->leftJoin('team_finances', 'team_finances.team_player_id', '=', 'team_players.id')
            ->where('match_has_players.match_id', $matchId)
            ->where('team_players.team_id', $teamId)
            ->where(function ($query) use ($matchId) {
                $query->where('team_finances.match_id', $matchId)
                    ->orWhereNull('team_finances.match_id');
            })
            ->where(function ($query) {
                $query->where('match_has_players.confirmed', true)
                    ->orWhere('match_has_players.showed_up', true);
            })
            ->get();

        $fieldValueInfo = TeamFinance::where('match_id', $matchId)
            ->where('team_id', $teamId)
            ->whereNull('team_player_id')
            ->where('origin', FinanceEnum::FIELD_VALUE)
            ->first();

        $refereeValueInfo = TeamFinance::where('match_id', $matchId)
            ->where('team_id', $teamId)
            ->whereNull('team_player_id')
            ->where('origin', FinanceEnum::REFEREE_VALUE)
            ->first();

        $otherValueInfo = TeamFinance::where('match_id', $matchId)
            ->where('team_id', $teamId)
            ->whereNull('team_player_id')
            ->where('origin', FinanceEnum::OTHER_VALUE)
            ->first();

        $team = Team::where('id', $teamId)->first();

        return view($this->viewFolder . '.matches',
            compact(
                'teamMatchPlayers',
                'fieldValueInfo',
                'refereeValueInfo',
                'otherValueInfo',
                'team',
                'matchId'
            )
        );
    }

    public function matchesSave(Request $request, int $teamId, int $matchId): RedirectResponse
    {
        $this->validate($request, [
            'fieldValue' => 'nullable|regex:/[0-9]{1,6},[0-9]{1,2}/',
            'refereesValue' => 'nullable|regex:/[0-9]{1,6},[0-9]{1,2}/',
            'otherValue' => 'nullable|regex:/[0-9]{1,6},[0-9]{1,2}/',
            'otherDescription' => 'nullable|string',
            'teamPlayerId' => 'nullable|array'
        ]);

        $data = $request->only(
            [
                'fieldValue',
                'refereesValue',
                'otherValue',
                'otherDescription',
                'teamPlayerId'
            ]
        );

        if (isset($data['fieldValue'])) {
            TeamFinance::updateOrCreate(
                [
                    'match_id' => $matchId,
                    'team_id' => $teamId,
                    'origin' => FinanceEnum::FIELD_VALUE,
                ],
                [
                    'value' => str_replace(',', '.', $data['fieldValue']),
                    'type' => FinanceEnum::DEBIT,
                ]
            );
        }

        if ($data['refereesValue']) {
            TeamFinance::updateOrCreate(
                [
                    'match_id' => $matchId,
                    'team_id' => $teamId,
                    'origin' => FinanceEnum::REFEREE_VALUE,
                ],
                [
                    'value' => str_replace(',', '.', $data['refereesValue']),
                    'type' => FinanceEnum::DEBIT,
                ]
            );
        }

        if(isset($data['otherValue'])) {
            TeamFinance::updateOrCreate(
                [
                    'match_id' => $matchId,
                    'team_id' => $teamId,
                    'origin' => FinanceEnum::OTHER_VALUE,
                ],
                [
                    'value' => str_replace(',', '.', $data['otherValue']),
                    'description' => $data['otherDescription'],
                    'type' => FinanceEnum::DEBIT,
                ]
            );
        }

        if(isset($data['teamPlayerId'])) {
            foreach($data['teamPlayerId'] as $teamPlayerId => $value) {
                if (isset($value)) {
                    TeamFinance::updateOrCreate(
                        [
                            'match_id' => $matchId,
                            'team_id' => $teamId,
                            'team_player_id' => $teamPlayerId,
                            'origin' => FinanceEnum::MATCH_PAYMENT_VALUE,
                        ],
                        [
                            'value' => str_replace(',', '.', $value),
                            'type' => FinanceEnum::CREDIT,
                        ]
                    );
                }
            }
        }

        return redirect()
            ->route('system.team.matches', ['teamId' => $teamId])
            ->with('success', 'Dados financeiros atualizados com sucesso');
    }
}
