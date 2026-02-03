<?php

namespace CloudFiles\Adapter;

use ExpressionEngine\Dependency\Aws\S3\S3Client;
use ExpressionEngine\Dependency\League\Flysystem;
use ExpressionEngine\Library\Filesystem\Adapter\AdapterInterface;
use ExpressionEngine\Library\Filesystem\Adapter\AdapterTrait;
use ExpressionEngine\Service\Validation\ValidationAware;

class BackblazeB2 extends Flysystem\AwsS3v3\AwsS3Adapter implements AdapterInterface, ValidationAware
{
    use AdapterTrait;

    protected $_validation_rules = [
        'key' => 'required',
        'secret' => 'required',
        'region' => 'required',
        'bucket' => 'required',
    ];

    public function __construct($settings = [])
    {
        $this->settings = $settings;
        $client = new S3Client([
            'credentials' => [
                'key'    => $settings['key'],
                'secret' => $settings['secret']
            ],
            'region' => $settings['region'] ?: 'east-001',
            'version' => 'latest',
            'endpoint' => "https://s3.{$settings['region']}.backblazeb2.com",
            'exception_class' => \ExpressionEngine\Dependency\Aws\S3\Exception\S3Exception::class
        ]);

        parent::__construct($client, $settings['bucket']);
    }

    public static function getSettingsForm($settings)
    {
        return [
            [
                'title' => 'Application Key ID',
                'desc' => 'Enter your Backblaze B2 Key ID',
                'fields' => [
                    'adapter_settings[key]' => [
                        'type' => 'text',
                        'value' => $settings['key'] ?? '',
                        'required' => true
                    ]
                ]
            ],
            [
                'title' => 'Application Key',
                'desc' => 'Enter your Backblaze B2 Key',
                'fields' => [
                    'adapter_settings[secret]' => [
                        'type' => 'text',
                        'value' => $settings['secret'] ?? '',
                        'required' => true
                    ]
                ]
            ],
            [
                'title' => 'Region',
                'desc' => 'Enter the region for your Backblaze B2 Bucket',
                'fields' => [
                    'adapter_settings[region]' => [
                        'type' => 'text',
                        'value' => $settings['region'] ?? '',
                        'required' => true
                    ]
                ]
            ],
            [
                'title' => 'Bucket Name',
                'desc' => 'Enter the name of your Backblaze B2 Bucket',
                'fields' => [
                    'adapter_settings[bucket]' => [
                        'type' => 'text',
                        'value' => $settings['bucket'] ?? '',
                        'required' => true
                    ]
                ]
            ],
            [
                'title' => 'Path',
                'desc' => 'Enter the path inside your Backblaze B2 Bucket',
                'fields' => [
                    'server_path' => [
                        'type' => 'text',
                        'value' => $settings['server_path'] ?? '',
                        'required' => false
                    ]
                ]
            ],
            [
                'title' => 'Url',
                'desc' => 'Enter the url used to access your Backblaze B2 Bucket',
                'fields' => [
                    'url' => [
                        'type' => 'text',
                        'value' => $settings['url'] ?? '',
                        'required' => false
                    ]
                ]
            ]
        ];
    }

    public function getBaseUrl()
    {
        return implode('/', array_filter([
            'https://s3.'.$this->settings['region'].'.backblazeb2.com',
            $this->getBucket(),
            $this->getPathPrefix()
        ]));
    }
}
