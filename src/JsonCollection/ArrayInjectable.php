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
 * Interface DataInjectable
 * @package JsonCollection
 */
interface ArrayInjectable
{
    /**
     * @param array $data
     * @return mixed
     */
    public function inject(array $data);
}
