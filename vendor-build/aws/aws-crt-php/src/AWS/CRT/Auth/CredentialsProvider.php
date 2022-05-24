<?php

/**
 * Copyright Amazon.com, Inc. or its affiliates. All Rights Reserved.
 * SPDX-License-Identifier: Apache-2.0.
 */
namespace ExpressionEngine\Dependency\AWS\CRT\Auth;

use ExpressionEngine\Dependency\AWS\CRT\NativeResource as NativeResource;
/**
 * Base class for credentials providers
 */
abstract class CredentialsProvider extends NativeResource
{
    function __construct(array $options = [])
    {
        parent::__construct();
    }
    function __destruct()
    {
        self::$crt->credentials_provider_release($this->release());
        parent::__destruct();
    }
}
