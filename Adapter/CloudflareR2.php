<?php

namespace CloudFiles\Adapter;

use ExpressionEngine\Dependency\Aws\S3\S3Client;
use ExpressionEngine\Dependency\League\Flysystem;
use ExpressionEngine\Library\Filesystem\Adapter\AdapterInterface;
use ExpressionEngine\Library\Filesystem\Adapter\AdapterTrait;
use ExpressionEngine\Service\Validation\ValidationAware;

class CloudflareR2 extends AbstractS3 implements AdapterInterface, ValidationAware
{
    use AdapterTrait;

    protected $_validation_rules = [
        'account_id' => 'required',
        'key' => 'required',
        'secret' => 'required',
        'bucket' => 'required',
        'url' => 'required',
    ];

    public function __construct($settings = [])
    {
        $this->settings = $settings;
        $client = new S3Client([
            'credentials' => [
                'key'    => $settings['key'],
                'secret' => $settings['secret']
            ],
            'region' => 'auto',
            'version' => 'latest',
            'endpoint' => "https://{$settings['account_id']}.r2.cloudflarestorage.com",
            'exception_class' => \ExpressionEngine\Dependency\Aws\S3\Exception\S3Exception::class
        ]);

        parent::__construct($client, $settings['bucket']);
    }

    public static function getSettingsForm($settings)
    {
        return [
            [
                'title' => 'Account ID',
                'desc' => 'Enter your Cloudflare R2 Account ID',
                'fields' => [
                    'adapter_settings[account_id]' => [
                        'type' => 'text',
                        'value' => $settings['account_id'] ?? '',
                        'required' => true
                    ]
                ]
            ],
            [
                'title' => 'Key',
                'desc' => 'Enter your Cloudflare R2 Key',
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
                'desc' => 'Enter your Cloudflare R2 Secret',
                'fields' => [
                    'adapter_settings[secret]' => [
                        'type' => 'text',
                        'value' => $settings['secret'] ?? '',
                        'required' => true
                    ]
                ]
            ],
            [
                'title' => 'Bucket Name',
                'desc' => 'Enter the name of your Cloudflare R2 Bucket',
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
                'desc' => 'Enter the path inside your Cloudflare R2 Bucket',
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
                'desc' => 'Enter the url used to access your Cloudflare R2 Bucket',
                'fields' => [
                    'url' => [
                        'type' => 'text',
                        'value' => $settings['url'] ?? '',
                        'required' => true
                    ]
                ]
            ]
        ];
    }


    public function getBaseUrl()
    {
        return implode('/', array_filter([
            'https://' . $this->settings['account_id'] . '.r2.cloudflarestorage.com',
            $this->getBucket(),
            $this->getPathPrefix()
        ]));
    }
}
