<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\UserSawNews;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NewsController extends Controller
{
    public string $viewFolder = 'system/news';

    public function index(Request $request)
    {

        $this->validate($request, [
            'newsTitle' => 'nullable|string|min:3',
        ]);

        $filter = $request->only(
            'newsTitle'
        );

        $news = News::orderBy('created_at', 'desc');

        if (isset($filter['newsTitle'])) {
            $news->where('title', 'like', '%' . $filter['newsTitle'] . '%');
        }

        $news = $news->paginate();

        return view($this->viewFolder . '.index',
            compact(
                'news',
            )
        );
    }


    public function show(int $id)
    {
        UserSawNews::create([
            'news_id' => $id,
            'user_id' => Auth::user()->id
        ]);

        $news = News::where('id', $id)->first();

        return view($this->viewFolder . '.view',
            compact(
                'news',
            )
        );
    }
}
