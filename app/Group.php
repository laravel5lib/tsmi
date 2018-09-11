<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    /**
     * @var array
     */
    protected $with = [
      'article'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'key',
        'news',
        'count',
        'article_id',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'key'        => 'string',
        'news'       => 'array',
        'count'      => 'integer',
        'article_id' => 'string',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    /**
     * @param null $created_at
     *
     * @return mixed
     */
    public static function getLast($created_at = null)
    {
        $last = self::orderBy('created_at', 'Desc')
            ->orderBy('count', 'Desc');

        if ($created_at !== null) {
            $last->whereDate('created_at', '<', $created_at);
        }

        return $last->paginate(12);
    }

    /**
     *
     */
    public function updateGroupTime()
    {
        $groups = $this->groupTimeNews();

        foreach ($groups as $key => $group) {

            reset($group);
            $first_article = key($group);

            Group::whereBetween('updated_at', [
                now()->subHours(24), now()
            ])
                ->updateOrCreate([
                    'key' => $key,
                ], [
                    'key'        => $key,
                    'news'       => $group,
                    'count'      => count($group),
                    'article_id' => $first_article,
                ]);
        }

    }

    /**
     * @return array
     */
    public function groupTimeNews(): array
    {
        $trash = Word::getTrashWord();
        $trash->map(function ($item) {
            return mb_strtolower($item);
        });

        $articles = Article::whereNotNull('image')
            ->whereBetween('created_at', [now()->subHours(24), now()])
            ->pluck('title', 'id');

        $newarr = [];

        $words = [];
        $result = [];

        $articles->each(function ($value, $key) use (&$words, &$newarr, &$result) {
            //приводим к нижнему регистру
            $val = mb_strtolower($value);

            //убираем знаки препинания и прочие символы
            $val = $this->removePunctuationMarks($val);
            $val = trim($val);

            // если строка стала пустой
            if (empty($val)) {
                return;
            }

            //запоминаем "очищенные" слова
            $newarr[$key] = $val;

            //разделяем слова в массив
            $cw = explode(" ", $val);

            //запоминаем весь список слов
            foreach ($cw as $word) {
                if (empty($word)) {
                    continue;
                }

                $words[] = $word;
            }
        });


        foreach ($words as $word) {
            $ca = [];

            foreach ($newarr as $key => $phrase) {
                //проверяем, что фраза содержит это слово
                if (strpos(" " . $phrase . " ", " " . $word . " ") !== false) {
                    $ca[$key] = $articles[$key];
                }
            }

            $result[$word] = $ca;
        }

        // Убираем новости с одинаковыми заголовками
        $result = array_map(function ($value) {
            return array_unique($value);
        }, $result);

        // Убираем группировку по не интересным словам
        foreach ($result as $key => $value) {

            // Убираем все группы если ключевое слово было числом
            if (ctype_digit($key) || is_integer($key)) {
                unset($result[$key]);
            }

            //Удаляем треш слова
            foreach ($trash as $item) {
                if ($key === $item) {
                    unset($result[$key]);
                }
            }

            // Убираем все группы если в них меньше 5 новостей
            if (count($value) < 5) {
                unset($result[$key]);
            }

        }

        // Отсеиваем группы со случайным совпадением
        foreach ($result as $key => $value) {
            if ($this->similarTextArray($value) < 1) {
                unset($result[$key]);
            }
        }

        // Убираем дубликаты групп
        $result = array_map("unserialize", array_unique(array_map("serialize", $result)));

        //сортируем по цитируемости
        array_multisort(array_map('count', $result), SORT_DESC, $result);

        return $result;
    }

    /**
     * Убираем знаки препинания и прочие символы
     *
     * @param $value
     *
     * @return mixed
     */
    private function removePunctuationMarks($value): string
    {
        return str_replace(['.', ',','/', ';'], '', $value);
    }

    /**
     * @param array $texts
     * @param null  $text
     * @param int   $percent
     *
     * @return int
     */
    private function similarTextArray(array $texts, $text = null, $percent = 0): int
    {
        if (!isset($this->count)) {
            $this->count = 0;
        }

        if (is_null($text)) {
            foreach ($texts as $item) {
                $percent += $this->similarTextArray($texts, $item, $percent);
            }

            $percent = ceil($percent);
            $count = count($texts);
            $count = $count * $count;
            $numberOfZeros = strlen((string) $percent) - strlen((string) $count);


            for ($i = 0; $i < $numberOfZeros; $i++) {
                $count = $count . '0';
            }

            return (int) ($percent / $count);
        }

        foreach ($texts as $item) {
            $this->count = $this->count + 1;
            $percent += similar_text($text, $item);
        }

        if($percent > 1000){
            $percent = 1000;
        }

        return $percent;
    }
}
