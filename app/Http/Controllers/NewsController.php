<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Article;
use App\Group;
use Illuminate\Support\Facades\Cache;
use Intervention\Image\Facades\Image;

/**
 * Class NewsController
 */
class NewsController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('welcome', [
            'last'   => Article::getLast(),
            'groups' => Group::getLast(),

            'records' => [
                'article' => Article::select('id')->orderBy('id', 'Desc')->first()->id,
                'groups'  => Group::select('id')->orderBy('id', 'Desc')->first()->id,
            ],
        ]);
    }

    /**
     * @param \App\Article $article
     *
     * @return mixed
     */
    public function image(Article $article)
    {
        abort_if(is_null($article->image), 404);
        $name = sha1($article->image) . '.jpg';

        $image = Cache::remember($name, now()->addDay(1), function () use ($article, $name) {
            return (string) Image::make($article->image)->encode('data-url');
        });

        return Image::make($image)->response();
    }

    /**
     * @param string $type
     * @param int    $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function load(string $type, int $id)
    {
        if ($type == 'group') {
            return view('partials.group', [
                'groups' => Group::getLast($id),
            ]);
        }

        return view('partials.news', [
            'last' => Article::getLast($id),
        ]);
    }
}
