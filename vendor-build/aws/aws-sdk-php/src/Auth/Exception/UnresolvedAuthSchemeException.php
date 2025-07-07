<?php

namespace ExpressionEngine\Dependency\Aws\Auth\Exception;

use ExpressionEngine\Dependency\Aws\HasMonitoringEventsTrait;
use ExpressionEngine\Dependency\Aws\MonitoringEventsInterface;
/**
 * Represents an error when attempting to resolve authentication.
 */
class UnresolvedAuthSchemeException extends \RuntimeException implements MonitoringEventsInterface
{
    use HasMonitoringEventsTrait;
}
