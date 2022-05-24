<?php

namespace CloudFiles\Adapter;

use ExpressionEngine\Dependency\Aws\S3\S3Client;
use ExpressionEngine\Dependency\League\Flysystem;

class DigitalOcean extends Flysystem\AwsS3v3\AwsS3Adapter
{

    public function __construct($settings = [])
    {
        $client = new S3Client([
            'credentials' => [
                'key'    => $settings['key'],
                'secret' => $settings['secret']
            ],
            'region' => $settings['region'],
            'version' => 'latest',
            'endpoint' => "https://{$settings['region']}.digitaloceanspaces.com",
            'exception_class' => \ExpressionEngine\Dependency\Aws\S3\Exception\S3Exception::class
        ]);

        parent::__construct($client, $settings['bucket']);
    }
}
