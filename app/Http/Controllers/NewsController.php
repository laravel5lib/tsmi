<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Article;
use App\Group;
use App\Robot\Robot;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
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
                'article' => Article::select('created_at')->orderBy('id', 'Desc')->first()->created_at->toW3cString(),
                'groups'  => Group::select('created_at')->orderBy('id', 'Desc')->first()->created_at->toW3cString(),
            ],
        ]);
    }

    /**
     * @param \App\Group $group
     * @param string     $format
     *
     * @return mixed
     */
    public function image(Group $group, $format = '.jpg')
    {
        $disk =   Storage::disk('public');
        $images = Article::where('id',array_keys($group->news))->pluck('image');
        //$format = str_replace('.','',$format);
        $storage = 'images/'.date("YmdH/");


        foreach ($images as $image){
           // try {

                if($disk->exists( $image.$format)){
                    return redirect()->to($disk->url( $image.$format));
                }

                //$image = Cache::remember($image, now()->addDay(1), function () use ($image,$storage,$format) {
                    //$image = Image::make($image)->encode('data-url');

                    //$imageSave = clone $image;
                    $disk->makeDirectory($storage);

                    Image::make($image)
                        ->encode(str_replace('.','',$format))
                        ->save(public_path($storage.sha1($image).$format),75);

                    //dd($image);
                  //  return (string) $image;
                //});

                return Image::make($image)->response($format, 75);
            //}catch (\Exception $exception){
                //continue;
            //}
        }
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
     * @param \App\Article $article
     */
    public function trek(Article $article)
    {

    }
}
