<?php

/*
 * This file is part of JsonCollection, a php implementation
 * of the Collection.next+JSON Media Type
 *
 * (c) Mickaël Vieira <contact@mickael-vieira.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JsonCollection;

use JsonCollection\Entity\Option;

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
     * @param \JsonCollection\Entity\Option|array $option
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
}
