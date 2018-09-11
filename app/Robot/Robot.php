<?php

declare(strict_types=1);

namespace App\Robot;

use GuzzleHttp\Client as Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Promise;
use Illuminate\Support\Facades\Cache;
use Kevinrob\GuzzleCache\CacheMiddleware;
use Kevinrob\GuzzleCache\Storage\LaravelCacheStorage;
use Kevinrob\GuzzleCache\Strategy\PrivateCacheStrategy;

/**
 * Class Robot
 */
class Robot
{
    /**
     * Guzzle client array constructor parameters.
     *
     * @var array
     */
    public $options = [
        'verify'          => false,
        'timeout'         => 10.0,
        'http_errors'     => false,
        'headers'         => [
            'User-Agent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.103 Safari/537.36',
            'Accept'     => '*/*',
        ],
        'allow_redirects' => [
            'max'             => 10,
            'strict'          => false,
            'referer'         => false,
            'protocols'       => ['http', 'https'],
            'track_redirects' => false,
        ],
    ];

    /**
     * Guzzle HTTP client
     *
     * @var Client
     */
    public $client;

    /**
     * @var int
     */
    public $concurrency = 100;

    /**
     * Client constructor.
     *
     * @param array|null $options
     */
    public function __construct(array $options = null)
    {
        if (null !== $options) {
            $this->options = array_merge($this->options, $options);
        }

        // Added cache
        if (!isset($this->options['handler'])) {
            // Create default HandlerStack
            $stack = HandlerStack::create();

            // Add this middleware to the top with `push`
            $stack->push(
                new CacheMiddleware(
                    new PrivateCacheStrategy(
                        new LaravelCacheStorage(
                            Cache::store('redis')
                        )
                    )
                ),
                'cache'
            );

            $this->options['handler'] = $stack;
        }

        $this->client = new Client($this->options);
    }

    /**
     * @param array|null $options
     *
     * @return \GuzzleHttp\Client
     */
    public static function getClient(array $options = null): Client
    {
        $robot = new self($options);
        return $robot->client;
    }

    /**
     * @param array    $links
     * @param \Closure $fulfilled
     * @param \Closure $rejected
     */
    public function browse(array $links, \Closure $fulfilled = null, \Closure $rejected = null)
    {
        $client = $this->client;

        $promises = (function () use ($links, $client) {
            foreach ($links as $key => $link) {
                try {
                    yield $client->requestAsync('GET', $link);
                } catch (\Exception $exception) {
                    //записать в лог, если url не валиден
                }
            }
        })();

        (new Promise\EachPromise($promises, [
            'concurrency' => $this->concurrency,
            'fulfilled'   => $fulfilled,
            'rejected'    => $rejected,
        ]))->promise()->wait();
    }
}