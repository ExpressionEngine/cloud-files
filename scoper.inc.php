<?php

/**
 * PHP-Scoper configuration file.
 *
 * @package   ExpressionEngine\ExpressionEngine
 * @copyright 2022 PacketTide LLC
 * @license
 * @link      https://expressionengine.com
 */

use Isolated\Symfony\Component\Finder\Finder;

return [
    'prefix' => 'ExpressionEngine\\Dependency',                       // string|null
    'finders' => [
        Finder::create()
            ->files()
            ->ignoreVCS(true)
            ->notName('/LICENSE|.*\\.md|.*\\.dist|Makefile|composer\\.json|composer\\.lock/')
            ->exclude([
                'bin',
                'bamarni',
                'doc',
                'docs',
                'test',
                'Test',
                'tests',
                'Tests',
                'vendor-bin',
            ])
            ->in('vendor'),
    ],                        // Finder[]
    'patchers' => [
        static function (string $filePath, string $prefix, string $content): string {
            if ($filePath === __DIR__ . '/vendor/aws/aws-sdk-php/src/Signature/SignatureV4.php') {
                $content = str_replace(
                    "const ISO8601_BASIC = 'ExpressionEngine\\\\Dependency\\\\",
                    "const ISO8601_BASIC = '",
                    $content
                );
            }else if ($filePath === __DIR__.'/vendor/aws/aws-sdk-php/src/functions.php') {
                $content = str_replace(
                    "defined('\\\\GuzzleHttp\\\\ClientInterface::",
                    "defined('".addslashes('\\'.$prefix)."\\\\GuzzleHttp\\\\ClientInterface::",
                    $content
                );
            }

            return $content;
        },
    ],                       // callable[]
    // 'files-whitelist' => [],                // string[]
    'whitelist' => [],                      // string[]
    #'expose-global-constants' => true,   // bool
    #'expose-global-classes' => true,     // bool
    #'expose-global-functions' => true,   // bool
    #'exclude-constants' => [],             // string[]
    #'exclude-classes' => [],               // string[]
    #'exclude-functions' => [],             // string[]
];
