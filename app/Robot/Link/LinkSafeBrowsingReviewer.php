<?php

declare(strict_types=1);

namespace App\Robot\Link;

use GuzzleHttp\Client;

/**
 * Class LinkSafeBrowsingReviewer
 */
class LinkSafeBrowsingReviewer
{
    /**
     * Guzzle HTTP client
     *
     * @var Client
     */
    protected $client;

    /**
     * Key for Google Safe Browsing API
     *
     * @var string
     */
    protected $key;

    /**
     * LinkSafeBrowsingReviewer constructor.
     *
     * @param string $googleSafeBrowsingApiKey
     */
    public function __construct(string $googleSafeBrowsingApiKey)
    {
        $this->key = $googleSafeBrowsingApiKey;
        $this->client = new Client([
            'base_uri' => 'https://safebrowsing.googleapis.com',
            'query'    => [
                'key' => $this->key,
            ],
        ]);
    }

    /**
     * Verifies the URL passed to the security link
     *
     * @param string $url
     *
     * @return array
     */
    public function check(string $url): array
    {
        $response = $this->checkList([$url]);

        return (!empty($response)) ? reset($response) : [];
    }

    /**
     * Checks the list of security URLs, maximum 500.
     * Only the dangerous ones return
     *
     * @param array $urls
     *
     * @return array
     */
    public function checkList(array $urls): array
    {
        if (count($urls) > 500) {
            $urls = array_slice($urls, 0, 500);
            trigger_error('Argument must not exceed 500 entries');
        }

        $response = $this->client->post('/v4/threatMatches:find', [
            'body' => json_encode([
                'client'     => [
                    'clientId'      => 'smi2robot',
                    'clientVersion' => '0.0.1',
                ],
                'threatInfo' => [
                    'threatTypes'      => ['MALWARE', 'SOCIAL_ENGINEERING', 'UNWANTED_SOFTWARE', 'POTENTIALLY_HARMFUL_APPLICATION'],
                    'platformTypes'    => ['ALL_PLATFORMS'],
                    'threatEntryTypes' => ['URL'],
                    'threatEntries'    => array_map(function ($item) {
                        return ['url' => $item];
                    }, $urls),
                ],
            ]),
        ]);

        $dangerous = json_decode($response->getBody()->getContents(), true);

        foreach ($urls as $key => $url) {
            $urls[$key] = [];

            if (empty($dangerous) || !isset($dangerous['matches'])) {
                continue;
            }

            foreach ($dangerous['matches'] as $dangerou) {
                if (false !== array_search($url, $dangerou['threat'])) {
                    array_push($urls[$key], $dangerou['threatType']);
                }
            }

            $urls[$key] = array_unique($urls[$key]);
        }

        return $urls;
    }
}
