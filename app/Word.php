<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Word
 */
class Word extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'word',
        'type',
    ];

    /**
     * Мусорные слова без смысла,
     * к которым относятся союзы, предлоги и т.п.
     */
    public static function getTrashWord()
    {
        return self::where('type','союз')
            ->orWhere('type','част')
            ->orWhere('type','ввод')
            ->orWhere('type','предик')
            ->orWhere('type','предл')
            ->orWhere('type','мест')
            ->orWhere('type','сущ,мест')
            ->groupBy('word')
            ->pluck('word');
    }
}
