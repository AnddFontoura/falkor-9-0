<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GamePosition;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

class GamePositionController extends Controller
{
    protected string $viewFolder = 'system.admin.game-position';

    protected string $saveRedirect = 'admin/game-position';

    public function index(Request $request): View
    {
        $this->validate($request, [
            'gamePositionId' => 'nullable|integer',
            'gamePositionName' => 'nullable|string',
        ]);

        $filter = $request->only([
            'gamePositionId',
            'gamePositionName',
        ]);

        $gamePositions = GamePosition::select();

        if (isset($filter['gamePositionId'])) {
            $gamePositions = $gamePositions->where('id', $filter['gamePositionId']);
        }

        if (isset($filter['gamePositionName'])) {
            $gamePositions = $gamePositions->where('name', 'like', '%' . $filter['gamePositionName'] . '%');
        }

        $gamePositions = $gamePositions->paginate();

        return view($this->viewFolder . '.index',
            compact(
                'gamePositions'
            )
        );
    }

    public function form(int $id = null): View
    {
        $gamePosition = null;

        if ($id) {
            $gamePosition = GamePosition::where('id', $id)->first();
        }

        return view($this->viewFolder . '.form',
            compact(
                'gamePosition'
            )
        );
    }

    public function store(Request $request, int $id = null): Application|RedirectResponse|Redirector
    {
        $this->validate($request,[
            'gamePositionName' => 'required|string|min:1|max:255',
            'gamePositionIcon' => 'required|string|min:1',
            'gamePositionShort' => 'required|string|min:1',
        ]);

        $data = $request->only([
            'gamePositionName',
            'gamePositionIcon',
            'gamePositionShort',
        ]);

        if ($id) {
            GamePosition::where('id', $id)->update(
                [
                    'name' => $data['gamePositionName'],
                    'icon' => $data['gamePositionIcon'],
                    'short' => $data['gamePositionShort'],
                ]
            );

            $message = 'Editado com sucesso!';
        } else {
            GamePosition::create(
                [
                    'name' => $data['gamePositionName'],
                    'icon' => $data['gamePositionIcon'],
                    'short' => $data['gamePositionShort'],
                ]
            );

            $message = 'Cadastrado com sucesso!';
        }

        return redirect($this->saveRedirect)->with('success', $message);
    }

    public function show(int $id): View
    {
        $gamePosition = GamePosition::where('id', $id)->first();

        return view($this->viewFolder . '.show',
            compact(
                'gamePosition'
            )
        );
    }

    public function delete(int $id): JsonResponse
    {

    }
}
