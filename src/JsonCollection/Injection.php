<?php

/*
 * This file is part of JsonCollection, a php implementation
 * of the Collection+JSON Media Type
 *
 * (c) Mickaël Vieira <contact@mickael-vieira.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JsonCollection;

/**
 * Class DataInjection
 * @package JsonCollection
 */
trait Injection
{
    /**
     * @param array $data
     */
    public function inject(array $data)
    {
        foreach ($data as $key => $value) {
            $setter = "set" . $this->underscoreToCamelCase($key);
            if (method_exists($this, $setter)) {
                $this->$setter($value);
            }
        }
    }

    /**
     * @param string $key
     * @return string
     */
    private function underscoreToCamelCase($key)
    {
        return implode(
            "",
            array_map(
                "ucfirst",
                preg_split("/_/", strtolower($key))
            )
        );
    }
}
