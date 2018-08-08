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
        'local_image',
        'resource_id',
        'created_at',
        'updated_at',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'id'          => 'string',
        'local_image' => 'string',
    ];

    /**
     * @param null $created_at
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function getLast($created_at = null)
    {
        $last = self::with('source')
            ->orderBy('created_at', 'Desc');

        if ($created_at !== null) {
            $last->where('created_at', '<', $created_at);
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
