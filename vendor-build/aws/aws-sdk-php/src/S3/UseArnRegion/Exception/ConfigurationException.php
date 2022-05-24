<?php

namespace ExpressionEngine\Dependency\Aws\S3\UseArnRegion\Exception;

use ExpressionEngine\Dependency\Aws\HasMonitoringEventsTrait;
use ExpressionEngine\Dependency\Aws\MonitoringEventsInterface;
/**
 * Represents an error interacting with configuration for S3's UseArnRegion
 */
class ConfigurationException extends \RuntimeException implements MonitoringEventsInterface
{
    use HasMonitoringEventsTrait;
}
