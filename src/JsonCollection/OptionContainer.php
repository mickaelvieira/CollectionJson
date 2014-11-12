<?php

namespace JsonCollection;

/**
 * Class OptionContainer
 * @package JsonCollection
 */
trait OptionContainer
{
    /**
     * @var array
     * @link http://code.ge/media-types/collection-next-json/#array-options
     */
    protected $options = [];

    /**
     * @param \JsonCollection\Option|array $option
     * @return mixed
     */
    public function addOption($option)
    {
        if (is_array($option)) {
            $option = new Option($option);
        }
        if ($option instanceof Option) {
            array_push($this->options, $option);
        }
        return $this;
    }

    /**
     * @param array $set
     * @return mixed
     */
    public function addOptionSet(array $set)
    {
        foreach ($set as $option) {
            $this->addOption($option);
        }
        return $this;
    }

    /**
     * @return array
     */
    public function getOptionSet()
    {
        return $this->options;
    }

    /**
     * @return int
     */
    public function countOptions()
    {
        return count($this->options);
    }
}
