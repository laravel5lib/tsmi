<?php

declare(strict_types=1);

namespace App\Robot\Link;

/**
 * Class Report
 */
class Report
{
    /**
     * Full HTTP address for request
     *
     * @var
     */
    private $link;

    /**
     * HTTP status code
     *
     * @var int
     */
    private $code = 0;

    /**
     * Received request content
     *
     * @var string
     */
    private $content = '';

    /**
     * The amount of data received
     *
     * @var float
     */
    private $size = 0;

    /**
     * Received headers
     *
     * @var array
     */
    private $headers = [];

    /**
     * Validity of tags
     *
     * @var bool
     */
    private $tagging = false;

    /**
     * @return string
     */
    public function getLink(): string
    {
        return $this->link;
    }

    /**
     * @param string $link
     *
     * @return Report
     */
    public function setLink(string $link): self
    {
        $this->link = $link;

        return $this;
    }

    /**
     * @return int
     */
    public function getCode(): int
    {
        return $this->code;
    }

    /**
     * @param int $code
     *
     * @return Report
     */
    public function setCode(int $code): self
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     *
     * @return Report
     */
    public function setContent(string $content): self
    {
        $this->content = $content ?? '';

        return $this;
    }

    /**
     * @return float
     */
    public function getSize(): float
    {
        return $this->size;
    }

    /**
     * @param float $size
     *
     * @return Report
     */
    public function setSize(float $size): self
    {
        $this->size = $size ?? 0;

        return $this;
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * @param $headers
     *
     * @return $this
     */
    public function setHeaders(array $headers): self
    {
        $this->headers = $headers;

        return $this;
    }

    /**
     * @return bool
     */
    public function getTagging(): bool
    {
        return $this->tagging;
    }

    /**
     * @param mixed $tagging
     *
     * @return Report
     */
    public function setTagging(bool $tagging): self
    {
        $this->tagging = $tagging;

        return $this;
    }

    /**
     * Check for a good error code and availability of required tags
     *
     * @return bool
     */
    public function validate(): bool
    {
        return 200 === $this->getCode() && $this->getTagging();
    }
}