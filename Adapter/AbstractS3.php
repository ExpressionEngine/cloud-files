<?php

namespace CloudFiles\Adapter;

use ExpressionEngine\Dependency\League\Flysystem;
use ExpressionEngine\Dependency\Aws;
use ExpressionEngine\Dependency\GuzzleHttp;
use ExpressionEngine\Dependency\Aws\S3\Exception\S3Exception;

abstract class AbstractS3 extends Flysystem\AwsS3v3\AwsS3Adapter
{
    /**
     * Get all the meta data of a file or directory.
     *
     * @param string $path
     *
     * @return false|array
     */
    public function getMetadata($path)
    {
        $metadata = parent::getMetadata($path);

        if ($metadata !== false) {
            return $metadata;
        }

        // AWS looks for metadata with a headObject request, this returns 404 (false) on directories
        if ($this->doesDirectoryExist($path)) {
            return ['type' => 'dir', 'path' => $path, 'size' => 0, 'timestamp' => null];
        }

        return false;
    }

    /**
     * Retrieve filesystem information for a given set of paths
     *
     * @param array $paths
     * @return array
     */
    public function eagerLoadPaths($paths = [])
    {
        if (empty($paths)) {
            return [];
        }

        $results = array_fill(0, count($paths), false);
        $commands = array_map(function ($path) {
            return $this->s3Client->getCommand('headObject', [
                'Bucket' => $this->bucket,
                'Key' => $this->applyPathPrefix($path)
            ] + $this->options);
        }, $paths);

        $pool = new Aws\CommandPool($this->s3Client, $commands, [
            'concurrency' => 10,
            // Invoke this function for each successful transfer
            'fulfilled' => function (
                Aws\ResultInterface $result,
                $iterKey,
                GuzzleHttp\Promise\PromiseInterface $aggregatePromise
            ) use ($paths, &$results) {
                $results[$iterKey] = $this->normalizeResponse($result->toArray(), $paths[$iterKey]);
            },
            // Invoke this function for each failed transfer
            'rejected' => function (
                Aws\Exception\AwsException $exception,
                $iterKey,
                GuzzleHttp\Promise\PromiseInterface $aggregatePromise
            ) use ($paths, &$results) {
                if ($this->is404Exception($exception)) {
                    $results[$iterKey] = \false;

                    if (!empty($this->listContents($paths[$iterKey]))) {
                        $directory = array_merge(
                            array_fill_keys(['path', 'basename', 'filename'], $paths[$iterKey]),
                            ['type' => 'dir', 'size' => 0, 'timestamp' => null]
                        );
                        $results[$iterKey] = $directory;
                    }
                } else {
                    throw $exception;
                }
            },
        ]);

        // Start the pool of requests and block until all are finished
        $promise = $pool->promise();
        $promise->wait();

        return array_combine($paths, $results);
    }

    /**
     * @return bool
     */
    private function is404Exception(S3Exception $exception)
    {
        $response = $exception->getResponse();
        if ($response !== null && $response->getStatusCode() === 404) {
            return \true;
        }
        return \false;
    }
}
