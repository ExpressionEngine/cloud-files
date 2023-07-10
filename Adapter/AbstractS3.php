<?php

namespace CloudFiles\Adapter;

use ExpressionEngine\Dependency\League\Flysystem;

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
        if (!empty($this->listContents($path))) {
            return ['type' => 'dir', 'path' => $path, 'size' => 0, 'timestamp' => null];
        }

        return false;
    }
}
