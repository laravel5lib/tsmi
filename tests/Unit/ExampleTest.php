<?php

namespace Tests\Unit;

use App\Robot\Link\LinkAvailabilityReviewer;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use Tests\TestCase;
use GuzzleHttp\Psr7\Response;

class ExampleTest extends TestCase
{
    /**
     *
     */
    public function testOneLink()
    {
        $reviewer = $this->createLinkAvailabilityReviewerMock([
            self::createValidResponse(),
        ]);

        $report = $reviewer->check('https://google.com/');

        $this->assertSame($report->getLink(), 'https://google.com/');
        $this->assertSame($report->getCode(), 200);
        $this->assertSame($report->getTagging(), true);
    }

    /**
     *
     */
    public function testManyLink()
    {
        $reviewer = $this->createLinkAvailabilityReviewerMock([
            self::createValidResponse(),
            self::createValidResponse(),
            self::createValidResponse(),
        ]);

        $reports = $reviewer->checkList([
            'https://google.com/',
            'https://google.com/',
            'https://google.com/',
        ]);

        foreach ($reports as $report) {
            $this->assertSame($report->getLink(), 'https://google.com/');
            $this->assertSame($report->getCode(), 200);
            $this->assertSame($report->getTagging(), true);
        }
    }

    /**
     *
     */
    public function testErrorTaggingLink()
    {
        $reviewer = $this->createLinkAvailabilityReviewerMock([
            self::createInValidResponse(),
        ]);

        $report = $reviewer->check('https://www.google.com/robots.txt');

        $this->assertSame($report->validate(), false);
        $this->assertSame($report->getTagging(), false);
    }

    /**
     * @param Response[] $responses
     *
     * @return LinkAvailabilityReviewer
     */
    private function createLinkAvailabilityReviewerMock(array $responses = []): LinkAvailabilityReviewer
    {
        return new LinkAvailabilityReviewer([
            'handler' => HandlerStack::create(new MockHandler($responses)),
        ]);
    }

    /**
     * @return Response
     */
    private static function createValidResponse(): Response
    {
        return new Response(200, [], '<html><header><title></title></header><body></body></html>');
    }

    /**
     * @return Response
     */
    private static function createInValidResponse(): Response
    {
        return new Response(200, [], '<html><body></body></html>');
    }

}
