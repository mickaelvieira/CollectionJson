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

/**
 * Class OptionAware
 * @package JsonCollection
 */
interface OptionAware
{
    /**
     * @param \JsonCollection\Entity\Option|array $option
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
}
