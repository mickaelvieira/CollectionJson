<?php

namespace JsonCollection;

/**
 * Class ListData
 * @package JsonCollection
 * @link http://amundsen.com/media-types/collection/format/
 * @link http://code.ge/media-types/collection-next-json/
 */
class ListData extends BaseEntity
{
    /**
     * @var bool
     * @link http://code.ge/media-types/collection-next-json/#property-multiple
     */
    protected $multiple;

    /**
     * @var string
     * @link http://code.ge/media-types/collection-next-json/#property-default
     */
    protected $default;

    /**
     * @var array
     * @link http://code.ge/media-types/collection-next-json/#array-options
     */
    protected $options = [];

    /**
     * @param boolean $multiple
     */
    public function setMultiple($multiple)
    {
        if (is_bool($multiple)) {
            $this->multiple = $multiple;
        }
    }

    /**
     * @return boolean
     */
    public function isMultiple()
    {
        return (bool)$this->multiple;
    }

    /**
     * @param string $default
     */
    public function setDefault($default)
    {
        if (is_string($default)) {
            $this->default = $default;
        }
    }

    /**
     * @return string
     */
    public function getDefault()
    {
        return $this->default;
    }

    /**
     * @param Option $option
     */
    public function addOption(Option $option)
    {
        array_push($this->options, $option);
    }

    /**
     * {@inheritdoc}
     */
    protected function getObjectData()
    {
        $data = array();
        if (!empty($this->options)) {
            $data = array_filter(
                $this->getSortedObjectVars(),
                function ($value) {
                    return !is_null($value);
                }
            );
        }

        //var_dump($data);

        return $data;
    }
}
