<?php

namespace ExpressionEngine\Dependency\GuzzleHttp;

use ExpressionEngine\Dependency\Psr\Http\Message\MessageInterface;
final class BodySummarizer implements BodySummarizerInterface
{
    /**
     * @var int|null
     */
    private $truncateAt;
    public function __construct(int $truncateAt = null)
    {
        $this->truncateAt = $truncateAt;
    }
    /**
     * Returns a summarized message body.
     */
    public function summarize(MessageInterface $message) : ?string
    {
        return $this->truncateAt === null ? \ExpressionEngine\Dependency\GuzzleHttp\Psr7\Message::bodySummary($message) : \ExpressionEngine\Dependency\GuzzleHttp\Psr7\Message::bodySummary($message, $this->truncateAt);
    }
}
