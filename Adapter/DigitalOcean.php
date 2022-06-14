<?php

namespace CloudFiles\Adapter;

use ExpressionEngine\Dependency\Aws\S3\S3Client;
use ExpressionEngine\Dependency\League\Flysystem;
use ExpressionEngine\Library\Filesystem\Adapter\AdapterInterface;
use ExpressionEngine\Library\Filesystem\Adapter\AdapterTrait;
use ExpressionEngine\Service\Validation\ValidationAware;

class DigitalOcean extends Flysystem\AwsS3v3\AwsS3Adapter implements AdapterInterface, ValidationAware
{
    use AdapterTrait;

    protected $_validation_rules = [];

    public function __construct($settings = [])
    {
        $this->settings = $settings;
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

    public static function getSettingsForm($settings)
    {
        return [];
    }
}
