<?php

declare(strict_types=1);

namespace App\Robot\Feed;

use Carbon\Carbon;
use Illuminate\Support\Str;

/**
 * Class Channel
 */
class Channel
{
    /**
     *
     */
    const USELESS_WORDS = [
        'Читать далее',
        'Всем привет!',
    ];

    /**
     * @param string         $content
     * @param                $resourceId
     * @param \Carbon\Carbon $lastUpdate
     *
     * @return array
     */
    public static function getItems(string $content, $resourceId, Carbon $lastUpdate): array
    {
        $xml = new \SimpleXMLElement($content);

        foreach ($xml->channel->item as $entry) {

            $createdAt = self::clearDate((string) $entry->pubDate);
            if ($lastUpdate->gt($createdAt)) {
                continue;
            }

            $item = [
                'id'          => (string) Str::uuid(),
                'title'       => self::clearString((string) $entry->title),
                'description' => self::clearString((string) $entry->description),
                'created_at'  => self::clearDate((string) $entry->pubDate),
                'link'        => self::clearUrl((string) $entry->link),
                'resource_id' => $resourceId,
                'image'       => null,
            ];

            if ((bool) $entry->enclosure) {

                $image = (string) $entry->enclosure->attributes()->url;

                if (
                    strpos($image, '.png') !== false
                    || strpos($image, '.jpg') !== false
                ) {

                    $item = array_merge($item, [
                        'image' => $image,
                    ]);
                }
            }

            $items[] = $item;
        }

        return $items ?? [];
    }


    /**
     * @param string $string
     *
     * @return string
     */
    public static function clearString(string $string = ''): string
    {
        $string = strip_tags($string);

        foreach (self::USELESS_WORDS as $word) {
            $string = str_replace($word, '', $string);
        }

        $string = str_limit($string, 180, '...');

        return trim($string);
    }

    /**
     * @param string $string
     *
     * @return string
     */
    public static function clearUrl(string $string = ''): string
    {
        return $string;
        //return trim(str_replace('?' . parse_url($string, PHP_URL_QUERY), '', $string));
    }

    /**
     * @param string $string
     *
     * @return \Carbon\Carbon
     */
    public static function clearDate(string $string = ''): Carbon
    {
        return Carbon::parse($string);
    }
}