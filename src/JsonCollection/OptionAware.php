<?php

namespace JsonCollection;

/**
 * Class OptionAware
 * @package JsonCollection
 */
interface OptionAware
{
    /**
     * @param Option $option
     */
    public function addOption(Option $option);

    /**
     * @param array $set
     * @return mixed
     */
    public function addOptionSet(array $set);

    /**
     * @return array
     */
    public function getOptionSet();
}
