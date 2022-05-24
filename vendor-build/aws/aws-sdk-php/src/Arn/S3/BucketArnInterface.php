<?php

namespace ExpressionEngine\Dependency\Aws\Arn\S3;

use ExpressionEngine\Dependency\Aws\Arn\ArnInterface;
/**
 * @internal
 */
interface BucketArnInterface extends ArnInterface
{
    public function getBucketName();
}
