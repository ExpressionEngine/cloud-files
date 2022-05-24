<?php

require __DIR__ . '/vendor-build/autoload.php';

ee('Filesystem/Adapter')->registerAdapter('s3', [
    'name' => 'AWS S3',
    'class' => \CloudFiles\Adapter\AwsS3::class,
    'settings' => function($values) {
        return [
            [
                'title' => 'Key',
                'desc' => 'Enter your AWS S3 Key',
                'fields' => [
                    'url' => [
                        'type' => 'text',
                        'value' => $values['key'] ?? '',
                        'required' => true
                    ]
                ]
            ],
            [
                'title' => 'Secret',
                'desc' => 'Enter your AWS S3 Secret',
                'fields' => [
                    'url' => [
                        'type' => 'text',
                        'value' => $values['secret'] ?? '',
                        'required' => true
                    ]
                ]
            ],
            [
                'title' => 'Region',
                'desc' => 'Select the region for your AWS S3 Bucket',
                'fields' => [
                    'url' => [
                        'type' => 'dropdown',
                        'choices' => \CloudFiles\Adapter\AwsS3::listAvailableRegions(),
                        'value' => $values['region'] ?? '',
                        'required' => true
                    ]
                ]
            ],
            [
                'title' => 'Bucket Name',
                'desc' => 'Enter the name of your AWS S3 Bucket',
                'fields' => [
                    'url' => [
                        'type' => 'text',
                        'value' => $values['bucket'] ?? '',
                        'required' => true
                    ]
                ]
            ]
        ];
    }
]);

ee('Filesystem/Adapter')->registerAdapter('do_spaces', [
    'name' => 'Digital Ocean Spaces',
    'class' => \CloudFiles\Adapter\DigitalOcean::class,
]);

return array(
    'author' => 'ExpressionEngine',
    'author_url' => 'https://expressionengine.com/',
    'name' => 'Cloud Files',
    'description' => '',
    'version' => '1.0.0',
    'namespace' => 'CloudFiles',
    'settings_exist' => true,
);
