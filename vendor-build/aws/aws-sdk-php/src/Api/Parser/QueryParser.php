<?php

namespace ExpressionEngine\Dependency\Aws\Api\Parser;

use ExpressionEngine\Dependency\Aws\Api\Service;
use ExpressionEngine\Dependency\Aws\Api\StructureShape;
use ExpressionEngine\Dependency\Aws\Result;
use ExpressionEngine\Dependency\Aws\CommandInterface;
use ExpressionEngine\Dependency\Psr\Http\Message\ResponseInterface;
use ExpressionEngine\Dependency\Psr\Http\Message\StreamInterface;
/**
 * @internal Parses query (XML) responses (e.g., EC2, SQS, and many others)
 */
class QueryParser extends AbstractParser
{
    use PayloadParserTrait;
    /** @var bool */
    private $honorResultWrapper;
    /**
     * @param Service   $api                Service description
     * @param XmlParser $xmlParser          Optional XML parser
     * @param bool      $honorResultWrapper Set to false to disable the peeling
     *                                      back of result wrappers from the
     *                                      output structure.
     */
    public function __construct(Service $api, XmlParser $xmlParser = null, $honorResultWrapper = \true)
    {
        parent::__construct($api);
        $this->parser = $xmlParser ?: new XmlParser();
        $this->honorResultWrapper = $honorResultWrapper;
    }
    public function __invoke(CommandInterface $command, ResponseInterface $response)
    {
        $output = $this->api->getOperation($command->getName())->getOutput();
        $xml = $this->parseXml($response->getBody(), $response);
        if ($this->honorResultWrapper && $output['resultWrapper']) {
            $xml = $xml->{$output['resultWrapper']};
        }
        return new Result($this->parser->parse($output, $xml));
    }
    public function parseMemberFromStream(StreamInterface $stream, StructureShape $member, $response)
    {
        $xml = $this->parseXml($stream, $response);
        return $this->parser->parse($member, $xml);
    }
}
