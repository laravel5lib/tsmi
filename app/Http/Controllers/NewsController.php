<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Article;
use App\Group;

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
                'article' => Article::select('created_at')->orderBy('id', 'Desc')->first()->created_at->toW3cString(),
                'groups'  => Group::select('created_at')->orderBy('id', 'Desc')->first()->created_at->toW3cString(),
            ],
        ]);
    }

    /**
     * @param string $type
     * @param string $created_at
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function load(string $type, string $created_at)
    {
        if ($type == 'group') {
            return view('partials.group', [
                'groups' => Group::getLast($created_at),
            ]);
        }

        return view('partials.news', [
            'last' => Article::getLast($created_at),
        ]);
    }

    /**
     * @param \App\Group $group
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Group $group)
    {
        $ids = array_keys($group->news);
        $groups = Article::whereIn('id', $ids)->get();
        $main = $groups->slice(0, 1)->first();

        return view('page', [
            'last'   => Article::getLast(),
            'main'   => $main,
            'groups' => $groups,
        ]);
    }

    /**
     * @param \App\Article $article
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function link(Article $article)
    {
        return redirect()->to($article->link);
    }
}
