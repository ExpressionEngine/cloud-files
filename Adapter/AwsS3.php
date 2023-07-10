<?php

namespace CloudFiles\Adapter;

use ExpressionEngine\Dependency\Aws\S3\S3Client;
use ExpressionEngine\Dependency\League\Flysystem;
use ExpressionEngine\Library\Filesystem\Adapter\AdapterInterface;
use ExpressionEngine\Library\Filesystem\Adapter\AdapterTrait;
use ExpressionEngine\Service\Validation\ValidationAware;

class AwsS3 extends AbstractS3 implements AdapterInterface, ValidationAware
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
            'region' => $settings['region'] ?: 'us-east-1',
            'version' => 'latest',
            'exception_class' => \ExpressionEngine\Dependency\Aws\S3\Exception\S3Exception::class
        ]);

        parent::__construct($client, $settings['bucket']);
    }

    public static function getSettingsForm($settings)
    {
        return [
            [
                'title' => 'Key',
                'desc' => 'Enter your AWS S3 Key',
                'fields' => [
                    'adapter_settings[key]' => [
                        'type' => 'text',
                        'value' => $settings['key'] ?? '',
                        'required' => true
                    ]
                ]
            ],
            [
                'title' => 'Secret',
                'desc' => 'Enter your AWS S3 Secret',
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
                'desc' => 'Select the region for your AWS S3 Bucket',
                'fields' => [
                    'adapter_settings[region]' => [
                        'type' => 'dropdown',
                        'choices' => \CloudFiles\Adapter\AwsS3::listAvailableRegions(),
                        'value' => $settings['region'] ?? '',
                        'required' => true
                    ]
                ]
            ],
            [
                'title' => 'Bucket Name',
                'desc' => 'Enter the name of your AWS S3 Bucket',
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
                'desc' => 'Enter the path inside your AWS S3 Bucket',
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
                'desc' => 'Enter the url used to access your AWS S3 Bucket',
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

    public static function listAvailableRegions()
    {
        return [
            'us-east-2' => 'US East (Ohio)',
            'us-east-1' => 'US East (N. Virginia)',
            'us-west-1' => 'US West (N. California)',
            'us-west-2' => 'US West (Oregon)',
            'af-south-1' => 'Africa (Cape Town)',
            'ap-east-1' => 'Asia Pacific (Hong Kong)',
            'ap-southeast-3' => 'Asia Pacific (Jakarta)',
            'ap-southeast-4' => 'Asia Pacific (Melbourne)',
            'ap-south-1' => 'Asia Pacific (Mumbai)',
            'ap-south-2' => 'Asia Pacific (Hyderabad)',
            'ap-northeast-3' => 'Asia Pacific (Osaka)',
            'ap-northeast-2' => 'Asia Pacific (Seoul)',
            'ap-southeast-1' => 'Asia Pacific (Singapore)',
            'ap-southeast-2' => 'Asia Pacific (Sydney)',
            'ap-northeast-1' => 'Asia Pacific (Tokyo)',
            'ca-central-1' => 'Canada (Central)',
            'cn-north-1' => 'China (Beijing)',
            'cn-northwest-1' => 'China (Ningxia)',
            'eu-central-1' => 'Europe (Frankfurt)',
            'eu-west-1' => 'Europe (Ireland)',
            'eu-west-2' => 'Europe (London)',
            'eu-south-1' => 'Europe (Milan)',
            'eu-west-3' => 'Europe (Paris)',
            'eu-north-1' => 'Europe (Stockholm)',
            'eu-south-2' => 'Europe (Spain)',
            'eu-central-2' => 'Europe (Zurich)',
            'me-south-1' => 'Middle East (Bahrain)',
            'me-central-1' => 'Middle East (UAE)',
            'sa-east-1' => 'South America (São Paulo)',
        ];
    }

    public function getBaseUrl()
    {
        return implode('/', array_filter([
            'https://s3.amazonaws.com',
            $this->getBucket(),
            $this->getPathPrefix()
        ]));
    }

}
