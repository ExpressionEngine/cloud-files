<?php

namespace ExpressionEngine\Dependency\Aws\Handler\GuzzleV5;

use ExpressionEngine\Dependency\GuzzleHttp\Stream\StreamDecoratorTrait;
use ExpressionEngine\Dependency\GuzzleHttp\Stream\StreamInterface as GuzzleStreamInterface;
use ExpressionEngine\Dependency\Psr\Http\Message\StreamInterface as Psr7StreamInterface;
/**
 * Adapts a Guzzle 5 Stream to a PSR-7 Stream.
 *
 * @codeCoverageIgnore
 */
class PsrStream implements Psr7StreamInterface
{
    use StreamDecoratorTrait;
    /** @var GuzzleStreamInterface */
    private $stream;
    public function __construct(GuzzleStreamInterface $stream)
    {
        $this->stream = $stream;
    }
    public function rewind()
    {
        $this->stream->seek(0);
    }
    public function getContents()
    {
        return $this->stream->getContents();
    }
}
