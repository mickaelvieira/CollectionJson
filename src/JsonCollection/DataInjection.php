<?php

namespace JsonCollection;

/**
 * Class DataInjection
 * @package JsonCollection
 */
trait DataInjection
{
    /**
     * @param array $data
     */
    public function inject(array $data = [])
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
