<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NewsAdminController extends Controller
{
    public $model;

    public string $saveRedirect = 'admin.news.index';

    public string $viewFolder = 'system.admin.news';

    public function index(Request $request)
    {
        $this->validate($request, [
            'newsTitle' => 'required|string|min:3',
        ]);

        $filter = $request->only(
          'newsTitle'
        );

        $news = News::orderBy('created_at', 'desc');

        if (isset($filter['newsTitle'])) {
            $news->where('title', 'like', '%' . $filter['newsTitle'] . '%');
        }

        $news->paginate();

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
            'newsHeaderImage' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
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
            News::where('id', $id)->update([
                'title' => $data['newsTitle'],
                'content' => $data['newsContent'],
                'header_image' => $imagePath,
            ]);

        } else {
            News::create([
                'title' => $data['newsTitle'],
                'content' => $data['newsContent'],
                'header_image' => $imagePath,
                'slug' => $id . '_' . Str::slug($data['newsTitle'] . '_' . )
            ]);
        }

        return redirect($this->saveRedirect);
    }

    public function view(int $id)
    {
        $news = News::where('id', $id)->first();

        return view($this->viewFolder . '.view',
            compact(
                'news'
            )
        );
    }
}
