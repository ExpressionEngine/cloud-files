<?php

namespace ExpressionEngine\Dependency\GuzzleHttp;

use ExpressionEngine\Dependency\Psr\Http\Message\MessageInterface;
interface BodySummarizerInterface
{
    /**
     * Returns a summarized message body.
     */
    public function summarize(MessageInterface $message) : ?string;
}
