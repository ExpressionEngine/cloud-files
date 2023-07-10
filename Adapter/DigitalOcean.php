<?php

namespace CloudFiles\Adapter;

use ExpressionEngine\Dependency\Aws\S3\S3Client;
use ExpressionEngine\Dependency\League\Flysystem;
use ExpressionEngine\Library\Filesystem\Adapter\AdapterInterface;
use ExpressionEngine\Library\Filesystem\Adapter\AdapterTrait;
use ExpressionEngine\Service\Validation\ValidationAware;

class DigitalOcean extends AbstractS3 implements AdapterInterface, ValidationAware
{
    use AdapterTrait;

    protected $_validation_rules = [
        'key' => 'required',
        'secret' => 'required',
        'region' => 'required',
        'space' => 'required',
    ];

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

        parent::__construct($client, $settings['space']);
    }

    public static function getSettingsForm($settings)
    {
        return [
            [
                'title' => 'Key',
                'desc' => 'Enter your DigitalOcean Key',
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
                'desc' => 'Enter your DigitalOcean Secret',
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
                'desc' => 'Select the region for your DigitalOcean Space',
                'fields' => [
                    'adapter_settings[region]' => [
                        'type' => 'dropdown',
                        'choices' => \CloudFiles\Adapter\DigitalOcean::listAvailableRegions(),
                        'value' => $settings['region'] ?? '',
                        'required' => true
                    ]
                ]
            ],
            [
                'title' => 'Space Name',
                'desc' => 'Enter the name of your DigitalOcean Space',
                'fields' => [
                    'adapter_settings[space]' => [
                        'type' => 'text',
                        'value' => $settings['space'] ?? '',
                        'required' => true
                    ]
                ]
            ],
            [
                'title' => 'Path',
                'desc' => 'Enter the path inside your DigitalOcean Space',
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
                'desc' => 'Enter the url used to access your DigitalOcean Space',
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
            'nyc1' => 'NYC1 - New York City',
            'nyc2' => 'NYC2 - New York City',
            'nyc3' => 'NYC3 - New York City',
            'ams2' => 'AMS2 - Amsterdam',
            'ams3' => 'AMS3 - Amsterdam',
            'sfo1' => 'SFO1 - San Francisco',
            'sfo2' => 'SFO2 - San Francisco',
            'sfo3' => 'SFO3 - San Francisco',
            'sgp1' => 'SGP1 - Singapore',
            'lon1' => 'LON1 - London',
            'fra1' => 'FRA1 - Frankfurt',
            'tor1' => 'TOR1 - Toronto',
            'blr1' => 'BLR1 - Bangalore',
            'syd1' => 'SYD1 - Sydney',
        ];
    }

    public function getBaseUrl()
    {
        return implode('/', array_filter([
            'https://'.$this->settings['region'].'.digitaloceanspaces.com',
            $this->getBucket(),
            $this->getPathPrefix()
        ]));
    }
}
