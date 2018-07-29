<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Article
 */
class Article extends Model
{
    /**
     * @var array
     */
    public $with = [
        'source',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'link',
        'image',
        'type',
        'created_at',
        'resource_id',
    ];

    /**
     * @param int $id
     *
     * @return mixed
     */
    public static function getLast($id = 0)
    {
        $last = self::with('source')
            ->orderBy('created_at', 'Desc');

        if ($id !== 0) {
            $last->where('id', '<', $id);
        }

        return $last->paginate(15);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function source()
    {
        return $this->belongsTo(Source::class, 'resource_id');
    }
}
