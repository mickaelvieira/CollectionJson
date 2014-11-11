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
     * @param Option $option
     */
    public function addOption(Option $option)
    {
        array_push($this->options, $option);
    }

    /**
     * @param array $set
     * @return mixed
     */
    public function addOptionSet(array $set)
    {
        foreach ($set as $option) {
            if ($option instanceof Option) {
                $this->addOption($option);
            }
        }
    }

    /**
     * @return array
     */
    public function getOptionSet()
    {
        return $this->options;
    }
}
