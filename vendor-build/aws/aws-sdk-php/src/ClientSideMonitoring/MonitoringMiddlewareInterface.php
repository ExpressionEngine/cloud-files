<?php

namespace ExpressionEngine\Dependency\Aws\ClientSideMonitoring;

use ExpressionEngine\Dependency\Aws\CommandInterface;
use ExpressionEngine\Dependency\Aws\Exception\AwsException;
use ExpressionEngine\Dependency\Aws\ResultInterface;
use ExpressionEngine\Dependency\GuzzleHttp\Psr7\Request;
use ExpressionEngine\Dependency\Psr\Http\Message\RequestInterface;
/**
 * @internal
 */
interface MonitoringMiddlewareInterface
{
    /**
     * Data for event properties to be sent to the monitoring agent.
     *
     * @param RequestInterface $request
     * @return array
     */
    public static function getRequestData(RequestInterface $request);
    /**
     * Data for event properties to be sent to the monitoring agent.
     *
     * @param ResultInterface|AwsException|\Exception $klass
     * @return array
     */
    public static function getResponseData($klass);
    public function __invoke(CommandInterface $cmd, RequestInterface $request);
}
