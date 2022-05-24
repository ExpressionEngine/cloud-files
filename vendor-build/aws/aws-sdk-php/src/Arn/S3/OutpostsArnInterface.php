<?php

namespace ExpressionEngine\Dependency\Aws\Arn\S3;

use ExpressionEngine\Dependency\Aws\Arn\ArnInterface;
/**
 * @internal
 */
interface OutpostsArnInterface extends ArnInterface
{
    public function getOutpostId();
}
