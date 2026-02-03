<?php
// Cloud Files works with all PHP versions supported by ExpressionEngine 7
// However the S3 SDK is now showing warnings when used with older PHP versions
// https://aws.amazon.com/blogs/developer/announcing-the-end-of-support-for-php-runtimes-8-0-x-and-below-in-the-aws-sdk-for-php/
$_ENV['AWS_SUPPRESS_PHP_DEPRECATION_WARNING'] = $_ENV['AWS_SUPPRESS_PHP_DEPRECATION_WARNING'] ?? true;

require __DIR__ . '/vendor-build/autoload.php';

return array(
    'author' => 'ExpressionEngine',
    'author_url' => 'https://expressionengine.com/',
    'name' => 'Cloud Files',
    'description' => '',
    'version' => '1.1.0',
    'namespace' => 'CloudFiles',
    'settings_exist' => false,
    'filesystem_adapters' => [
        \CloudFiles\Adapter\AwsS3::class,
        \CloudFiles\Adapter\BackblazeB2::class,
        \CloudFiles\Adapter\CloudflareR2::class,
        \CloudFiles\Adapter\DigitalOcean::class,
    ]
);
