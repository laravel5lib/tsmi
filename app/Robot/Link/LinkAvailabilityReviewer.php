<?php

declare(strict_types=1);

namespace App\Robot\Link;

use App\Robot\Robot;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Class LinkAvailabilityReviewer
 */
class LinkAvailabilityReviewer
{

    /**
     * A set of prepared data for creating a link availability report
     *
     * @var array
     */
    private $reports = [];

    /**
     * @var array
     */
    private $duplicatedLinks = [];

    /**
     * Object for DOM navigation
     *
     * @var Crawler
     */
    private $document;

    /**
     * @var \App\Robot\Robot
     */
    private $robot;

    /**
     * LinkAvailabilityReviewer constructor.
     *
     * @param array|null $options
     */
    public function __construct(array $options = null)
    {
        $this->robot = new Robot($options);
        $this->document = new Crawler(null, 'http://localhost/');
    }

    /**
     * Check one or several URLs for broken links.
     *
     * @param string $link URL
     *
     * @return Report
     */
    public function check(string $link): Report
    {
        $this->reports = [];

        $this->checkAvailabilityLinks([$link]);

        return reset($this->reports);
    }

    /**
     * @param array $links
     */
    private function checkAvailabilityLinks(array $links)
    {
        $this->robot->browse($links,
            function (ResponseInterface $response, int $shift) use ($links) {
                $value = self::determineIndexValue($links, $shift);
                $this->reports[$value['increment']] = $this->createReportFromHttpResponse($value['item'], $response);
            }, function (RequestException $exception, int $shift) use ($links) {
                $value = self::determineIndexValue($links, $shift);
                $this->reports[$value['increment']] = $this->createReportFromHttpException($value['item'], $exception);
            }
        );
    }

    /**
     * @param string     $link
     * @param \Exception $exception
     *
     * @return Report
     */
    private function createReportFromException(string $link, \Exception $exception): Report
    {
        $report = new Report();

        return $report
            ->setLink($link)
            ->setCode($exception->getCode())
            ->setContent($exception->getMessage());
    }

    /**
     * @param string            $link
     * @param ResponseInterface $response
     *
     * @return Report
     */
    private function createReportFromHttpResponse(string $link, ResponseInterface $response): Report
    {
        $report = new Report();
        $content = $response->getBody()->getContents();
        $tagging = $this->checkContent($content);

        $report->setLink($link)
            ->setCode($response->getStatusCode())
            ->setContent($content)
            ->setSize($response->getBody()->getSize())
            ->setHeaders($response->getHeaders())
            ->setTagging($tagging);

        return $report;
    }

    /**
     * Checks html passed for tags `title` and `body`
     *
     * @param string $content
     *
     * @return bool
     */
    private function checkContent(string $content = ''): bool
    {
        $this->document->clear();
        $this->document->addHtmlContent($content);

        $title = $this->document->filter('title')->first();
        $body = $this->document->filter('body')->first();

        return $title->count() > 0 && $body->count() > 0;
    }

    /**
     * @param string           $link
     * @param RequestException $exception
     *
     * @return Report
     */
    private function createReportFromHttpException(string $link, RequestException $exception): Report
    {
        $report = new Report();

        return $report
            ->setLink($link)
            ->setContent($exception->getMessage());
    }

    /**
     * @param array    $links URL set
     * @param int|null $concurrency allowed number of outstanding concurrently executing promises
     *
     * @return Report[]
     */
    public function checkList(array $links, int $concurrency = 30): array
    {
        $this->reports = [];
        $collection = [];

        while (count($links) > 0) {
            $chunk = $this->uniqueChunkArray($links, $concurrency);
            $links = $chunk['links'];
            $collection[] = $chunk['chunk'];
        }

        foreach ($collection as $item) {
            $item = $this->uniqueLink($item);
            $this->checkAvailabilityLinks($item, $concurrency);
        }

        return array_replace($this->duplicatedLinks, $this->reports);
    }

    /**
     * @param array $item
     *
     * @return array
     */
    private function uniqueLink(array $item): array
    {
        foreach ($item as $key => $link) {
            foreach ($this->reports as $report) {
                if ($report->getLink() === $link) {
                    $this->reports[$key] = $report;
                    unset($item[$key]);
                }
            }
        }

        return $item;
    }

    /**
     * @param array $links
     * @param int   $limit
     *
     * @return array
     */
    private function uniqueChunkArray(array $links, int $limit): array
    {
        $domains = array_map(function ($link) {
            return parse_url($link)['host'];
        }, $links);

        $keys = array_keys(array_unique($domains));

        $chunk = [];
        foreach ($keys as $key) {
            if (count($chunk) >= $limit) {
                break;
            }

            $chunk[$key] = $links[$key];
        }

        $links = array_diff_key($links, $chunk);

        return compact('chunk', 'links');
    }

    /**
     * @param array $links
     * @param int   $shift
     *
     * @return array
     */
    private static function determineIndexValue(array $links, int $shift): array
    {
        $currentArrayLinks = array_slice($links, $shift, 1, true);
        reset($currentArrayLinks);
        $increment = key($currentArrayLinks);
        $item = array_shift($currentArrayLinks);

        return [
            'increment' => $increment,
            'item'      => $item,
        ];
    }

}