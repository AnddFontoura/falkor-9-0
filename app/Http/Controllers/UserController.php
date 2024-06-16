<?php

namespace App\Http\Controllers;

use App\Enums\LanguageEnum;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class UserController extends Controller
{
    protected string $viewFolder = 'system.user';
    protected string $saveRedirect = 'home';

    public function form(): View
    {
        $user = Auth::user();
        $languages = LanguageEnum::LANGUAGE_ARRAY;

        return view($this->viewFolder . '.form',
            compact(
                'user',
                'languages',
            )
        );
    }

    public function store(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'language' => 'nullable|string|max:6',
        ]);

        $data = $request->only(
            [
                'name',
                'language'
            ]
        );

        $user = Auth::user();

        User::where('id', $user->id)->update($data);

        return redirect()->route($this->saveRedirect);
    }
}
