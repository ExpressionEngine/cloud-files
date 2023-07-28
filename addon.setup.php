<?php

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
        \CloudFiles\Adapter\DigitalOcean::class,
        \CloudFiles\Adapter\CloudflareR2::class,
    ]
);
