<?php
declare(strict_types = 1);

/*
 * This file is part of CollectionJson, a php implementation
 * of the Collection+JSON Media Type
 *
 * (c) Mickaël Vieira <contact@mickael-vieira.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CollectionJson;

use CollectionJson\Exception\CollectionJsonException;

use JsonSerializable;

/**
 * Class BaseEntity
 * @package CollectionJson
 */
abstract class BaseEntity implements JsonSerializable, ArrayConvertible
{
    /**
     * @var string
     */
    protected $wrapper;

    /**
     * @param array $data
     *
     * @return static
     */
    public static function fromArray(array $data)
    {
        [$props, $data] = self::getRequiredParameters($data);

        $object = count($props) > 0
            ? new static(...$props)
            : new static();

        foreach ($data as $key => $value) {
            // version is a constant
            // and according to the spec
            // it cannot be modified
            if ($key !== 'version') {
                $wither = sprintf('with%s', ucfirst(strtolower($key)));
                $adder  = sprintf('with%sSet', ucfirst(strtolower($key)));

                if (method_exists($object, $adder)) {
                    $object = $object->$adder($value);
                } elseif (method_exists($object, $wither)) {
                    $object = $object->$wither($value);
                } else {
                    throw new CollectionJsonException(
                        sprintf(
                            'Invalid schema! Could not inject entry "%s" into entity "%s"',
                            $key,
                            get_class($object)
                        )
                    );
                }
            }
        }

        return $object;
    }

    /**
     * @param string $json
     *
     * @return static
     */
    public static function fromJson($json)
    {
        $data = json_decode($json, true);
        $type = static::getObjectType();

        if (!$data || json_last_error() !== JSON_ERROR_NONE) {
            throw new \LogicException(sprintf('Invalid JSON: %s', json_last_error_msg()));
        }

        // unwrapping
        if (array_key_exists($type, $data)) {
            $data = $data[$type];
        }

        return self::fromArray($data);
    }

    /**
     * @param array $data
     *
     * @return array
     */
    private static function getRequiredParameters(array $data): array
    {
        $method = new \ReflectionMethod(static::class, '__construct');
        $params = $method->getParameters();

        $required = array_filter($params, function (\ReflectionParameter $param) {
            return !$param->isDefaultValueAvailable();
        });

        $props = [];
        foreach ($required as $item) {
            $name = $item->getName();
            $prop = $name === 'rels' ? 'rel' : $name;

            if (!array_key_exists($prop, $data)) {
                throw new CollectionJsonException(
                    sprintf('Property "%s" is missing to build "%s', $name, static::class)
                );
            }

            $props[] = $data[$prop];

            unset($data[$prop]);
        }

        return [$props, $data];
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        $data = $this->getObjectData();
        $data = $this->addWrapper($data);

        return $data;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $data = $this->getObjectData();
        $data = $this->addWrapper($data);

        return $this->recursiveToArray($data);
    }

    /**
     * @TODO this method should return a new entity
     * @return self
     */
    final public function wrap(): self
    {
        $this->wrapper = static::getObjectType();

        return $this;
    }

    /**
     * @param array $data
     *
     * @return array
     */
    final protected function filterEmptyArrays(array $data): array
    {
        return array_filter($data, function ($value) {
            return !(is_array($value) && empty($value));
        });
    }

    /**
     * @param array $data
     * @param array $whiteList
     *
     * @return array
     */
    final protected function filterNullValues(array $data, array $whiteList = []): array
    {
        return array_filter($data, function ($value, $key) use ($whiteList) {
            return (!is_null($value) || in_array($key, $whiteList, true));
        }, ARRAY_FILTER_USE_BOTH);
    }

    /**
     * @return string
     */
    final public static function getObjectType(): string
    {
        $tree = explode("\\", static::class);
        return strtolower(end($tree));
    }

    /** @noinspection MagicMethodsValidityInspection */
    /**
     * Avoiding having dynamic properties set up
     *
     * @param string $name
     * @param mixed $value
     *
     * @throws \LogicException
     */
    final public function __set($name, $value)
    {
        throw new \LogicException('Dynamic properties are not allowed');
    }

    /**
     * @return array
     */
    abstract protected function getObjectData(): array;

    /**
     * @param array $data
     * @return array
     */
    private function recursiveToArray(array $data): array
    {
        foreach ($data as &$value) {
            if (is_object($value) && $value instanceof ArrayConvertible) {
                $value = $value->toArray();
            } elseif (is_array($value)) {
                $value = $this->recursiveToArray($value);
            }
        }

        unset($value);

        return $data;
    }

    /**
     * @param array $data
     * @return array
     */
    private function addWrapper(array $data): array
    {
        if (is_string($this->wrapper)) {
            $data = [
                $this->wrapper => $data
            ];
        }
        return $data;
    }
}
