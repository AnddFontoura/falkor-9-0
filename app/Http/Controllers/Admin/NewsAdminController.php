<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Team;
use App\Models\UserSawNews;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class NewsAdminController extends Controller
{
    public string $saveRedirect = 'admin.news.index';

    public string $viewFolder = 'system.admin.news';

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

    public function form(int $id = null)
    {
        $news = null;

        if ($id) {
            $news = News::where('id', $id)->first();
        }

        return view($this->viewFolder . '.form',
            compact(
                'news'
            )
        );
    }

    public function store(Request $request, int $id = null)
    {
        $this->validate($request, [
            'newsTitle' => 'required|string|min:3',
            'newsContent' => 'required|string|min:3',
            'newsHeaderImage' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        $data = $request->only([
            'newsTitle',
            'newsContent',
            'newsHeaderImage',
        ]);

        if (isset($data['newsHeaderImage'])) {
            $imagePath = $this->uploadService->uploadFileToFolder(
                'public',
                'news',
                $data['newsHeaderImage']
            );
        }

        if ($id) {
            $news = News::where('id', $id)->first();

            if($news->header_image) {
                $this->uploadService->deleteFileOnFolder(
                    'public',
                    'news',
                    $news->header_image);

                Team::where('id', $id)->update([
                    'header_image' => $imagePath,
                ]);
            }

            News::where('id', $id)->update([
                'user_id' => Auth::user()->id,
                'title' => $data['newsTitle'],
                'content' => $data['newsContent'],
            ]);

        } else {
            News::create([
                'user_id' => Auth::user()->id,
                'title' => $data['newsTitle'],
                'content' => $data['newsContent'],
                'header_image' => $imagePath,
                'slug' => $id . '_' . Str::slug($data['newsTitle'] . '_')
            ]);
        }

        return redirect()->route($this->saveRedirect);
    }

    public function show(int $id)
    {
        $newsViews = UserSawNews::where('news_id', $id)->count('id');
        $news = News::where('id', $id)->first();

        return view($this->viewFolder . '.view',
            compact(
                'news',
                'newsViews'
            )
        );
    }
}
