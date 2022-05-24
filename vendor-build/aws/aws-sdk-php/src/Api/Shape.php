<?php

namespace ExpressionEngine\Dependency\Aws\Api;

/**
 * Base class representing a modeled shape.
 */
class Shape extends AbstractModel
{
    /**
     * Get a concrete shape for the given definition.
     *
     * @param array    $definition
     * @param ShapeMap $shapeMap
     *
     * @return mixed
     * @throws \RuntimeException if the type is invalid
     */
    public static function create(array $definition, ShapeMap $shapeMap)
    {
        static $map = ['structure' => 'ExpressionEngine\\Dependency\\Aws\\Api\\StructureShape', 'map' => 'ExpressionEngine\\Dependency\\Aws\\Api\\MapShape', 'list' => 'ExpressionEngine\\Dependency\\Aws\\Api\\ListShape', 'timestamp' => 'ExpressionEngine\\Dependency\\Aws\\Api\\TimestampShape', 'integer' => 'ExpressionEngine\\Dependency\\Aws\\Api\\Shape', 'double' => 'ExpressionEngine\\Dependency\\Aws\\Api\\Shape', 'float' => 'ExpressionEngine\\Dependency\\Aws\\Api\\Shape', 'long' => 'ExpressionEngine\\Dependency\\Aws\\Api\\Shape', 'string' => 'ExpressionEngine\\Dependency\\Aws\\Api\\Shape', 'byte' => 'ExpressionEngine\\Dependency\\Aws\\Api\\Shape', 'character' => 'ExpressionEngine\\Dependency\\Aws\\Api\\Shape', 'blob' => 'ExpressionEngine\\Dependency\\Aws\\Api\\Shape', 'boolean' => 'ExpressionEngine\\Dependency\\Aws\\Api\\Shape'];
        if (isset($definition['shape'])) {
            return $shapeMap->resolve($definition);
        }
        if (!isset($map[$definition['type']])) {
            throw new \RuntimeException('Invalid type: ' . \print_r($definition, \true));
        }
        $type = $map[$definition['type']];
        return new $type($definition, $shapeMap);
    }
    /**
     * Get the type of the shape
     *
     * @return string
     */
    public function getType()
    {
        return $this->definition['type'];
    }
    /**
     * Get the name of the shape
     *
     * @return string
     */
    public function getName()
    {
        return $this->definition['name'];
    }
}
