<?php

namespace JsonCollection;

/**
 * Class OptionAware
 * @package JsonCollection
 */
interface OptionAware
{
    /**
     * @param \JsonCollection\Option|array $option
     */
    public function addOption($option);

    /**
     * @param array $set
     * @return mixed
     */
    public function addOptionSet(array $set);

    /**
     * @return array
     */
    public function getOptionSet();

    /**
     * @return int
     */
    public function countOptions();
}
