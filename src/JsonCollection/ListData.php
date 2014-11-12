<?php

namespace JsonCollection;

/**
 * Class ListData
 * @package JsonCollection
 * @link http://amundsen.com/media-types/collection/format/
 * @link http://code.ge/media-types/collection-next-json/
 */
class ListData extends BaseEntity implements OptionAware
{

    use OptionContainer;

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
        return $this->multiple;
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
     * {@inheritdoc}
     */
    protected function getObjectData()
    {
        $data = [];
        if (!empty($this->options)) {
            $data = $this->getSortedObjectVars();
            $data = $this->filterNullValues($data);
        }
        return $data;
    }
}
